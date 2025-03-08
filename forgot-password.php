<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/icons/favicon.png">
    <title>Forgot Password?</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/authentication.css">
    <link rel="stylesheet" href="css/forgot-password.css">
</head>
<body>
    <div class="container">
        <div id="forgotForm" class="form-container">
            <div class="logo">
                <img src="assets/DJMLogo.png">
                <br>
                <div class="logoname">
                    <small>DJM TECH</small>
                </div>
            </div>
            
            <div class="forgottitle">
                <h2>FORGOT PASSWORD</h2>
                <p class="forgotp">Provide your account's email address and a reset password email will be sent to your inbox.</p>
            </div>
            <form action="forgot-password-process.php" method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>
                <button class="btn" type="submit">SUBMIT</button>
            </form>
            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars(urldecode($_GET['error'])); ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['message'])): ?>
                <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars(urldecode($_GET['message'])); ?></div>
            <?php endif; ?>
            <div class="toggle-form">Already have an account? <a href="login.html">LOG IN</a></div>
        </div>
    </div>
</body>
</html>