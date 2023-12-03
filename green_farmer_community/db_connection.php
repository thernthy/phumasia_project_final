<?php
$host = 'mysql1b.xserver.jp'; 
$user = 'waa_phumasiacom';   
$pass = "EZ6F6DhJJJKF";   
$database = 'waa_phumasiacom'; 
// Establishing connection
$conn = mysqli_connect($host, $user, $pass, $database);
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>