<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = array_sum(array_column($_SESSION['cart'] ?? [], 'quantity'));
?>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="addproduct.php">Add Products</a>
    <a href="orders.php">Orders</a>
    <a href="cart.php">Cart (<?php echo $cart_count; ?>)</a>
    <a href="about.php">About Us</a>
    <a href="contactus.php">Contact Us</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: white; font-weight: 600; margin-left: 15px;">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span>
        <a href="logout.php" style="color: #ff6b6b; font-weight: bold; margin-left: 10px;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>