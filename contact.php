<?php
session_start();
$isLoggedIn = isset($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Caramel Cake</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <header>
        <h1>Contact Caramel Cake</h1>
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

    <section class="contact-section">
        <h2>Get in Touch</h2>
        <p>Have a question or special request? Fill out the form below, and we’ll get back to you as soon as possible! 🍰</p>
        
        <form action="#" method="POST">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="btn">Send Message</button>
        </form>
    </section>

    <section class="map-section">
        <h2>Visit Us</h2>
        <p>Come taste our delicious cakes at our shop! 🍩</p>
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.776488662753!2d37.55136027019213!3d6.025388480611202!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x17babd6728ef9369%3A0x6f6bf7009383de94!2sCaramele%20Cake!5e0!3m2!1sen!2set!4v1738839203673!5m2!1sen!2set" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">" 
            width="100%" height="300" allowfullscreen="" loading="lazy">
        </iframe>
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
