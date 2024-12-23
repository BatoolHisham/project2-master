<?php
include('db.php');
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    $itemId = $data['itemId'] ?? null;

    if (!$action || !$itemId) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit();
    }

    try {
        if ($action === 'outOfStock') {
            $query = "UPDATE menu_items SET stock = 0 WHERE menu_item_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$itemId]);
            echo json_encode(['status' => 'success', 'message' => 'Item marked as out of stock']);
        } elseif ($action === 'editPrice') {
            $newPrice = $data['newPrice'] ?? null;
            $query = "UPDATE menu_items SET price = ? WHERE menu_item_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$newPrice, $itemId]);
            echo json_encode(['status' => 'success', 'message' => 'Price updated successfully']);
        } elseif ($action === 'changePhoto') {
            $newPhoto = $data['newPhoto'] ?? null;
            $query = "UPDATE menu_items SET image = ? WHERE menu_item_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$newPhoto, $itemId]);
            echo json_encode(['status' => 'success', 'message' => 'Photo updated successfully']);
        } elseif ($action === 'deleteItem') {
            $query = "DELETE FROM menu_items WHERE menu_item_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$itemId]);
            echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
    } catch (PDOException $e) {
        error_log("Error updating item: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
