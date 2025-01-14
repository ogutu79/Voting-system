<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db_connect.php';

// Fetch candidates from the database
$sql = "SELECT * FROM candidates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidates</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #004d40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #004d40;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Candidates</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['photo']) . "</td>";
                        echo "<td>
                                <a href='edit_candidate.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> |
                                <a href='delete_candidate.php?id=" . htmlspecialchars($row['id']) . "'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No candidates found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
