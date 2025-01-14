<?php
$servername = "localhost";
$username = "root";
$password = "";  // Keep this empty if there is no password for the MySQL user
$dbname = "online_voting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
