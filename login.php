<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // User ko database se fetch karein
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Hashed Password Verify Karein
            if (password_verify($password, $user['password'])) {
                // Session set karein
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Index page par redirect karein
                header("Location: index.html");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "No user found with this email!";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Boutique Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="login-main">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="login-form">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="buttons">
                <button type="submit" class="submit-btn">Login</button>
                <button type="reset" class="reset-btn">Reset</button>
            </div>
        </form>

        <p style="margin-top: 20px; font-weight: 500;">
            Don't have an account? <a href="signup.php" style="color: teal;">Sign up here</a>
        </p>
    </main>
</body>
</html>