<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="add_candidate.php">Add Candidate</a></li>
        <li><a href="view_results.php">View Results</a></li>
        <li><a href="index.php">Back to Home</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
