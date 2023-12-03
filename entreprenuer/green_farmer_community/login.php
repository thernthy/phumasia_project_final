<div class="box">
    <div class="container_login">
        <div class="top">
            <img src="assets/logo/web_logo_icon.ico" alt="green_farmer_community" class="shadow-sm p-3" width="80px" height="80px" style="display: block; margin: 1rem auto; border-radius: 20px;">
            <header>Login</header>
        </div>

        <form  method="POST"> <!-- Specify the action and method for form submission -->
            <div class="input-field">
                <input type="text" class="input" placeholder="Username" id="username" name="username"> <!-- Assign an ID and a name attribute -->
                <i class='bx bx-user'></i>
            </div>

            <div class="input-field">
                <input type="password" class="input" placeholder="Password" id="password" name="password"> <!-- Assign an ID and a name attribute -->
                <i class='bx bx-lock-alt'></i>
            </div>

            <div class="input-field">
                <input type="submit" class="submit" value="Login" id="loginButton" name="login"> <!-- Assign an ID to the submit button -->
            </div>
        </form>
    </div>
</div>
<?php
include "db_connection.php";
session_start();

if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($uname != "" && $password != "") {
        $sql_query = "SELECT `rol_check` FROM `scy_user_web_app` WHERE `username`='$uname' AND `password`='$password'";
        $result = mysqli_query($conn, $sql_query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $role = $row['rol_check'];

            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header('Location: green_farmer_admin/index.php');
            } else {
                header('Location: user/index.php');
            }
            exit;
        } else {
            echo "Invalid username and password";
        }
    }
}
?>
