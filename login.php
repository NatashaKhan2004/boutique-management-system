<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Sir's Instruction: Removed plain text check ($password === $user['password'] ||)
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['login_success'] = "Login Successful! Welcome, " . $user['username'];
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "User not found!";
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
    <link rel="stylesheet" href="style.css">
    <style>
        .login-card {
            max-width: 420px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-family: cursive, sans-serif;
            font-size: 32px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-login {
            flex: 1;
            background-color: #008cba;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-reset {
            flex: 1;
            background-color: #ff5733;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
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

<div class="login-card">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold; padding: 10px; background: #ffe6e6; border-radius: 5px; margin-bottom: 15px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="e.g. salma@gmail.com">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter password">
        </div>

        <div class="btn-group">
            <button type="submit" name="login" class="btn-login">Login</button>
            <button type="reset" class="btn-reset">Reset</button>
        </div>

        <p style="text-align: center; margin-top: 15px;">
            Don't have an account? <a href="signup.php" style="color: #008cba; font-weight: bold;">Sign up here</a>
        </p>
    </form>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
</div>

<script src="js/storage.js"></script>
</body>
</html>
