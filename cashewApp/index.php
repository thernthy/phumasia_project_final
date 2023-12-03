<?php
include "db_conn.php";
if(isset($_POST['login'])){
    $uname = mysqli_real_escape_string($conn,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($conn,$_POST['txt_pwd']);
    if ($uname != "" && $password != ""){
        $sql_query = "SELECT role FROM Appuser WHERE username='".$uname."' AND password='".$password."'";
        $result = mysqli_query($conn, $sql_query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $role = $row['role'];
            // Start session and set logged-in status and role
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;

            if($role === 'admin'){
                header('Location: ./admin/index.php');
            } else {
                header('Location: ./publice/index.php');
            }
            exit;
        } else {
            echo "Invalid username and password";
        }
    }
}
?>

<style>
    /* Container */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Login */
    #div_login {
        border: 1px solid gray;
        border-radius: 3px;
        width: 400px;
        height: auto;
        box-shadow: 0px 2px 2px 0px gray;
    }

    #div_login h1 {
        margin-top: 0px;
        font-weight: normal;
        padding: 10px;
        background-color: cornflowerblue;
        color: white;
        font-family: sans-serif;
        text-align: center;
    }

    #div_login div {
        clear: both;
        margin: 10px;
        padding: 5px;
    }

    #div_login .textbox {
        width: 100%;
        padding: 7px;
    }

    #div_login input[type=submit] {
        padding: 7px;
        width: 100%;
        background-color: lightseagreen;
        border: 0px;
        color: white;
        cursor: pointer;
    }
</style>
<div class="container">
    <form method="post" action="">
        <div id="div_login">
            <h1>Login</h1>
            <div>
                <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" />
            </div>
            <div>
                <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password" />
            </div>
            <div>
                <input type="submit" value="Submit" name="login" id="but_submit" />
            </div>
        </div>
    </form>
</div>


