<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-wrapper">
            <h2>Welcome to User Dashboard</h2>
            <ul>
                <li><a href="change_password.php">Change Password</a></li>
                <li><a href="view_results.php">View Election Results</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
