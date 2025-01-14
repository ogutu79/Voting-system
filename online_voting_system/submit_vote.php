<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected candidate ID from the form
    $candidate_id = $_POST['candidate_id'];

    // Insert the vote into the database
    $stmt = $conn->prepare("INSERT INTO votes (candidate_id) VALUES (?)");
    $stmt->bind_param("i", $candidate_id);

    if ($stmt->execute()) {
        // If the vote is submitted successfully, show the success message
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Vote Submitted</title>
            <style>
                /* Style for centering the message */
                body {
                    background-color: #ccffcc; /* Light green background */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    font-family: Arial, sans-serif;
                }
                .message {
                    text-align: center;
                    color: red;
                    font-size: 24px;
                    font-weight: bold;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                a {
                    display: block;
                    margin-top: 20px;
                    text-decoration: none;
                    color: #004d40;
                    font-size: 18px;
                }
                .links {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="message">
                Vote Submitted Successfully!
                <div class="links">
                    <a href="voting_page.php">Back to Voting Page</a>
                    <a href="voter_view_results.php">View Election Results</a>
                    <a href="voter_dashboard.php">Back to Dashboard</a>
                </div>
            </div>
        </body>
        </html>';
    } else {
        echo "Error submitting vote: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
