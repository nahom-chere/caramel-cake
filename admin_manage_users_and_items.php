<?php
session_start();
include "connection.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

// Handle adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image_url, $stock);
    $stmt->execute();
    $stmt->close();
}

// Handle updating a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, stock = ? WHERE product_id = ?");
    $stmt->bind_param("ssdsii", $name, $description, $price, $image_url, $stock, $product_id);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a product
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}

// Handle adding a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting a user
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all products
$products = $conn->query("SELECT * FROM products");

// Fetch all users
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Caramel Cake</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            text-align: center;
        }

        header {
            background-color: #ff6b81;
            padding: 20px;
            color: white;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .admin-section {
            padding: 50px;
            background-color: #fff;
            max-width: 1200px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .admin-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #ff6b81;
            color: white;
        }

        table tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            background-color: #ff6b81;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #e55a6b;
        }

        .btn-update {
            background-color: #28a745;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 10px 0 0;
        }

        .footer-links li {
            display: inline;
            margin: 0 15px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="admin_manage_orders.php">Admin Manage Orders</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-section">
        <h2>Manage Products</h2>

        <!-- Add Product Form -->
        <form method="POST" action="admin_manage_users_and_items.php">
            <h3>Add New Product</h3>
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <!-- Update Product Form -->
        <form method="POST" action="admin_manage_users_and_items.php">
            <h3>Update Product</h3>
            <select name="product_id" required>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="name" placeholder="New Name" required>
            <textarea name="description" placeholder="New Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="New Price" required>
            <input type="text" name="image_url" placeholder="New Image URL" required>
            <input type="number" name="stock" placeholder="New Stock" required>
            <button type="submit" name="update_product">Update Product</button>
        </form>

        <!-- Delete Product -->
        <h3>Delete Product</h3>
        <ul>
            <?php $products->data_seek(0); // Reset pointer ?>
            <?php while ($product = $products->fetch_assoc()): ?>
                <li>
                    <?php echo $product['name']; ?>
                    <a href="admin_manage_users_and_items.php?delete_product=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>

    <section class="admin-section">
        <h2>Manage Users</h2>

        <!-- Add User Form -->
        <form method="POST" action="admin_manage_users_and_items.php">
            <h3>Add New User</h3>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add_user">Add User</button>
        </form>

        <!-- Delete User -->
        <h3>Delete User</h3>
        <ul>
            <?php while ($user = $users->fetch_assoc()): ?>
                <li>
                    <?php echo $user['username']; ?>
                    <a href="admin_manage_users_and_items.php?delete_user=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Caramel Cake. All Rights Reserved.</p>
            <ul class="footer-links">
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>