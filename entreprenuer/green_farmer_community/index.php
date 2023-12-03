<?php
include"db_connection/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>green Farmer community</title>
    <link rel="icon" href="assets/logo/web_logo_icon.ico" type="assets/logo/web_logo_icon.icon">
    <!-- ======= Styles Admin ====== -->
    <link rel="stylesheet" href="green_farmer_community_admin/assets/css/style.css">
</head>
<body>
 <?php
 if (isset($_GET['green_farmer'])) {
        $green_farmer = $_GET['green_farmer'];
        switch ($green_farmer) {
            case 'admin':
                include "green_farmer_community_admin/index.php";
                break;
            }
    }else{
        include"login.php";
    }

 ?>

</body>
</html>