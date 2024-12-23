<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $restaurant_id = $_GET['restaurant_id'] ?? null;

    if (!$restaurant_id) {
        echo json_encode(['status' => 'error', 'message' => 'Restaurant ID is required.']);
        exit();
    }

    try {
        $query = "SELECT name, price, menu_item_id, image FROM menu_items WHERE restaurant_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$restaurant_id]);

        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($menu_items) {
            echo json_encode(['status' => 'success', 'data' => $menu_items]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No menu items found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
