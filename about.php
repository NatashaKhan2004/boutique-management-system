<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Boutique Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="about-main">
    <h2>✨ About Our Boutique ✨</h2>
    <hr>
    
    <p><b>Your destination for elegant bridal, party and casual dresses. Quality stitching, perfect fit, and designs you'll love.</b></p>
    
    <!-- Dress Images Gallery -->
    <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin: 20px 0;">
        <div style="text-align: center;">
            <img src="https://i.pinimg.com/736x/bc/b5/87/bcb587f570686f2aaa308a76a2371a1f.jpg" width="200" height="200" style="border-radius: 10px; object-fit: cover;">
            <p style="margin-top: 5px;"><b>Bridal Dress</b></p>
        </div>
        <div style="text-align: center;">
            <img src="https://i.pinimg.com/736x/dd/ab/0f/ddab0f3ae382eba51c3a24526ce823a8.jpg" width="200" height="200" style="border-radius: 10px; object-fit: cover;">
            <p style="margin-top: 5px;"><b>Party Wear</b></p>
        </div>
        <div style="text-align: center;">
            <img src="https://i.pinimg.com/1200x/5d/58/2e/5d582e90125f0e174d43da1deed675ce.jpg" width="200" height="200" style="border-radius: 10px; object-fit: cover;">
            <p style="margin-top: 5px;"><b>Casual Dress</b></p>
        </div>
    </div>
    
    <br>
    
    <h3>📖 Our Story</h3>
    <p>Founded in 2026 by three passionate fashion lovers - <b>Attiqa, Natasha & Tooba</b>, our boutique started with a simple dream: to make every woman feel beautiful and confident in her own skin.</p>
    <p>What began as a small home-based business has now grown into a beloved boutique brand in Islamabad, Pakistan.</p>
    
    <br>
    
    <h3>🎯 Our Mission</h3>
    <p>To provide high-quality, fashionable dresses at affordable prices while ensuring every customer leaves with a smile.</p>
    
    <br>
    
    <h3>🛍️ Our Services</h3>
    <ul>
        <li>👰 Bridal Dresses - Stunning collections for your special day</li>
        <li>💃 Party Wear - Elegant dresses for every celebration</li>
        <li>👗 Casual Dresses - Comfortable yet stylish everyday wear</li>
        <li>✂️ Custom Stitching - Get your dream dress stitched perfectly</li>
    </ul>
    
    <br>
    
    <h3>📊 Our Achievements</h3>
    <ul>
        <li>💯 500+ Happy Customers</li>
        <li>👗 1000+ Dresses Sold</li>
        <li>🎨 50+ Designer Collections</li>
        <li>⭐ 5 Star Customer Rating</li>
    </ul>
    
    <br>
    
    <h3>✅ Why Choose Us?</h3>
    <ul>
        <li>✓ Quality Fabrics</li>
        <li>✓ Perfect Stitching</li>
        <li>✓ Affordable Prices</li>
        <li>✓ Timely Delivery</li>
        <li>✓ Free Alterations</li>
        <li>✓ 24/7 Customer Support</li>
    </ul>
    
    <br>
    
    <div style="background: #ffffcc; padding: 15px; border-radius: 10px; text-align: center;">
        <h3>🎉 Special Summer Sale! 🎉</h3>
        <p><b>20% OFF on all dresses | Free stitching on bridal collection</b></p>
        <p>📅 Offer valid until 31st August 2026</p>
    </div>
    
    <br>
    
    <h3>📞 Contact Us</h3>
    <p><b>Email:</b> boutique@gmail.com</p>
    <p><b>Phone:</b> +923479130544</p>
    <p><b>Location:</b> Islamabad, Pakistan</p>
</div>

<div class="footer">
    <p><b>Boutique Management System by Attiqa, Natasha & Tooba</b></p>
    <p>Email: boutique@gmail.com | Phone: 0318-2345567 | Islamabad, Pakistan</p>
</div>

<script src="js/storage.js"></script>
</body>
</html>
