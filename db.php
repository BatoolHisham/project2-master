<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=judelivery1', 'root', '0000');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
