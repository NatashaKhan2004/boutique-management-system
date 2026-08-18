<?php
session_start();
include 'db.php';

$message = "";
$error = "";

// Cart se item remove karne ke liye logic
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $remove_id = $_GET['id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: cart.php");
    exit();
}

// Checkout Submit Karne Ka Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    if (empty($_SESSION['cart'])) {
        $error = "Your cart is empty!";
    } else {
        $custName = trim($_POST['custName']);
        $custPhone = trim($_POST['custPhone']);
        $custAddress = trim($_POST['custAddress']);
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        $grandTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }

        // Database me order insert karein
        $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, phone, address, total_amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $userId, $custName, $custPhone, $custAddress, $grandTotal);

        if ($stmt->execute()) {
            $_SESSION['cart'] = array(); // Cart empty karein
            $message = "🎉 Order placed successfully!";
        } else {
            $error = "Failed to place order: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .cart-container { 
            max-width: 800px; 
            margin: 30px auto; 
            padding: 20px; 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        .remove-btn { background: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .grand-total { font-size: 1.3em; text-align: right; font-weight: bold; margin-bottom: 20px; }
        
        .checkout-section {
            margin-top: 25px;
            padding: 20px;
            background: #fdfbf7;
            border: 1px solid #e0d6c8;
            border-radius: 8px;
        }
        .checkout-section h3 {
            margin-bottom: 15px;
            color: #4a3e3d;
            border-bottom: 2px solid #e0d6c8;
            padding-bottom: 8px;
        }
        #checkoutForm {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 450px;
        }
        #checkoutForm input, #checkoutForm textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        #checkoutForm button {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }
        #checkoutForm button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.html">Products</a>
    <a href="addproduct.php">Add Products</a>
    <a href="orders.html">Orders</a>
    <a href="cart.php">Cart</a>
    <a href="about.php">About Us</a>
    <a href="contactus.html">Contact Us</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: white; font-weight: 600; margin-left: 10px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" style="color: tomato; font-weight: bold; margin-left: 10px;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>

<div class="cart-container">
    <h2>Shopping Cart</h2>

    <?php if (!empty($message)): ?>
        <p style="color: green; text-align: center; font-weight: bold; padding: 10px; background: #e6ffe6; border-radius: 5px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold; padding: 10px; background: #ffe6e6; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grandTotal = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $grandTotal += $subtotal;
                    echo "<tr>
                            <td>".htmlspecialchars($item['name'])."</td>
                            <td>$".number_format($item['price'], 2)."</td>
                            <td>".htmlspecialchars($item['quantity'])."</td>
                            <td>$".number_format($subtotal, 2)."</td>
                            <td><a href='cart.php?action=remove&id=".$id."' class='remove-btn'>Remove</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Your cart is empty!</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="grand-total">
        Grand Total: $<?php echo number_format($grandTotal, 2); ?>
    </div>

    <!-- Checkout Section -->
    <?php if (!empty($_SESSION['cart'])): ?>
    <div class="checkout-section">
        <h3>Customer Details for Checkout</h3>
        <form action="cart.php" method="POST" id="checkoutForm">
            <input type="text" name="custName" placeholder="Full Name" required>
            <input type="text" name="custPhone" placeholder="Phone Number" required>
            <textarea name="custAddress" placeholder="Delivery Address" required></textarea>
            <button type="submit" name="place_order">Place Order</button>
        </form>
    </div>
    <?php endif; ?>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: 0318-2345567 | Islamabad, Pakistan</p>
</div>

</body>
</html>
