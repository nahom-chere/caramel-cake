<?php
session_start();
include "connection.php";

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$conn->begin_transaction();

try {
    // Get cart items
    $stmt = $conn->prepare("
        SELECT c.*, p.name, p.price 
        FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ?
    ");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($cart_items)) {
        throw new Exception('Cart is empty');
    }

    // Calculate total
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Create order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->bind_param("id", $_SESSION['id'], $total_amount);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Add order items
    $stmt = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, item_name, price, quantity)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($cart_items as $item) {
        $stmt->bind_param("iisdi", 
            $order_id,
            $item['product_id'],
            $item['name'],
            $item['price'],
            $item['quantity']
        );
        $stmt->execute();

        // Update product stock
        $update_stock = $conn->prepare("
            UPDATE products 
            SET stock = stock - ? 
            WHERE product_id = ? AND stock >= ?
        ");
        $update_stock->bind_param("iii", 
            $item['quantity'],
            $item['product_id'],
            $item['quantity']
        );
        if (!$update_stock->execute()) {
            throw new Exception('Insufficient stock');
        }
    }

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();

    $conn->commit();
    echo json_encode(['status' => 'success', 'order_id' => $order_id]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>