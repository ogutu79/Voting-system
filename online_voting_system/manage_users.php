<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Fetch users from the database
$sql = "SELECT * FROM voters";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .user-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #004d40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #004d40;
            color: #fff;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .edit-link {
            text-decoration: none;
            color: #004d40;
            font-weight: bold;
        }
        .edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-box">
            <h2>Manage Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Voter ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['voters_id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['lastname']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                            echo '<td><a href="edit_user.php?id=' . htmlspecialchars($row['id']) . '" class="edit-link">Edit</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No users found.</td></tr>';
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <a href="admin_dashboard.php" class="back-link">Back to Admin Dashboard</a>
        </div>
    </div>
</body>
</html>
