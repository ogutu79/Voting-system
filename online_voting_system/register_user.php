<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voters_id = $_POST['voters_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $role = $_POST['role']; // e.g., 'user' or 'admin'

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO voters (voters_id, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $voters_id, $hashed_password, $firstname, $lastname, $role);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Register User</h2>
    <form action="register_user.php" method="POST">
        <label for="voters_id">Voter ID:</label>
        <input type="text" id="voters_id" name="voters_id" required>
        <br>
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        <br>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
