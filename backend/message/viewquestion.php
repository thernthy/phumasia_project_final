<?php
 include"../includes/header.php";
   // checking if the variable viwemease if someone click it
   if(isset($_GET['viewquestion'])) {
      $viewquestion = $_GET['viewquestion'];
      $action = 1;
      $query = "UPDATE asking SET action = {$action} WHERE id = $viewquestion ";
        $messagetook = mysqli_query($conn, $query);
        if (!$messagetook) {
            echo "something went wrong ". mysqli_error($conn);
          }
   }
    $query = "SELECT * FROM asking WHERE id = $viewquestion ";
   $view_users = mysqli_query($conn, $query);
   while($row = mysqli_fetch_assoc($view_users)) {
      $id = $row['id'];
      $email = $row['email'];
      $senderName = $row['sender_name'];
      $phoneNumber= $row['phone_number'];
      $they_want_to_do = $row['they_want_to_do'];
      $member = $row['members'];
      $messages = $row['messages'];
      $action = $row['action'];
   }
   echo"
   <div class='card shadow p-3 mb-5 bg-body-tertiary rounded' style='width: 450px; margin: 5rem auto;'>
            <div class='card-header'>
               {$email}<br/>
               <span>Name: {$senderName} </span>
            </div>
            <div class='card-body'>
               <h6 class='card-title'>members: {$member}</h6>
               <p class='card-text'>{$messages}</p>
               <p><strong>{$phoneNumber}</strong></p>
               <a href='../index.php' class='btn btn-primary'>Back</a>
            </div>
      </div>
   ";
?>