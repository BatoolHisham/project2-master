<?php
header("Content-Type: application/json"); // Ensure response is JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log input and output for debugging
file_put_contents("debug.log", "Fetch Orders Called\n", FILE_APPEND);

include('db.php');

try {
    // $stmt = $pdo->query("SELECT orders.order_id, orders.user_name, orders.phone_number, orders.location, orders.total_price, orders.payment_method, order_items.menu_item_id, order_items.quantity, order_items.price 
    //                      FROM orders 
    //                      LEFT JOIN order_items ON orders.order_id = order_items.order_id");

    $stmt = $pdo->query("select * from orders o inner join order_items oi on oi.order_id = o.order_id inner join menu_items mi on mi.menu_item_id = oi.menu_item_id");

    $orders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $order_id = $row['order_id'];
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                'order_id' => $order_id,
                'user_name' => $row['user_name'],
                'phone_number' => $row['phone_number'],
                'location' => $row['location'],
                'total_price' => $row['total_price'],
                'payment_method' => $row['payment_method'],
                'items' => [],
            ];
        }

        $orders[$order_id]['items'][] = [
            'menu_item_id' => $row['name'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
        ];
    }

    echo json_encode(['orders' => array_values($orders)]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}

?>
