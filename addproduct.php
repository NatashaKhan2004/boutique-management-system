<?php
session_start();
include 'db.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['productName']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $category = trim($_POST['category']);

    if (!empty($name) && !empty($price) && !empty($quantity) && !empty($category)) {
        // Database me Product Insert Karein
        $stmt = $conn->prepare("INSERT INTO products (name, price, stock, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $name, $price, $quantity, $category);

        if ($stmt->execute()) {
            $message = "✅ Product Added Successfully!";
        } else {
            $error = "❌ Failed to add product: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.html">Products</a>
    <a href="addproduct.php">Add Products</a>
    <a href="orders.html">Orders</a>
    <a href="cart.html">Cart</a>
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

<div class="cart-main"> 
    <h2>Add New Product</h2>

    <?php if (!empty($message)): ?>
        <p style="color: green; text-align: center; margin-bottom: 15px; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; margin-bottom: 15px; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="addproduct.php" method="POST" class="product-form" id="productForm">
        <label>Product Name</label>
        <input type="text" name="productName" placeholder="Enter product name" required>

        <label>Price ($)</label>
        <input type="number" step="0.01" name="price" placeholder="Enter price" required>

        <label>Quantity</label>
        <input type="number" name="quantity" placeholder="Enter quantity" required>

        <label>Category</label>
        <input type="text" name="category" placeholder="Enter category" required>

        <div class="buttons">
            <button class="checkout-btn" type="submit">Add Product</button>
            <button class="reset-btn" type="reset">Reset</button>
        </div>
    </form>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: 0318-2345567 | Islamabad, Pakistan</p>
</div>

</body>
</html>
