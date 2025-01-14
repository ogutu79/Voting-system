<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connect.php';

// Fetch results
$sql = "SELECT candidates.name, candidates.position, COUNT(votes.candidate_id) AS votes
        FROM candidates
        LEFT JOIN votes ON candidates.id = votes.candidate_id
        GROUP BY candidates.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Election Results</title>
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #004d40;
            font-size: 18px;
            padding: 10px;
            border: 1px solid #004d40;
            border-radius: 4px;
            background-color: #e0f2f1;
        }
        a:hover {
            background-color: #004d40;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Election Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Position</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['position']) . "</td>
                            <td>" . htmlspecialchars($row['votes']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No results available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="voting_page.php">Back to Voting Page</a>
        <a href="voter_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
