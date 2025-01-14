<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Dashboard</title>
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #004d40;
            font-size: 18px;
            padding: 10px;
            border: 1px solid #004d40;
            border-radius: 4px;
            background-color: #e0f2f1;
        }
        a:hover {
            background-color: #004d40;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Voter Dashboard</h2>
        <a href="voting_page.php">Vote Now</a>
        <a href="voter_view_results.php">View Election Results</a>
        <a href="change_password.php">Change Password</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
