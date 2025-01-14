<?php
include 'db_connect.php';

$voters_id = $_POST['voters_id'];
$email = $_POST['email']; // new email field
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$password = $_POST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO voters (voters_id, email, password, firstname, lastname) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $voters_id, $email, $hashed_password, $firstname, $lastname);

if ($stmt->execute()) {
    echo "User registered successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
