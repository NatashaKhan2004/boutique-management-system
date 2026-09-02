<?php
session_start();
include 'db.php';

// Auth Guard Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<table class="profile-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <tr>
        <th colspan="3" class="profile-header" style="padding: 20px 0; background: #f8f9fa;">
            <h1>Boutique Management System</h1>
        </th>
    </tr>

    <tr>
        <td width="20%" bgcolor="#e6f0fa" style="padding: 15px; vertical-align: top;">
            <h3>Our Boutique</h3>
            <p><b>Attiqa, Natasha & Tooba</b></p>
            <p>Three friends with a passion for fashion</p>
            <p>Since 2026</p>
            <p>Islamabad, Pakistan</p>
        </td>
        <td width="60%" bgcolor="lightpink" style="padding: 15px; vertical-align: top;">
            <h2>Welcome to Our Boutique</h2>
            <p>By Attiqa, Natasha & Tooba</p>
            
            <table style="width: 100%; margin-top: 15px; background: white; padding: 10px; border-radius: 8px;"> 
                <tr>
                    <th style="text-align: left; padding: 8px; width: 30%;">About Boutique</th>
                    <td style="padding: 8px;">We offer beautiful dresses for bridal, party and casual wear. Custom stitching available for perfect fit.</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px;">Services</th>
                    <td style="padding: 8px;">
                        Bridal Dresses<br>
                        Party Wear<br>
                        Casual Dresses<br>
                        Custom Stitching
                    </td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 8px;">Summer Sale</th>
                    <td style="padding: 8px;">20% Off on all dresses | Free stitching on bridal</td>
                </tr>
            </table>
        </td>
        <td width="20%" bgcolor="#e6f0fa" style="padding: 15px; vertical-align: top;">
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
            <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
        </td>
    </tr>
</table>

<script src="js/storage.js"></script>
</body>
</html>
