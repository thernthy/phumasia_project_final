<!-- Header -->
<?php 
include "header.php"; 

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: login.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: login.php');
}
?>
<!-- home page top navBar block -->
<?php include "navBar.php";?>

<!-- body -->
<?php include "Adminbody.php";?>