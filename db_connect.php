<?php
$host = "localhost";
$dbname = "DJMTECH";
$username = "root"; // Default XAMPP user
$password = "";     // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // For now, we'll keep this simple; signup.php will handle errors
    die("Connection failed: " . $e->getMessage());
}
?>