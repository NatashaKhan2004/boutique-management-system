<?php
session_start();
include 'db.php';

if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $customer_name = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    if (!empty($customer_name) && !empty($email) && !empty($address) && !empty($phone)) {
        
        $total_price = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $user_id = $_SESSION['user_id'] ?? NULL;

        $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, email, phone, address, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("issssd", $user_id, $customer_name, $email, $phone, $address, $total_price);

            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;
                $stmt->close();

                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                if ($item_stmt) {
                    foreach ($_SESSION['cart'] as $prod_id => $item) {
                        $item_stmt->bind_param("iiid", $order_id, $prod_id, $item['quantity'], $item['price']);
                        $item_stmt->execute();
                    }
                    $item_stmt->close();
                }

                $_SESSION['cart'] = [];
                $_SESSION['order_success'] = "Order #$order_id placed successfully!";
                header("Location: orders.php");
                exit();
            } else {
                $error = "Execution Error: " . $stmt->error;
            }
        } else {
            $error = "Database Error: " . $conn->error;
        }
    } else {
        $error = "Please fill in all shipping details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-card {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-confirm {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="checkout-card">
    <h2>Checkout & Shipping Details</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold; background: #ffe6e6; padding: 10px; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="checkout.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="customer_name" required placeholder="e.g. Natasha Khan">
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="e.g. natasha@gmail.com">
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" required placeholder="e.g. 03001234567">
        </div>

        <div class="form-group">
            <label>Shipping Address</label>
            <textarea name="address" rows="3" required placeholder="Enter full address"></textarea>
        </div>

        <button type="submit" name="place_order" class="btn-confirm">Confirm Order</button>
    </form>
</div>

<script src="js/storage.js"></script>
</body>
</html>
