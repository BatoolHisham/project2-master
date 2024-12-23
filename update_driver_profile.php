<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start the session to store user data
session_start();
include('db.php'); // Include database connection

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim any unwanted spaces from the input values
    $phone = trim($_POST['phone-number']);
    $password = trim($_POST['password']);

    $password = password_hash($password, PASSWORD_BCRYPT);

    $query = "UPDATE deliver_users SET password = ? WHERE phone = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$password, $phone]);
    // echo "<p>Dish Name: test</p>";

    exit();
}

?>
