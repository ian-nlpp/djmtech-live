<?php
// Include database connection
include 'db_connect.php';

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']); // Matches the checkbox name="remember"

    // Server-side validation
    if (empty($email) || empty($password)) {
        header("Location: login.html?error=" . urlencode("Email and password are required"));
        exit;
    }

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Correct credentials, start session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['logged_in'] = true;

        // Handle "Remember Me"
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $expires = time() + (30 * 24 * 60 * 60); // 30 days
            $stmt = $pdo->prepare("INSERT INTO tbl_usertoken (user_id, token, expires) VALUES (?, ?, ?)");
            $stmt->execute([$user['user_id'], $token, $expires]);
            setcookie('remember_token', $token, $expires, '/', '', false, true);
        }

        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: login.html?error=" . urlencode("Invalid credentials"));
        exit;
    }
} else {
    header("Location: login.html?error=" . urlencode("Invalid request"));
    exit;
}
?>