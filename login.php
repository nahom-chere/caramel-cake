<?php
session_start();
include "connection.php";

if (isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = md5($_POST['password']); // Using MD5 for password hashing (not recommended for production)

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role']; // Store the user's role in the session

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_manage_users_and_items.php"); // Redirect to admin page
        } else {
            header("Location: index.php"); // Redirect to home page for regular users
        }
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Caramel Cake</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Login to Caramel Cake Shop</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
            </ul>
        </nav>
    </header>

    <section class="login-form">
        <h2>Welcome Back! Please Log In</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="" method="post" class="form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="submit" class="btn" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
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