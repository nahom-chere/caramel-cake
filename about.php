<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Caramel Cake</title>
    <link rel="stylesheet" href="about.css">
</head>
<body>
    <header>
        <h1>About Caramel Cake</h1>
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php else: ?>
                    <li><a href="order.php">Shop</a></li>
                    <li><a href="cart.php">🛒 Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="first-section">
        <h2>Our Story</h2>
        <p>Caramel Cake was founded with a passion for creating delicious and high-quality <br>cakes for every occasion. From birthdays to weddings, we bake with love and the finest ingredients.</p>
    </section>

    <section class="content-section">
        <h2>Our Mission</h2>
        <p>We aim to bring joy through our handcrafted cakes, ensuring every bite is delightful. <br> Our commitment is to provide freshly baked goods with exceptional customer service.</p>
    </section>

    <section class="content-section">
        <h2>Why Choose Us?</h2>
        <p>Fresh, handmade cakes with premium ingredients.</p>
        <p>Custom designs for special occasions.</p>
        <p>Fast and reliable delivery service.</p>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Caramel Cake. All Rights Reserved.</p>
            <ul class="footer-links">
            <li><a href="privecy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>