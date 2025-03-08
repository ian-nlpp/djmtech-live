<?php
session_start();
include 'db_connect.php';

// Clear "Remember Me" token if it exists
if (isset($_COOKIE['remember_token'])) {
    $stmt = $pdo->prepare("DELETE FROM tbl_usertoken WHERE token = ?");
    $stmt->execute([$_COOKIE['remember_token']]);
    setcookie('remember_token', '', time() - 3600, '/');
}

// Clear session
session_unset();
session_destroy();

header("Location: login.html");
exit;
?>