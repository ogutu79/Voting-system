<?php
session_start();
include 'db_connect.php';

// Retrieve form data
$voters_id = $_POST['voters_id'];
$password = $_POST['password'];

// Prepare and execute the SQL query to fetch user data
$stmt = $conn->prepare("SELECT id, password, role FROM voters WHERE voters_id = ?");
$stmt->bind_param("s", $voters_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $hashed_password, $role);

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->fetch();

    // Verify the provided password against the hashed password in the database
    if (password_verify($password, $hashed_password)) {
        // Redirect based on user role
        if ($role === 'admin') {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['user_logged_in'] = true;
            header("Location: voting_page.php");
            exit();
        }
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "Voter ID not found.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
