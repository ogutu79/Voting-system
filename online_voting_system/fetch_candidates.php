<?php
include 'db_connect.php';

if (isset($_GET['position'])) {
    $position = $_GET['position'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT id, name, position FROM candidates WHERE position = ?");
    $stmt->bind_param("s", $position);
    $stmt->execute();

    $result = $stmt->get_result();
    $candidates = [];

    while ($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }

    // Output the results as JSON
    header('Content-Type: application/json');
    echo json_encode($candidates);

    // Close the statement and connection
    $stmt->close();
}
$conn->close();
?>
