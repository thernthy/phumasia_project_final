<?php
include "js_request/db_connection.php";
$chickenType = $_GET["chicken_type"];
if ($chickenType === "chicken") {
    $get_chiken_barcode = ("SELECT chiken_barcode FROM chiken WHERE chiken_status='active'");
  } elseif ($chickenType === "b_chicken") {
      $get_chiken_barcode = ("SELECT Ch_barcode, Status FROM b_chiken WHERE Status='active'");
  }
  $bornBarCodeIds = array();
  $b_chi = mysqli_query($conn, $get_chiken_barcode);
  while($row = mysqli_fetch_assoc($b_chi)) {
    if($chickenType === "chicken"){
    $bornBarCodeIds[] = $row['chiken_barcode'];
    }if($chickenType === "b_chicken"){
     $bornBarCodeIds[] = $row['Ch_barcode'];
    }
  }
  // Respond with the born bar code IDs as JSON
  header("Content-Type: application/json");
  echo json_encode($bornBarCodeIds);
?>