<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start the session to store user data
session_start();
include('db.php'); // Include database connection

header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim any unwanted spaces from the input values
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Query to fetch user data by phone
    $query = "SELECT id, phone, password, restaurant_id FROM rest_users WHERE phone = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$phone]);
    $user = $stmt->fetch();

    // echo "<p>Dish Name: test</p>";


    if ($user && password_verify($password, $user['password'])) {
        // If login is successful, set the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['restaurant_id'] = $user['restaurant_id'];
        $_SESSION['phone'] = $user['phone'];

        // Send the restaurant_id to the frontend as JSON
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'restaurant_id' => $user['restaurant_id'],
          //  'userId' => $user['id']
        ]);
     //header('Location: restsystem.html');
        exit();
    } else {
        // Send an error message as JSON
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid phone or password'
        ]);
    }
    exit();
}

?>
