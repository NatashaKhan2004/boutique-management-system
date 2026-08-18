<?php
$host = "localhost";
$user = "root";
$pass = ""; // Default XAMPP MySQL password empty hota hai
$dbname = "boutique_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>