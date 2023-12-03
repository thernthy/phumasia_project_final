<?php
session_start();
//server with default setting (user 'root' with no password)
$host = 'mysql1b.xserver.jp';  // server 
$user = 'waa_phumasiacom';   
$pass = "EZ6F6DhJJJKF";   
$database = 'waa_phumasiacom';   //Database Name  
// establishing connection
  $conn = mysqli_connect($host,$user,$pass,$database);   
 // for displaying an error msg in case the connection is not established
  if (!$conn) {                                             
    die("Connection failed: " . mysqli_connect_error());     
  }
?>