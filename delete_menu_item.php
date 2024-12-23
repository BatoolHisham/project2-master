<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_item_id = $_POST['menu_item_id'] ?? null;

    if (!$menu_item_id) {
        echo json_encode(['status' => 'error', 'message' => 'Menu item ID is required.']);
        exit();
    }

    try {
        $query = "DELETE FROM menu_items WHERE menu_item_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$menu_item_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Menu item deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Menu item not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
