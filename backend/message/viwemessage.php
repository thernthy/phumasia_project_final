<?php
 include"../includes/header.php";
   // checking if the variable viwemease if someone click it
   if(isset($_GET['viewmessage'])) {
      $viweMessageID = $_GET['viewmessage'];
      $status = 1; 
      $query = "UPDATE message SET status = {$status} WHERE id = $viweMessageID ";
        $messagetook = mysqli_query($conn, $query);
        if (!$messagetook) {
            echo "something went wrong ". mysqli_error($conn);
          }
   }
   // SQL query to select all the data from the table where id = $postId
   $query = "SELECT * FROM message WHERE id = $viweMessageID ";
   $view_users = mysqli_query($conn, $query);
   while($row = mysqli_fetch_assoc($view_users)) {
      $id = $row['id'];
      $cp_email = $row['email'];
      $cp_phoneNumber = $row['phoneNumber'];
      $cp_subject = $row['subject'];
      $cp_messages = $row['messages'];
      $status = $row['status'];
   }
   echo"
   <div class='card shadow p-3 mb-5 bg-body-tertiary rounded' style='width: 450px; margin: 5rem auto;'>
            <div class='card-header'>
               {$cp_email}
            </div>
            <div class='card-body'>
               <h5 class='card-title'>{$cp_subject}</h5>
               <p class='card-text'>{$cp_messages}</p>
               <p><strong>{$cp_phoneNumber}</strong></p>
               <a href='../index.php' class='btn btn-primary'>Back</a>
            </div>
      </div>
   ";
?>