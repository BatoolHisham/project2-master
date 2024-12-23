<?php
include('db.php');

// Set JSON header for the response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);
        $restaurant_id = $_POST['restaurantSelection'];

        // Validate input fields
        if (empty($phone) || empty($password) || empty($restaurant_id)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $query = "INSERT INTO rest_users (phone, password, restaurant_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$phone, $hashedPassword, $restaurant_id]);

        /*
         // Insert contact number into restaurants table (if required)
         $query1 = "INSERT INTO restaurants (contact_number) VALUES (?)";
         $stmt = $pdo->prepare($query1);
         if (!$stmt->execute([$phone])) {
             error_log("Insert into restaurants failed: " . implode(", ", $stmt->errorInfo()));
             echo json_encode(['status' => 'error', 'message' => 'Restaurant insertion failed']);
             exit();
         }
         $query2 = "SELECT id FROM restaurants WHERE id = ?";
         $stmt = $pdo->prepare($query2);
         $stmt->execute([$restaurant_id]);
         if ($stmt->rowCount() == 0) {
             echo json_encode(['status' => 'error', 'message' => 'Invalid restaurant selected']);
             exit();
         }
          */        


        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }
}
?>
