<?php
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
    <title>Voting Page</title>
    <style>
        /* Page background and form styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #ccffcc; /* Light green background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #004d40;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            text-align: left;
            color: #333;
        }

        select, button {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        button {
            background-color: #004d40;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #00332c;
        }

        a {
            color: #004d40;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <?php
            if ($result->num_rows > 0) {
                echo '<h2>Vote for Your Candidate</h2>';
                echo '<form action="submit_vote.php" method="POST">';
                
                // Dropdown for selecting positions
                echo '<label for="position">Choose a position:</label>';
                echo '<select name="position" id="position" required>';
                echo '<option value="" disabled selected>Select a position</option>';

                // Fetch distinct positions for the dropdown
                $positions_sql = "SELECT DISTINCT position FROM candidates";
                $positions_result = $conn->query($positions_sql);
                
                if ($positions_result->num_rows > 0) {
                    while ($row = $positions_result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['position']) . '">' . htmlspecialchars($row['position']) . '</option>';
                    }
                }

                echo '</select>';
                echo '<br>';

                // Dropdown for selecting candidates
                echo '<label for="candidate">Choose a candidate:</label>';
                echo '<select name="candidate_id" id="candidate" required>';
                echo '<option value="" disabled selected>Select a candidate</option>';
                echo '</select>';
                
                echo '<br>';
                echo '<button type="submit">Vote</button>';
                echo '</form>';
            } else {
                echo 'No candidates available.';
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Script to dynamically load candidates based on position -->
    <script>
    document.getElementById('position').addEventListener('change', function() {
        var position = this.value;
        var candidateSelect = document.getElementById('candidate');

        // Clear current candidates
        candidateSelect.innerHTML = '<option value="" disabled selected>Select a candidate</option>';

        // Fetch candidates based on selected position
        fetch('fetch_candidates.php?position=' + encodeURIComponent(position))
            .then(response => response.json())
            .then(data => {
                data.forEach(candidate => {
                    var option = document.createElement('option');
                    option.value = candidate.id;
                    option.textContent = candidate.name + ' - ' + candidate.position;
                    candidateSelect.appendChild(option);
                });
            });
    });
    </script>
</body>
</html>
