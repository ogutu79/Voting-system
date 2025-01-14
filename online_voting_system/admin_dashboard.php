<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .dashboard-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #004d40;
        }
        a {
            display: block;
            margin: 10px 0;
            color: #004d40;
            text-decoration: none;
            padding: 10px;
            background-color: #e0f2f1;
            border-radius: 5px;
        }
        a:hover {
            background-color: #b2dfdb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-box">
            <h2>Admin Dashboard</h2>
            <a href="add_candidate.php">Add New Candidate</a>
            <a href="manage_candidates.php">Manage Candidates</a>
            <a href="view_results.php">View Election Results</a>
            <a href="manage_users.php">Manage Users</a> <!-- New link -->
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
