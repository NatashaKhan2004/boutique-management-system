<?php
session_start();
include 'db.php';

// Database se orders fetch karne ki query
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .orders-container { max-width: 900px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f4f4f4; }
        .items-list { margin: 0; padding-left: 15px; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.html">Products</a>
    <a href="addproduct.php">Add Products</a>
    <a href="orders.php">Orders</a>
    <a href="cart.php">Cart</a>
    <a href="about.php">About Us</a>
    <a href="contactus.php">Contact Us</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: white; font-weight: 600; margin-left: 10px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" style="color: tomato; font-weight: bold; margin-left: 10px;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>

<div class="orders-container">
    <h2>All Placed Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Phone / Address</th>
                <th>Total ($)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $orderId = "ORD-" . str_pad($row['id'], 5, "0", STR_PAD_LEFT);
                    $custName = htmlspecialchars($row['customer_name']);
                    $phone = htmlspecialchars($row['phone']);
                    $address = htmlspecialchars($row['address']);
                    $total = number_format($row['total_amount'], 2);
                    $date = date("Y-m-d H:i", strtotime($row['created_at']));

                    echo "<tr>
                            <td><b>{$orderId}</b></td>
                            <td>{$custName}</td>
                            <td>{$phone}<br><small>{$address}</small></td>
                            <td><b>\${$total}</b></td>
                            <td>{$date}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No orders placed yet!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
</div>

</body>
</html>
