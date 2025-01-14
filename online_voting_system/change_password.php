<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Get the user's ID
        $user_id = $_SESSION['user_id'];

        // Fetch the current hashed password from the database
        $stmt = $conn->prepare("SELECT password FROM voters WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            // Hash the new password and update it in the database
            $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE voters SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $new_hashed_password, $user_id);

            if ($stmt->execute()) {
                echo '<p>Password changed successfully.</p>';
            } else {
                echo 'Error updating password: ' . $stmt->error;
            }
        } else {
            echo 'Current password is incorrect.';
        }

        $stmt->close();
    } else {
        echo 'New passwords do not match.';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #004d40;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
        }
        button:hover {
            background-color: #002d1b;
        }
        a {
            display: block;
            margin-top: 20px;
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
        <h2>Change Password</h2>
        <form action="change_password.php" method="post">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" placeholder="Enter your current password" required>

            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required>

            <button type="submit">Change Password</button>
        </form>
        <a href="voter_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
