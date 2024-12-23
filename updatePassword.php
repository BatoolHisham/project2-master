<?php
session_start();
include('db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['phone'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    if (empty($data['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Password cannot be empty']);
        exit();
    }

    $phone = $_SESSION['phone'];
    $newPassword = password_hash($data['password'], PASSWORD_BCRYPT);

    try {
        $query = "UPDATE rest_users SET password = ? WHERE phone = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$newPassword, $phone]);

        echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Failed to update password']);
    }
}
?>
