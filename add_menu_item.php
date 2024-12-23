<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $dishName = trim($_POST['dishName']);
    $dishPrice = floatval($_POST['dishPrice']);
    $category = trim($_POST['category']);
    $restaurant_id = $_SESSION['restaurant_id'];
    

 
    echo "<p>Restaurant ID: " . htmlspecialchars($restaurant_id) . "</p>";


    if (empty($dishName) || $dishPrice <= 0 || empty($category)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required and must be valid.']);
        exit;
    }

    // Handle file upload
    $imagePath = null; // Default to null if no image is provided
    if (isset($_FILES['dishImage']) && $_FILES['dishImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = './images/menu-items/';
        $fileName = uniqid() . '_' . basename($_FILES['dishImage']['name']);
        $targetFilePath = $uploadDir . $fileName;

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Validate and move the file
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.']);
            exit;
        }

        if (move_uploaded_file($_FILES['dishImage']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath; // Save the relative path to the database
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload the image.']);
            exit;
        }
    }

    // Insert data into the database
    try {
        $query = "INSERT INTO menu_items (restaurant_id, name, price, image, menu_type, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$restaurant_id, $dishName, $dishPrice, $imagePath, $category, 0]); // Default quantity to 0

        echo json_encode(['status' => 'success', 'message' => 'Menu item added successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
