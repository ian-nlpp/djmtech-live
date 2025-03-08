<?php
session_start();
include 'db_connect.php';
require 'vendor/autoload.php'; // Composer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: forgot-password.php?error=" . urlencode("Please enter a valid email address"));
        exit;
    }

    $stmt = $pdo->prepare("SELECT user_id FROM tbl_users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $resetToken = bin2hex(random_bytes(16));
        $expires = time() + 3600;
        $stmt = $pdo->prepare("INSERT INTO tbl_usertoken (user_id, token, expires) VALUES (?, ?, ?)");
        $stmt->execute([$user['user_id'], $resetToken, $expires]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'djmtech2025@gmail.com'; // Your Gmail
            $mail->Password = 'zvst tjms gxhf agan';    // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your-email@gmail.com', 'DJM Tech');
            $mail->addAddress($email);

            $resetLink = "http://localhost/djmtech/reset-password.php?token=" . $resetToken;
            $mail->isHTML(true);
            $mail->Subject = 'DJM Tech - Password Reset Request';
            $mail->Body    = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, rgb(112, 0, 255), rgb(160, 0, 255));
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            text-align: center;
            color: #333;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(90deg, rgb(112, 0, 255), rgb(160, 0, 255));
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }
        .footer {
            background: #f9f9f9;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer a {
            color: rgb(112, 0, 255);
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Password Reset Request
        </div>
        <div class="content">
            <p>Hello!</p>
            <p>You recently requested to reset your password. Click the button below to proceed:</p>
            <a href="'. htmlspecialchars($resetLink) . '" style="color: white; text-decoration: none;" class="cta-button">Reset Password</a>
            <p>If the button above doesn’t work, copy and paste this link into your browser:</p>
            <p>'. htmlspecialchars($resetLink) . '</p>
            <p>If you didn’t request this, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            <p>© 2025 DJM Tech | <a href="https://djmtech.com">Visit Us</a></p>
        </div>
    </div>
</body>
</html>';
            $mail->AltBody = "Hi,\n\nReset your password: $resetLink\n\nExpires in 1 hour.\n\nRegards,\nDJM Tech";

            $mail->send();
            header("Location: forgot-password.php?message=" . urlencode("A reset link has been sent to your email."));
            exit;
        } catch (Exception $e) {
            header("Location: forgot-password.php?error=" . urlencode("Failed to send reset email. Try again later."));
            exit;
        }
    } else {
        header("Location: forgot-password.php?error=" . urlencode("No account found with that email."));
        exit;
    }
} else {
    header("Location: forgot-password.php?error=" . urlencode("Invalid request"));
    exit;
}
?>