<?php
include 'db.php';

echo "<h2>Boutique System Users:</h2>";
$users = $conn->query("SELECT id, username, email FROM users");
if ($users && $users->num_rows > 0) {
    while ($row = $users->fetch_assoc()) {
        echo "ID: " . $row["id"] . " | User: " . $row["username"] . " | Email: " . $row["email"] . "<br>";
    }
} else {
    echo "No users found.<br>";
}

echo "<h2>Boutique Products:</h2>";
$products = $conn->query("SELECT id, name, price, description FROM products");
if ($products && $products->num_rows > 0) {
    while ($row = $products->fetch_assoc()) {
        echo "ID: " . $row["id"] . " | Name: " . $row["name"] . " | Price: PKR " . $row["price"] . " | Description: " . $row["description"] . "<br>";
    }
} else {
    echo "No products found.<br>";
}

$conn->close();
?>