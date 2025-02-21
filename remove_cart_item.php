<?php
session_start();
include "connection.php";

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$cart_id = $data['cart_id'];

$stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $_SESSION['id']);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove item']);
}
?>