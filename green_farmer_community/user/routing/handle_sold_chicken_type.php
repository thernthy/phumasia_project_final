<?php
include "js_request/db_connection.php";
$chickenType = $_GET["chicken_type"];
if ($chickenType === "chicken") {
    $get_chiken_barcode = ("SELECT 
    chiken_barcode, chiken_sold, chiken_sold_date, chiken_status   
    FROM chiken 
    WHERE chiken_status='active' 
    ORDER BY chiken_sold_date DESC");
  } elseif ($chickenType === "b_chicken") {
      $get_chiken_barcode = ("SELECT Ch_barcode, Sold_date, Status FROM b_chiken 
      WHERE Status='active' ORDER BY Sold_date DESC");
  }
  $chicken_sold_barcode = array();
  $b_chi = mysqli_query($conn, $get_chiken_barcode);
  while($row = mysqli_fetch_assoc($b_chi)) {
    if($chickenType === "chicken"){
    $chicken_sold_barcode[] = $row['chiken_barcode'];
    }if($chickenType === "b_chicken"){
     $chicken_sold_barcode[] = $row['Ch_barcode'];
    }
  }
  // Respond with the born bar code IDs as JSON
  header("Content-Type: application/json");
  echo json_encode($chicken_sold_barcode);
?>