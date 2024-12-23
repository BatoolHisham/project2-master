<?php
include('db.php');

// Set JSON header for the response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);

        // Validate input fields
        if (empty($phone) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $query = "INSERT INTO deliver_users (phone, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$phone, $hashedPassword]);

        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }
}
?>
