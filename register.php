<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>TheCraftsman / Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <section></section>
    <header class="header-dark">
        <nav class="navbar navbar-dark navbar-expand-lg navigation-clean-search">
            <div class="container"><a href="./index.php"><img src="assets/img/logo.png" width="200"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav">
                        <li class="nav-item"></li>
                    </ul><span class="mr-auto navbar-text"></span><a class="btn btn-light action-button" role="button" href="./login.php">Log in</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <section class="register-photo" style="background: rgba(241,247,252,0);">
                <div class="pulse animated form-container">
                    <div class="image-holder"></div>
                    <form method="post">
                        <h2 class="text-center"><strong>Create</strong> an account.</h2>
                        <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username" required="" minlength="5" maxlength="13"></div>
                        <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                        <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" minlength="6"></div>
                        <div class="form-group"><input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)"></div>
                        <div class="form-group">
                            <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="checkbox" required="">I agree to the license terms.</label></div>
                        </div>
                        <div class="form-group"><?php DisplayOutput(); ?></div>
                        <div class="form-group"><button class="btn btn-primary btn-block" data-bss-hover-animate="pulse" type="submit" name="submit" style="background: rgb(32,143,143);">Sign Up</button></div><a class="already" href="#">You already have an account? Login here.</a>
                    </form>
                </div>
            </section>
        </div>
    </header>
    <footer class="footer-basic">
        <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
        <ul class="list-inline">
            <li class="list-inline-item"><a href="index.php">Home</a></li>
            <li class="list-inline-item"><a href="#">Services</a></li>
            <li class="list-inline-item"><a href="#">About</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
        </ul>
        <p class="copyright">TheCraftsman © 2021</p>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
</body>

</html>

<?php

//Email Verification must be included... please include this sooner you shit!

function DisplayOutput(){
    require 'connect.php';
    require 'SendMail.php';

    $user_username = @$_POST['username'];
    $user_email = @$_POST['email'];
    $user_password = @$_POST['password'];
    $user_password_repeat = @$_POST['password-repeat'];
    $user_checkbox = @$_POST['checkbox'];
    $user_date = date("Y-m-d");
    $user_verification_code = uniqid();

    

    $insert = mysqli_connect($servername, $username, $password, $dbname);

    if($insert === false){
        die("ERROR: Could not connect. ".mysqli_connect_error());
    }

    if(isset($_POST['submit'])){
        if($user_username && $user_password && $user_password_repeat && $user_email){
            if(strlen($user_username) >= 5 && strlen($user_username) <= 25 && strlen($user_password) >= 6){
                if($user_password_repeat == $user_password){
                    if($user_checkbox == true){
                        //password encryption
                        $user_password_encrypt = sha1($user_password);

                        $check_username_exist = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '$user_username'");
                        $username_rows = mysqli_num_rows($check_username_exist);
                        if($username_rows == 0){
                            $check_email_exist = mysqli_query($connect, "SELECT * FROM users WHERE user_email = '$user_email'");
                            $email_rows = mysqli_num_rows($check_email_exist);
                            if($email_rows == 0){
                            $sql = "INSERT INTO users (user_id, user_username, user_password, user_email, user_date, user_verification_code) VALUES ('', '$user_username', '$user_password_encrypt', '$user_email', '$user_date', '$user_verification_code')";
                            if(mysqli_query($insert, $sql)){
                                $mail->setFrom($PHP_email, 'Account Verification');
                                $mail->Subject = 'Please Verify Your Account!';
                                $mail->Body    = "<h3>Welcome To TheCraftsmen Forum</h3>
                                                    <p>Click the link below to verify your account:</p>
                                                    <a href='http://localhost/TheCraftsmen/activateuser.php?user_verification_code=$user_verification_code'>Click Here</a>";
                                $mail->addAddress($user_email, $user_username);     //Add a recipient
                                if(!$mail->send()){
                                    echo '<div role="alert" class="alert alert-warning"><span>"Message could not be sent. Mailer Error: "{$mail->ErrorInfo}</span></div>';
                                } else {
                                    echo '<div role="alert" class="alert alert-success"><span>Email Verification Has Been Sent To Your Email</span></div>';
                                }
                            } else { 
                                echo '<div role="alert" class="alert alert-warning"><span>"ERROR: Could not able to execute $sql. ".mysqli_error($insert)</span></div>';;
                            }
                            } else {
                                echo '<div role="alert" class="alert alert-success"><span>This email already exist.</span></div>';
                            }
                        } else {
                            echo '<div role="alert" class="alert alert-success"><span>This username already exist.</span></div>';
                        }
                    } else { 
                        echo '<div role="alert" class="alert alert-warning"><span>You do not agree to the license term.</span></div>';
                    }
                } else {
                    echo '<div role="alert" class="alert alert-warning"><span>Password do not match.</span></div>';
                }
            } else {
                if(strlen($user_username) < 5 || strlen($user_username) > 25){
                    echo '<div role="alert" class="alert alert-warning"><span>Username must be between 5 and 25 characters.</span></div>';
                } 

                if(strlen($user_password) < 6){
                    echo "Password must be longer than 6 characters.";
                }
            }
        } else {
            echo "Please fill in all the fields.";
        }
    }
}
mysqli_close($connect);

?>
