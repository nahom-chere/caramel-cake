<?php
session_start();
include "connection.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

// Handle updating order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting an order
if (isset($_GET['delete_order'])) {
    $order_id = $_GET['delete_order'];

    // Delete order items first
    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Delete the order
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all orders with user details
$orders = $conn->query("
    SELECT orders.*, users.username 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    ORDER BY orders.created_at DESC
");

// Fetch order items for a specific order
function getOrderItems($conn, $order_id) {
    $stmt = $conn->prepare("
        SELECT order_items.*, products.name 
        FROM order_items 
        JOIN products ON order_items.product_id = products.product_id 
        WHERE order_items.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
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
                <li><a href="admin_manage_users_and_items.php">Manage Users and Items</a></li> 
            </ul>
        </nav>
    </header>

    <section class="admin-section">
        <h2>Manage Orders</h2>

        <!-- Display Orders -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo $order['username']; ?></td>
                        <td>$<?php echo $order['total_amount']; ?></td>
                        <td><?php echo ucfirst($order['status']); ?></td>
                        <td><?php echo $order['created_at']; ?></td>
                        <td>
                            <a href="admin_manage_orders.php?view_order=<?php echo $order['order_id']; ?>" class="btn">View</a>
                            <a href="admin_manage_orders.php?delete_order=<?php echo $order['order_id']; ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- View Order Details -->
        <?php if (isset($_GET['view_order'])): ?>
            <?php
            $order_id = $_GET['view_order'];
            $order_items = getOrderItems($conn, $order_id);
            ?>
            <h3>Order Details (Order ID: <?php echo $order_id; ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo $item['price']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Update Order Status -->
            <form method="POST" action="admin_manage_orders.php">
                <h3>Update Order Status</h3>
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <select name="status" required>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <button type="submit" name="update_order_status" class="btn btn-update">Update Status</button>
            </form>
        <?php endif; ?>
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