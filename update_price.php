<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_item_id = $_POST['menu_item_id'] ?? null;
    $price = $_POST['price'] ?? null;

    if (!$menu_item_id || $price === null) {
        echo json_encode(['status' => 'error', 'message' => 'Menu item ID and price are required.']);
        exit();
    }

    try {
        $query = "UPDATE menu_items SET price = ? WHERE menu_item_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$price, $menu_item_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Price updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Menu item not found or price unchanged.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
