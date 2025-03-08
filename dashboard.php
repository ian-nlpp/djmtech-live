<?php
include 'auth.php'; // Include authentication check
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Adjust if you have a stylesheet -->
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></h1>
    <p>This is your dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>