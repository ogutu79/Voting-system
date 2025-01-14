<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];

    // Update the candidate details
    $stmt = $conn->prepare("UPDATE candidates SET name = ?, position = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $position, $id);

    if ($stmt->execute()) {
        header("Location: manage_candidates.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch current details for the candidate
$stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$candidate = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
            width: 50%;
            max-width: 600px;
        }
        .form-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px;
            background-color: #004d40;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #00332d;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h2>Edit Candidate</h2>
            <form action="edit_candidate.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
                <label for="name">Candidate Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($candidate['name']); ?>" required>

                <label for="position">Position</label>
                <select id="position" name="position" required>
                    <option value="Chairperson" <?php if ($candidate['position'] == 'Chairperson') echo 'selected'; ?>>Chairperson</option>
                    <option value="Vice Chair" <?php if ($candidate['position'] == 'Vice Chair') echo 'selected'; ?>>Vice Chair</option>
                    <option value="Speaker" <?php if ($candidate['position'] == 'Speaker') echo 'selected'; ?>>Speaker</option>
                    <option value="Ministry" <?php if ($candidate['position'] == 'Ministry') echo 'selected'; ?>>Ministry</option>
                    <option value="Delegate" <?php if ($candidate['position'] == 'Delegate') echo 'selected'; ?>>Delegate</option>
                </select>

                <button type="submit">Update Candidate</button>
            </form>
            <a href="manage_candidates.php">Back to Manage Candidates</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
