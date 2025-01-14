<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voters_id = $_POST['voters_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO voters (voters_id, password, firstname, lastname, email, role) VALUES (?, ?, ?, ?, ?, 'user')");
    $stmt->bind_param("sssss", $voters_id, $hashed_password, $firstname, $lastname, $email);
    
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: registration_success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Register</h2>
            <form action="register.php" method="post">
                <label for="voters_id">Voter ID</label>
                <input type="text" id="voters_id" name="voters_id" placeholder="Enter voter ID" required>

                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter first name" required>

                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter last name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>

                <button type="submit">Register</button>
            </form>
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
