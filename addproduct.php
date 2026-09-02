<?php
session_start();
include 'db.php';

// Protected Route: Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

// Form Submission Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    $stock = intval($_POST['stock']);
    $description = trim($_POST['description']);

    if (!empty($name) && $price > 0 && !empty($category) && $stock >= 0 && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, category, stock, description) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt === false) {
            $error = "Database Error: " . $conn->error;
        } else {
            $stmt->bind_param("sdsis", $name, $price, $category, $stock, $description);

            if ($stmt->execute()) {
                $message = "Product has been added successfully.";
            } else {
                $error = "Execution Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        $error = "Please fill in all required fields correctly.";
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
    <style>
        .form-card {
            max-width: 450px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-submit {
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
        .btn-submit:hover { background: #218838; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="form-card">
    <h2 style="text-align: center; margin-bottom: 20px;">Add New Product</h2>

    <?php if (!empty($message)): ?>
        <p style="color: green; text-align: center; font-weight: bold; background: #e6ffe6; padding: 10px; border-radius: 5px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold; background: #ffe6e6; padding: 10px; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="addproduct.php" method="POST">
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" required placeholder="e.g. Lawn Embroidered Suit">
        </div>

        <div class="form-group">
            <label>Category</label>
            <input type="text" name="category" required placeholder="e.g. Unstitched, Ready to Wear">
        </div>

        <div class="form-group">
            <label>Price (PKR)</label>
            <input type="number" step="0.01" name="price" required placeholder="e.g. 4500">
        </div>

        <div class="form-group">
            <label>Available Stock / Quantity</label>
            <input type="number" name="stock" min="1" required placeholder="e.g. 10">
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required placeholder="Enter product details..."></textarea>
        </div>

        <button type="submit" name="add_product" class="btn-submit">Add Product</button>
    </form>
</div>

<script src="js/storage.js"></script>
</body>
</html>
