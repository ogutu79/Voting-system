<?php
include 'db_connect.php';

// Fetch election results from the database
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
    <title>Election Results</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #ccffcc; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        .results-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #004d40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #004d40;
            color: #fff;
        }
        tr:hover {
            background-color: #f5f5f5;
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
        <div class="results-box">
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
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['position']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['votes']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">No results found.</td></tr>';
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <a href="admin_dashboard.php" class="back-link">Back to Admin Dashboard</a>
        </div>
    </div>
</body>
</html>
