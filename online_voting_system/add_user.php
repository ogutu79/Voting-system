<?php
include 'db_connect.php';

$voters_id = 'admins123'; // Example voter ID
$firstname = 'Loice';
$lastname = 'Atieno';
$role = 'admin'; // or 'admin' for admin users

// Hash the password
$password = '12345678';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO voters (voters_id, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $voters_id, $hashed_password, $firstname, $lastname, $role);

// Execute the statement
if ($stmt->execute()) {
    echo "User added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
