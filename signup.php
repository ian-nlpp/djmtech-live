<?php
ob_start(); // Start output buffering
ini_set('display_errors', 0); // Prevent HTML output
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/djmtech/php_errors.log');
session_start();

include 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'errors' => ['Invalid request']]);
    ob_end_flush();
    exit;
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$street = trim($_POST['street'] ?? '');
$barangay = trim($_POST['barangay'] ?? '');
$city = trim($_POST['city'] ?? '');
$province = trim($_POST['province'] ?? '');
$zipCode = trim($_POST['zipCode'] ?? '');
$password = trim($_POST['password'] ?? '');

$errors = [];
if (empty($firstName)) $errors[] = 'First name is required';
if (empty($lastName)) $errors[] = 'Last name is required';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email';
if (!preg_match('/^09\d{9}$/', $phone)) $errors[] = 'Invalid phone number';
if (empty($street)) $errors[] = 'Street address is required';
if (empty($barangay)) $errors[] = 'Barangay is required';
if (empty($city)) $errors[] = 'City is required';
if (empty($province)) $errors[] = 'Province is required';
if (empty($zipCode)) $errors[] = 'Zip code is required';
if (!empty($zipCode) && !preg_match('/^\d{4}$/', $zipCode)) $errors[] = 'Zip code must be 4 digits';
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#-+_=\\.\/\(\)])[A-Za-z\d@$!%*?&#-+_=\\.\/\(\)]{8,}$/', $password)) {
    $errors[] = 'Password must be at least 8 characters, contain an uppercase letter, a number, and a special character (e.g., @, $, !, %, *, ?, &, #, -, +, =, _, ., /, (, ), `)';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    ob_end_flush();
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'errors' => ['Email already exists']]);
        ob_end_flush();
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO tbl_users (first_name, last_name, email, phone, street_address, barangay, city, province, zip_code, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $success = $stmt->execute([$firstName, $lastName, $email, $phone, $street, $barangay, $city, $province, $zipCode, $hashedPassword]);

    if ($success) {
        $_SESSION['success'] = "Account created successfully! Please login.";
        echo json_encode(['success' => true, 'message' => 'Account created successfully! Please login.']);
    } else {
        echo json_encode(['success' => false, 'errors' => ['Database error']]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'errors' => ['Server error: ' . $e->getMessage()]]);
}
ob_end_flush();
exit;
?>