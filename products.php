<?php
session_start();
include 'db.php';

// Cart initialization
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$msg = "";

// Handle Add to Cart / Buy
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $prod = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($prod) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $prod['id'],
                'name' => $prod['name'],
                'price' => $prod['price'],
                'quantity' => 1
            ];
        }

        // Deduct stock if stock column exists
        $conn->query("UPDATE products SET stock = stock - 1 WHERE id = $product_id AND stock > 0");

        $msg = "Product added to cart successfully!";
    }
}

// Handle Delete Product
if (isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
        $msg = "Product deleted successfully.";
    }
    $stmt->close();
}

// Fetch products
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 30px 20px;
        }
        .product-card {
            background: rgba(255, 255, 255, 0.95);
            width: 250px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card h3 {
            margin-top: 0;
            color: #333;
            font-size: 20px;
        }
        .product-card .price {
            color: #d9534f;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .product-card .desc {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
            min-height: 40px;
        }
        .btn-group-card {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }
        .btn-buy {
            flex: 1;
            background-color: #28a745;
            color: white;
            border: none;
            padding: 9px 5px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }
        .btn-buy:hover { background-color: #218838; }
        .btn-delete {
            flex: 1;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 9px 5px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }
        .btn-delete:hover { background-color: #c82333; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="user-status-bar" style="text-align: right; padding: 10px 20px; background: #333;">
    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: white; font-weight: 600; margin-left: 10px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" style="color: tomato; font-weight: bold; margin-left: 10px;">Logout</a>
    <?php else: ?>
        <a href="login.php" style="color: white; margin-right: 10px;">Login</a>
        <a href="signup.php" style="color: white;">Signup</a>
    <?php endif; ?>
</div>

<h2 style="text-align: center; margin-top: 20px; color: #333; font-family: cursive, sans-serif; font-size: 32px;">Our Product Collection</h2>

<?php if (!empty($msg)): ?>
    <p style="color: green; text-align: center; font-weight: bold; background: #e6ffe6; padding: 10px; max-width: 400px; margin: 10px auto; border-radius: 5px;"><?php echo $msg; ?></p>
<?php endif; ?>

<div class="products-container">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <div>
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="desc"><?php echo htmlspecialchars($row['description'] ?? 'No description available.'); ?></p>
                    <p class="price">Price: PKR <?php echo number_format($row['price'], 2); ?></p>
                </div>

                <div class="btn-group-card">
                    <form action="products.php" method="POST" style="flex: 1;">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn-buy">Buy / Add Cart</button>
                    </form>

                    <form action="products.php" method="POST" style="flex: 1;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_product" class="btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align: center; width: 100%; font-size: 18px; color: #555;">No products found.</p>
    <?php endif; ?>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
</div>

<script src="js/storage.js"></script>
</body>
</html>
