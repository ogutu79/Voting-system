<?php
// Password to hash
$password = '12345678';

// Hash the password using the BCRYPT algorithm
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo $hashed_password;
?>
