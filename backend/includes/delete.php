<!-- Footer -->
<?php  include "header.php" ?>
<?php 
     if(isset($_GET['delete']))
     {
         $postid = $_GET['delete'];
         // SQL query to delete data from user table where 
         $query = "DELETE FROM post WHERE id = {$postid}"; 
         $delete_query = mysqli_query($conn, $query);
          echo"<script type='text/javascript'>alert('The data has deleted from table')</script>";
          header('location: ..\index.php');
     }
  ?>