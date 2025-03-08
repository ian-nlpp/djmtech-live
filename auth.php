<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];
        $stmt = $pdo->prepare("SELECT * FROM tbl_usertoken WHERE token = ? AND expires > ?");
        $stmt->execute([$token, time()]);
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tokenData) {
            $_SESSION['user_id'] = $tokenData['user_id'];
            $_SESSION['logged_in'] = true;
            $stmt = $pdo->prepare("SELECT first_name FROM tbl_users WHERE user_id = ?");
            $stmt->execute([$tokenData['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['first_name'] = $user['first_name'];
        } else {
            setcookie('remember_token', '', time() - 3600, '/');
            header("Location: login.html");
            exit;
        }
    } else {
        header("Location: login.html");
        exit;
    }
}
?>