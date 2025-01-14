<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];

    // Insert the candidate without a photo
    $stmt = $conn->prepare("INSERT INTO candidates (name, position) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $position);
    
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php");
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
    <title>Add Candidate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Add Candidate</h2>
            <form action="add_candidate.php" method="post">
                <label for="name">Candidate Name</label>
                <input type="text" id="name" name="name" placeholder="Enter candidate name" required>

                <label for="position">Position</label>
                <select id="position" name="position" required>
                    <option value="Chairperson">Chairperson</option>
                    <option value="Vice Chair">Vice Chair</option>
                    <option value="Speaker">Speaker</option>
                    <option value="Ministry">Ministry</option>
                    <option value="Delegate">Delegate</option>
                </select>

                <button type="submit">Add Candidate</button>
            </form>
            <a href="admin_dashboard.php">Back to Admin Dashboard</a>
        </div>
    </div>
</body>
</html>
