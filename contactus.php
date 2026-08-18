<?php
session_start();
include 'db.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['userName']);
    $email = trim($_POST['userEmail']);
    $subject = trim($_POST['userSubject']);
    $userMsg = trim($_POST['userMessage']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($userMsg)) {
        // Save message to MySQL database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $userMsg);

        if ($stmt->execute()) {
            $message = "✅ Thank you $name! We have received your message and will respond to $email shortly.";
        } else {
            $error = "❌ Failed to send message: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "❌ Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="products.html">Products</a>
    <a href="addproduct.php">Add Products</a>
    <a href="orders.html">Orders</a>
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

<div class="contact-main">
    <h2>📞 Contact Us</h2>

    <?php if (!empty($message)): ?>
        <p style="color: green; text-align: center; font-weight: bold; padding: 10px; background: #e6ffe6; border-radius: 5px;"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold; padding: 10px; background: #ffe6e6; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class="contact-form-wrapper"> 
        <form action="contactus.php" method="POST" class="contact-form" id="contactForm">
            <input type="text" name="userName" placeholder="Your Full Name" required>
            <input type="email" name="userEmail" placeholder="Your Email Address" required>
            <input type="text" name="userSubject" placeholder="Subject" required>
            <textarea name="userMessage" rows="5" placeholder="Your Message" style="padding: 12px; border-radius: 8px; border: 1px solid gray; font-size: 1em; width: 100%; box-sizing: border-box;" required></textarea>
            
            <div style="display: flex; gap: 15px; margin-top: 10px;">
                <button type="submit" class="submit-btn" style="flex: 1;">📤 Send Message</button>
                <button type="reset" class="reset-btn" style="flex: 1;">🗑️ Clear Form</button>
            </div>
        </form>
    </div>
    
    <div style="margin-top: 30px; padding: 20px; background: rgba(0,0,0,0.05); border-radius: 10px;">
        <h3 style="color: brown; font-family: 'Dancing Script', cursive;">📍 Get in Touch</h3>
        <table width="100%" border="0">
            <tr>
                <td width="25%"><b>🏠 Address:</b></td>
                <td>Islamabad, Pakistan</td>
                <td width="25%"><b>📧 Email:</b></td>
                <td>boutique@gmail.com</td>
            </tr>
            <tr>
                <td><b>📞 Phone:</b></td>
                <td>0318-2345567</td>
                <td><b>⏰ Hours:</b></td>
                <td>Mon - Sat (10AM - 8PM)</td>
            </tr>
        </table>
    </div>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
</div>

</body>
</html>
