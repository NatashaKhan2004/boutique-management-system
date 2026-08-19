<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php include 'navbar.php'; ?>
<body>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color: white; font-weight: 600; margin-left: 10px;">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" style="color: tomato; font-weight: bold;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    <?php endif; ?>
</div>

<div class="home-container">
    <div class="welcome-section">
        <h2>Welcome to Our Boutique</h2>
        <p>We provide the finest Bridal, Party, and Casual dresses for our valued customers.</p>
        <h3>Featured Products</h3>
    </div>

    <div class="product-gallery">
        <img id="sliderImage" class="product-img" src="https://i.pinimg.com/736x/bc/b5/87/bcb587f570686f2aaa308a76a2371a1f.jpg" alt="Dress 1">
    </div>

    <div class="button-wrapper">
        <button class="btn-play-pause" onclick="startSlider()">▶ PLAY</button>
        <button class="btn-play-pause" onclick="stopSlider()">⏸ PAUSE</button>
    </div>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: +923479130544 | Islamabad, Pakistan</p>
</div>

<script>
let images = [
    "https://i.pinimg.com/736x/bc/b5/87/bcb587f570686f2aaa308a76a2371a1f.jpg",
    "https://i.pinimg.com/736x/dd/ab/0f/ddab0f3ae382eba51c3a24526ce823a8.jpg",
    "https://i.pinimg.com/1200x/5d/58/2e/5d582e90125f0e174d43da1deed675ce.jpg",
    "https://i.pinimg.com/736x/fe/99/00/fe990030704be07268bd90d19c8d58a3.jpg",
    "https://i.pinimg.com/736x/3d/bb/1b/3dbb1b8c9e662d8cf1718a5d3352880b.jpg"
];

let currentIndex = 0;
let interval;

function updateOneImage() {
    let img = document.getElementById("sliderImage");
    img.src = images[currentIndex];
    currentIndex = (currentIndex + 1) % images.length;
}

function startSlider() {
    clearInterval(interval);
    interval = setInterval(updateOneImage, 2000);
}

function stopSlider() {
    clearInterval(interval);
}

currentIndex = 0;
updateOneImage();
interval = setInterval(updateOneImage, 2000);
</script>

</body>
</html>
