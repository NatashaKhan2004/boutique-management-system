<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<table class="profile-table">
    <tr>
        <th colspan="3" class="profile-header">
            <h1>Boutique Management System</h1>
        </th>
    </tr>
    <tr>
        <td colspan="3" class="navbar">
            <a href="index.php">Home</a> 
            <a href="products.html">Products</a>
            <a href="addProduct.html">Add Products</a> 
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
        </td>
    </tr>

    <tr>
        <td width="20%" bgcolor="#e6f0fa">
            <h3>Our Boutique</h3>
            <p><b>Attiqa, Natasha & Tooba</b></p>
            <p>Three friends with a passion for fashion</p>
            <p>Since 2026</p>
            <p>Islamabad, Pakistan</p>
        </td>
        <td width="60%" bgcolor="lightpink">
            <h2>Welcome to Our Boutique</h2>
            <p>By Attiqa, Natasha & Tooba</p>
            
            <table> 
                <tr>
                    <th>About Boutique</th>
                    <td>We offer beautiful dresses for bridal, party and casual wear. Custom stitching available for perfect fit.</td>
                </tr>
                <tr>
                    <th>Services</th>
                    <td>
                        Bridal Dresses<br>
                        Party Wear<br>
                        Casual Dresses<br>
                        Custom Stitching
                    </td>
                </tr>
                <tr>
                    <th>Summer Sale</th>
                    <td>20% Off on all dresses | Free stitching on bridal</td>
                </tr>
            </table>
        </td>
        <td width="20%" bgcolor="#e6f0fa">
            <h3>Highlights</h3>
            Best Selling Dresses<br>
            New Summer Collection<br>
            Discount Offers<br>
            Eid Special
        </td>
    </tr>

    <tr>
        <td colspan="3" bgcolor="lightgrey" style="text-align: center; padding: 15px;">
            <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
            <p>Email: boutique@gmail.com | Phone: 0318-2345567 | Islamabad, Pakistan</p>
        </td>
    </tr>
</table>

</body>
</html>
