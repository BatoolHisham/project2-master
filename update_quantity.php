<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_item_id = $_POST['menu_item_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if (!$menu_item_id || $quantity === null) {
        echo json_encode(['status' => 'error', 'message' => 'Menu item ID and quantity are required.']);
        exit();
    }

    try {
        $query = "UPDATE menu_items SET quantity = ? WHERE menu_item_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$quantity, $menu_item_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Quantity updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Menu item not found or quantity unchanged.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
