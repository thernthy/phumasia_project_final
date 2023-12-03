<?php
include "db.php";
?>
<style>
    /* Container */
    .container{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Login */
    #div_login{
        border: 1px solid gray;
        border-radius: 3px;
        width: 470px;
        height: 270px;
        box-shadow: 0px 2px 2px 0px gray;
    }

    #div_login h1{
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: cornflowerblue;
        color: white;
        font-family: sans-serif;
    }

    #div_login div{
        clear: both;
        margin-top: 10px;
        padding: 5px;
    }

    #div_login .textbox{
        width: 96%;
        padding: 7px;
    }

    #div_login input[type=submit]{
        padding: 7px;
        width: 100px;
        background-color: lightseagreen;
        border: 0px;
        color: white;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="custom.css">
 
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
 
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>PhumasiaAdmin</title>    
</head>
<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" id="txt_uname" name="txt_pwd" placeholder="Password"/>
            </div>
            <div>
                <input type="submit" value="Submit" name="but_submit" id="but_submit" />
            </div>
        </div>
        <div>
            <?php if(isset($_POST['but_submit'])){
                        $uname = mysqli_real_escape_string($conn,$_POST['txt_uname']);
                        $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
                        if ($uname != "" && $password != ""){

                            $sql_query = "SELECT count(*) as cntUser from users where username='".$uname."' and password='".$password."'";
                            $result = mysqli_query($conn,$sql_query);
                            $row = mysqli_fetch_array($result);

                            $count = $row['cntUser'];
                            if($count > 0){
                                $_SESSION['uname'] = $uname;
                                header('Location: index.php');
                            }else{
                                echo "<div class='alert alert-danger' role='alert'>Invalid username or password </div>";
                            }
                        }

                        }
                ?>
        </div>
    </form>
</div>
