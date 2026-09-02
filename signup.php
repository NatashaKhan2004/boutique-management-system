<?php
session_start();
include 'db.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Password ko hash karein
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // User exist check karein
        $checkUser = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $checkUser->bind_param("ss", $email, $username);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or Email already exists!";
        } else {
            // New user insert karein
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful! <a href='login.php' style='color: teal; font-weight: bold;'>Click here to Login</a>";
            } else {
                $error = "Registration failed! Try again.";
            }
            $stmt->close();
        }
        $checkUser->close();
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
    <title>Signup - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

    <main class="login-main">
        <h2>Create Account</h2>

        <?php if (!empty($message)): ?>
            <p style="color: green; text-align: center; margin-bottom: 15px;"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="signup.php" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="buttons">
                <button type="submit" class="submit-btn">Sign Up</button>
                <button type="reset" class="reset-btn">Reset</button>
            </div>
        </form>

        <p style="margin-top: 20px; font-weight: 500;">
            Already have an account? <a href="login.php" style="color: teal; text-align: center;">Login here</a>
        </p>
    </main>

<script src="js/storage.js"></script>
</body>
</html>
