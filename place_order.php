<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');

try {
    // Debugging - Log POST data
    file_put_contents("debug.log", "POST Data: " . print_r($_POST, true), FILE_APPEND);

    $name = $_POST['name'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $location = $_POST['location'] ?? null;
    $total_price = $_POST['total_price'] ?? null;
    $payment_method = $_POST['payment_method'] ?? null;
    $basket_items = json_decode($_POST['basket_items'] ?? '[]', true);

    if (!$name || !$phone || !$location || !$total_price || !$payment_method || empty($basket_items)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        exit;
    }

    foreach ($basket_items as $item) {
        if (!isset($item['id'], $item['quantity'], $item['price'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid basket items.']);
            exit;
        }
    }

    if (!$pdo) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
        exit;
    }

    // Insert into `orders`
    $stmt = $pdo->prepare("INSERT INTO orders (user_name, phone_number, location, total_price, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $location, $total_price, $payment_method]);
    $order_id = $pdo->lastInsertId();

    // Insert into `order_items`
    foreach ($basket_items as $item) {
        $menu_item_id = $item['id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $menu_item_id, $quantity, $price]);
    }

    echo json_encode(['status' => 'success', 'order_id' => $order_id]);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
