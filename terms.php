<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Caramel Cake</title>
    <link rel="stylesheet" href="terms.css">
</head>
<body>
    <header>
        <h1>Terms of Service</h1>
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

    <section class="terms-content">
        <h2>Welcome to Caramel Cake Shop</h2>
        <p>By using this website, you agree to the following Terms of Service. Please read these terms carefully before using the site.</p>

        <h3>1. Acceptance of Terms</h3>
        <p>By accessing and using this website, you agree to comply with and be bound by these Terms of Service. If you do not agree with any part of these terms, please do not use our website.</p>

        <h3>2. Privacy Policy</h3>
        <p>Your use of this website is also governed by our Privacy Policy, which is incorporated by reference into these Terms of Service. Please review our Privacy Policy for more information.</p>

        <h3>3. User Responsibilities</h3>
        <p>As a user of this website, you are responsible for providing accurate information when creating an account or making purchases. You agree not to misuse or interfere with the operation of the site.</p>

        <h3>4. Product Orders and Payments</h3>
        <p>By placing an order through this website, you are agreeing to pay the specified amount for the products purchased. Payments must be made in accordance with the accepted payment methods on the site.</p>

        <h3>5. Limitation of Liability</h3>
        <p>Caramel Cake Shop is not liable for any direct, indirect, incidental, or consequential damages that may arise from your use of the site. This includes any errors in the content or disruptions of service.</p>

        <h3>6. Modifications to Terms</h3>
        <p>Caramel Cake Shop reserves the right to modify or update these Terms of Service at any time. Any changes will be posted on this page, and by continuing to use the website, you agree to the revised terms.</p>

        <h3>7. Governing Law</h3>
        <p>These Terms of Service shall be governed by and construed in accordance with the laws of the jurisdiction in which Caramel Cake Shop operates.</p>
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
