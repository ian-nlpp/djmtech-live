<?php
session_start();
include 'db_connect.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = trim($_POST['newPassword'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');

    if (empty($newPassword) || empty($confirmPassword)) {
        $error = "Both password fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#-+_=.\\/\(\)])[A-Za-z\d@$!%*?&#-+_=.\\/\(\)]{8,}$/', $newPassword)) {
        $error = "Password must be at least 8 characters, with an uppercase letter, number, and special character (e.g., @, $, !, %, *, ?, &, #, -, +, =, _, ., /, (, ), `).";
    } else {
        $stmt = $pdo->prepare("SELECT user_id FROM tbl_usertoken WHERE token = ? AND expires > ?");
        $stmt->execute([$token, time()]);
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tokenData) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE tbl_users SET password = ? WHERE user_id = ?");
            $stmt->execute([$hashedPassword, $tokenData['user_id']]);
            $stmt = $pdo->prepare("DELETE FROM tbl_usertoken WHERE token = ?");
            $stmt->execute([$token]);
            $success = "Your password has been reset successfully. You can now log in.";
        } else {
            $error = "Invalid or expired reset link.";
        }
    }
} else {
    $stmt = $pdo->prepare("SELECT user_id FROM tbl_usertoken WHERE token = ? AND expires > ?");
    $stmt->execute([$token, time()]);
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        $error = "Invalid or expired reset link.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/icons/favicon.png">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/authentication.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <img src="assets/DJMLogo.png">
                <br>
                <div class="logoname">
                    <small>DJM TECH</small>
                </div>
            </div>
            <?php if ($error): ?>
                <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($success); ?> <br> <a href="login.html">Log in here</a>.</div>
            <?php else: ?>
                <h2>RESET PASSWORD</h2>
                <div id="errorMessages" style="color: red; margin-bottom: 10px; display: none;">
                    <ul id="errorList"></ul>
                </div>
                <form id="resetForm" method="POST">
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="input-container">
                            <input type="password" name="newPassword" id="newPassword" placeholder="Enter New Password" required>
                            <span class="toggle-password" onclick="togglePassword('newPassword')">👁</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-container">
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm New Password" required>
                            <span class="toggle-password" onclick="togglePassword('confirmPassword')">👁</span>
                        </div>
                    </div>
                    <button class="btn" type="submit" id="submitBtn">SUBMIT</button>
                </form>
                <div class="toggle-form">Back to <a href="login.html">Login</a></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            var passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        <?php if (!$success): ?>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('resetForm');

            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    clearErrors();

                    const newPassword = document.getElementById('newPassword').value.trim();
                    const confirmPassword = document.getElementById('confirmPassword').value.trim();

                    let hasError = false;
                    const errorMessages = [];
                    if (newPassword === "") { errorMessages.push("New password is required."); hasError = true; }
                    if (confirmPassword === "") { errorMessages.push("Confirm password is required."); hasError = true; }
                    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#-+_=.\\/\(\)])[A-Za-z\d@$!%*?&#-+_=.\\/\(\)]{8,}$/;
                    if (!passwordPattern.test(newPassword)) {
                        errorMessages.push("Password must be at least 8 characters, with an uppercase letter, number, and special character (e.g., @, $, !, %, *, ?, &, #, -, +, =, _, ., /, (, ), `).");
                        hasError = true;
                    }
                    if (newPassword !== confirmPassword) { errorMessages.push("Passwords do not match."); hasError = true; }

                    if (hasError) {
                        displayErrors(errorMessages);
                    } else {
                        form.submit(); // Submit if no errors
                    }
                });
            }

            function displayErrors(messages) {
                const errorMessagesDiv = document.getElementById("errorMessages");
                const errorList = document.getElementById("errorList");
                errorList.innerHTML = "";
                messages.forEach(message => {
                    const listItem = document.createElement("li");
                    listItem.textContent = message;
                    errorList.appendChild(listItem);
                });
                errorMessagesDiv.style.display = "block";
            }

            function clearErrors() {
                const errorMessagesDiv = document.getElementById("errorMessages");
                errorMessagesDiv.style.display = "none";
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>