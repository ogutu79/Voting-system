<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT * FROM voters WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if (!$user) {
        echo "User not found.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $voters_id = $_POST['voters_id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $role = $_POST['role'];

        // Update user details
        $stmt = $conn->prepare("UPDATE voters SET voters_id = ?, firstname = ?, lastname = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $voters_id, $firstname, $lastname, $role, $user_id);
        
        if ($stmt->execute()) {
            echo "User updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "No user ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #004d40;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #00332e;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #004d40;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Edit User</h2>
            <form action="edit_user.php?id=<?php echo htmlspecialchars($user_id); ?>" method="post">
                <label for="voters_id">Voter ID</label>
                <input type="text" id="voters_id" name="voters_id" value="<?php echo htmlspecialchars($user['voters_id']); ?>" required>

                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>

                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>

                <button type="submit">Update User</button>
            </form>
            <a href="manage_users.php" class="back-link">Back to Manage Users</a>
        </div>
    </div>
</body>
</html>
