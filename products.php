<?php
session_start();
include 'db.php';

$message = "";
$error = "";

// 1. Delete Product Logic
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        $message = "✅ Product deleted successfully!";
    } else {
        $error = "❌ Failed to delete product: " . $conn->error;
    }
    $stmt->close();
}

// 2. Add to Cart Logic (PHP Session based)
if (isset($_GET['action']) && $_GET['action'] == 'add_to_cart' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($product = $result->fetch_assoc()) {
        if ($product['stock'] > 0) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = array(
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
                );
            }
            $message = "🛒 " . htmlspecialchars($product['name']) . " added to cart!";
        } else {
            $error = "❌ Sorry, this item is out of stock!";
        }
    }
    $stmt->close();
}

// Fetch all products from MySQL database
$query = "SELECT * FROM products ORDER BY id DESC";
$products_result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .products-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 30px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            width: 240px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .product-card h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .product-card p {
            margin: 5px 0;
            color: #666;
        }

        .product-card .price {
            font-weight: bold;
            color: #d9534f;
            font-size: 1.1em;
        }

        .btn-add {
            background-color: #008cba;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-add:hover {
            background-color: #005f73;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            margin-top: 10px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background-color: #a71d2a;
        }

        .btn-disabled {
            background-color: #ccc;
            color: #666;
            padding: 8px 15px;
            margin-top: 10px;
            border-radius: 5px;
            display: inline-block;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
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

<h1 style="text-align: center; margin-top: 20px; font-family: cursive;">Our Products</h1>

<?php if (!empty($message)): ?>
    <p style="color: green; text-align: center; font-weight: bold; margin-top: 10px;"><?php echo $message; ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red; text-align: center; font-weight: bold; margin-top: 10px;"><?php echo $error; ?></p>
<?php endif; ?>

<div id="productsContainer" class="products-grid">
    <?php if ($products_result && $products_result->num_rows > 0): ?>
        <?php while ($row = $products_result->fetch_assoc()): ?>
            <div class="product-card">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>Category: <b><?php echo htmlspecialchars($row['category']); ?></b></p>
                <p class="price">Price: $<?php echo number_format($row['price'], 2); ?></p>
                <p>Available Stock: <b><?php echo htmlspecialchars($row['stock']); ?></b></p>

                <?php if ($row['stock'] > 0): ?>
                    <a href="products.php?action=add_to_cart&id=<?php echo $row['id']; ?>" class="btn-add">Add to Cart</a>
                <?php else: ?>
                    <span class="btn-disabled">Out of Stock</span>
                <?php endif; ?>

                <a href="products.php?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="font-size: 1.2em; font-weight: bold;">No products added yet!</p>
    <?php endif; ?>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: 0318-2345567 | Islamabad, Pakistan</p>
</div>

</body>
</html>
