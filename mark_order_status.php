<?php
header("Content-Type: application/json"); // Ensure response is JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log input for debugging
file_put_contents("debug.log", "Mark Order Status Called\n" . print_r($_POST, true), FILE_APPEND);

include('db.php');

try {
    $order_id = $_POST['order_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if (!$order_id || !$status) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$status, $order_id]);

    echo json_encode(['status' => 'success', 'message' => 'Order status updated']);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
