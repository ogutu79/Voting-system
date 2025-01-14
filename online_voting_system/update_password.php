<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    
    $user_id = $_SESSION['user_id']; // User ID from session

    // Retrieve the current hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM voters WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE voters SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);

            if ($update_stmt->execute()) {
                echo "Password updated successfully.";
            } else {
                echo "Error: " . $update_stmt->error;
            }

            $update_stmt->close();
        } else {
            echo "Current password is incorrect.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Update Password</h2>
    <form action="update_password.php" method="POST">
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required>
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <button type="submit">Update Password</button>
    </form>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
