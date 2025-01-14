<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Fetch user data
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$stmt = $conn->prepare("SELECT * FROM voters WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE voters SET firstname = ?, lastname = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $firstname, $lastname, $email, $user_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Profile updated successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .form-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #004d40;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #004d40;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #00332a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Edit Profile</h2>
            <form action="edit_profile.php" method="post">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit">Update Profile</button>
            </form>
            <a href="user_dashboard.php">Back to User Dashboard</a>
        </div>
    </div>
</body>
</html>
