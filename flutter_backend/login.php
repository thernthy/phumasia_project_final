<?php
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
   $username = $_POST['username'];
   $userpass = $_POST['password'];
   $sql = "SELECT * FROM Appuser WHERE username = '" .$username. "' AND password = '".$userpass."'";
   $result = mysqli_query($conn,$sql);
   $count = mysqli_num_rows($result);
   if($count == 1){
    echo json_encode("Success");

   }else{
     echo json_encode("Error!");
   }
?>