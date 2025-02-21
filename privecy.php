<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Caramel Cake</title>
    <link rel="stylesheet" href="privecy.css">
</head>
<body>
    <header>
        <h1>Privacy Policy</h1>
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

    <section class="privacy-content">
        <h2>Your Privacy Matters to Us</h2>
        <p>At Caramel Cake, we value your privacy. This Privacy Policy outlines how we collect, use, and protect your personal information when you visit our website or make purchases from us.</p>

        <h3>1. Information We Collect</h3>
        <p>We collect personal information that you provide to us directly when you place an order, sign up for an account, or contact us for support. This information may include your name, email address, shipping address, phone number, and payment information.</p>

        <h3>2. How We Use Your Information</h3>
        <p>We use your personal information to process your orders, improve our services, and communicate with you about your account or purchases. We may also use your information for marketing purposes, such as sending promotional emails, if you have consented to receiving them.</p>

        <h3>3. Sharing Your Information</h3>
        <p>We do not share your personal information with third parties, except when required by law or for processing payments. We may share your data with trusted third-party service providers who assist in operating our website, delivering products, or processing payments, but they are obligated to keep your information confidential.</p>

        <h3>4. Security of Your Information</h3>
        <p>We take the security of your personal information seriously and implement appropriate technical and organizational measures to protect it from unauthorized access, disclosure, alteration, and destruction.</p>

        <h3>5. Cookies</h3>
        <p>Our website uses cookies to enhance your browsing experience. Cookies are small data files that are stored on your device to help remember your preferences and analyze site traffic. You can control cookies through your browser settings.</p>

        <h3>6. Changes to This Policy</h3>
        <p>We reserve the right to update or change this Privacy Policy at any time. Any changes will be posted on this page with the revised date. Please review this page periodically for updates.</p>
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
    <script src="cart/cart.js"></script>
</body>
</html>
