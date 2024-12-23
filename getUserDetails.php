<?php
session_start();
include('db.php');
if (isset($_SESSION['phone'])) {
    echo json_encode(['status' => 'success', 'phone' => $_SESSION['phone']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $query = "SELECT phone FROM rest_users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['status' => 'success', 'phone' => $user['phone']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
}
?>
?>
