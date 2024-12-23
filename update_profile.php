<?php
include('db.php'); // Include database connection

// Get input data
$input = json_decode(file_get_contents('php://input'), true);
$phoneNumber = $input['phone-number'];
$password = $input['password'];
$id = $_SESSION['user_id'];

// Update the quantity
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


$query = "UPDATE deliver_users SET phone = ?, password = ? WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$phoneNumber, $password, $id]);
?>
