<?php
session_start();
include 'db.php';

// Fetch order success message from checkout session
$order_success = $_SESSION['order_success'] ?? "";
unset($_SESSION['order_success']);

// Fetch all orders with items
$sql = "SELECT o.*, GROUP_CONCAT(CONCAT(p.name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS item_details 
        FROM orders o 
        LEFT JOIN order_items oi ON o.id = oi.order_id 
        LEFT JOIN products p ON oi.product_id = p.id 
        GROUP BY o.id 
        ORDER BY o.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .orders-container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .orders-table th, .orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .orders-table th {
            background-color: #008cba;
            color: white;
        }
        .orders-table tr:hover { background-color: #f9f9f9; }
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="orders-container">
    <h2>All Placed Orders</h2>

    <?php if (!empty($order_success)): ?>
        <div class="success-msg"><?php echo htmlspecialchars($order_success); ?></div>
    <?php endif; ?>

    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Email / Phone</th>
                <th>Shipping Address</th>
                <th>Items Ordered</th>
                <th>Total Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><b><?php echo htmlspecialchars($row['customer_name']); ?></b></td>
                        <td>
                            <?php echo htmlspecialchars($row['email']); ?><br>
                            <small><?php echo htmlspecialchars($row['phone']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['item_details'] ?? 'N/A'); ?></td>
                        <td><b>PKR <?php echo number_format($row['total_amount'], 2); ?></b></td>
                        <td><small><?php echo $row['created_at'] ?? 'Just now'; ?></small></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No orders placed yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="js/storage.js"></script>
</body>
</html>
