<?php
$host = 'localhost';  // server
$user = 'root';
$pass = '';
$database = 'scy_chiken_db';
// Establishing connection
$conn = mysqli_connect($host, $user, $pass, $database);
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>