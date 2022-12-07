<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TheCraftsman / Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <section style="background: url(&quot;assets/img/mountain_bg.jpg&quot;);">
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="background: rgba(255,255,255,0);">
            <div class="container">
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"></li>
                        <li class="nav-item"></li>
                    </ul><span class="navbar-text actions"> <a class="btn btn-light action-button" role="button" href="register.php">Sign Up</a></span>
                </div>
            </div>
        </nav>
        <section class="login-clean" style="background: rgba(241,247,252,0);">
            <form method="post">
                <h2 class="sr-only">Login Form</h2>
                <div class="illustration"><img width="200" src="assets/img/logo.png"></div>
                <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username" required=""></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" required=""></div>
                <div class="form-group"><?php DisplayOutput(); ?></div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="submit" style="background: rgb(86,198,198);">Log In</button></div><a class="forgot" href="#">Forgot your email or password?</a>
            </form>
        </section>
    </section>
    <section>
        <footer class="footer-basic">
            <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Services</a></li>
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">TheCraftsman © 2021</p>
        </footer>
    </section>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
function DisplayOutput(){
    session_start();
    require 'connect.php';

    $user_username = @$_POST['username'];
    $user_password = @$_POST['password'];

    if(isset($_POST['submit'])){
        if(!empty($user_username && $user_password)){
            $check_result = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '$user_username'");
            $rows = mysqli_num_rows($check_result);
    
            if($rows != 0){
                while($row = mysqli_fetch_assoc($check_result)){
                    $check_username = $row['user_username'];
                    $check_password = $row['user_password'];
                    $check_if_verified = $row['user_verification_status'];
                }
    
                if($user_username == $check_username && sha1($user_password) == $check_password){
                    if($check_if_verified == 1){
                        $_SESSION['username'] = $user_username;
                        header("Location: index.php");
                    } else {
                        echo "Please verify your account.";
                    }            
                } else {
                    echo "User and Password does not match.<br>";
                }
            } else {
                echo "User is not found.";
            }
        } else {
            echo "Fill out the field.";
        }
    }
}

?>
