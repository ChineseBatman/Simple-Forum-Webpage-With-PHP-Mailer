<!DOCTYPE html>
<html lang="en">

<?php
session_start();
//Current Login User
if(@$_SESSION["username"]){
    require 'connect.php';
} else {
    header("Location: login.php");
}
//Logout User
if(@$_GET['action'] == 'logout'){
    session_destroy();
    header("Location: login.php");
}

$check_user_info = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '".$_SESSION['username']."'");
$rows = mysqli_num_rows($check_user_info);
while($row = mysqli_fetch_assoc($check_user_info)){
    $user_username = $row['user_username'];
    $user_email = $row['user_email'];
    $user_profile_picture = $row['user_profile_picture'];
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Account Settings</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
</head>

<body>
    <section>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean">
            <div class="container"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1"><a href="./index.php"><img src="assets/img/logo.png" width="200"></a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="./index.php">Home</a></li>
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><img class="rounded-circle" src="<?php echo $user_profile_picture; ?>" style="margin: 5px;" width="30" height="30"><?php echo $user_username; ?> </a>
                            <div class="dropdown-menu"><a class="dropdown-item" href="./profile.php">My Profile</a><a class="dropdown-item" href="accountsetting.php">Account Setting</a><a class="dropdown-item" href="index.php?action=logout">Logout</a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
    <section style="background: url(&quot;assets/img/background.jpg&quot;) right / cover no-repeat; padding-top: 30px;">
        <div class="col-lg-12 d-lg-flex justify-content-lg-center">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 font-weight-bold">User Settings</p>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col d-xl-flex justify-content-xl-center align-items-xl-center"><img class="d-xl-flex justify-content-xl-center align-items-xl-center" src="<?php echo $user_profile_picture; ?>" width="300" height="300"></div>
                        </div>
                        <div class="form-row">
                            <div class="col"><input class="form-control-file" type="file" name="image" style="padding: 20px 0px;"></div>
                        </div>
                        <div class="form-group"><?php upload_image(); ?></div>  
                        <div class="form-group"><button class="btn btn-primary btn-sm" name="upload" type="upload">Upload</button></div>
                    </form>
                    <form method="post">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group"><label for="email"><strong>Email Address</strong></label><input class="form-control" type="email" placeholder="<?php echo $user_email; ?>" name="email" readonly=""></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group"><label for="Username"><strong>Username</strong><br></label><input class="form-control" type="text" placeholder="<?php echo $user_username; ?>" name="username" readonly=""></div>
                                <div class="form-group"><label for="current_password"><strong>Current Password</strong><br></label><input class="form-control" type="password" placeholder="password" name="current-password"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group"><label for="new_password"><strong>New Password</strong><br></label><input class="form-control" type="password" name="new-password" placeholder="New Password"></div>
                            </div>
                            <div class="col">
                                <div class="form-group"><label for="confirm_new_password"><strong>Confirm New Password</strong><br></label><input class="form-control" type="password" name="confirm-new-password" placeholder="(Confirm) New Password"></div>
                            </div>
                        </div>
                        <div class="form-group"><?php update_password(); ?></div>  
                        <div class="form-group"><button class="btn btn-primary btn-sm" name="update" type="submit">Update</button></div>
                    </form>
                </div>
            </div>
        </div>
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

function upload_image(){
    require 'connect.php';
    if(isset($_POST['upload'])){
        //upload image
        $allowed_ext = array('png', 'jpg', 'jpeg', 'gif');
        $file_get = $_FILES['image'];
    
        $file_name = $file_get['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $file_get['size'];
        $file_tmp = $file_get['tmp_name'];
        $allowed_size = pow(1024, 2);
    
        if(!empty($file_name)){
            if(in_array($file_ext, $allowed_ext) === true){
                if($file_size <= $allowed_size){
                    move_uploaded_file($file_tmp, 'assets/profile/'.$file_name);
                    $image_upload = 'assets/profile/'.$file_name;
                    $sql = "UPDATE users SET user_profile_picture = '$image_upload' WHERE user_username = '".$_SESSION['username']."'";
                    if(mysqli_query($connect, $sql)){
                        echo "Profile Picture has been updated.";
                        echo "<meta http-equiv='refresh' content='0'>";
                    } else {
                        echo '<div role="alert" class="alert alert-warning"><span>failed to update profile picture.</span></div>';
                    }
                } else {
                    echo '<div role="alert" class="alert alert-warning"><span>File must be under 2mb</span></div>';
                }
            } else {
                echo '<div role="alert" class="alert alert-warning"><span>this file extension is not allowed.</span></div>';
            }
        } else {
            echo '<div role="alert" class="alert alert-warning"><span>There is no file to be upload.</span></div>';
        }   
    }    
}

function update_password(){
    require 'connect.php';
    $current_password = @$_POST['current-password'];
    $new_password = @$_POST['new-password'];
    $confirm_new_password = @$_POST['confirm-new-password'];

    if(isset($_POST['update'])){
        $check_user_info = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '".$_SESSION['username']."'");
        $rows = mysqli_num_rows($check_user_info);
        while($row = mysqli_fetch_assoc($check_user_info)){
            $user_password = $row['user_password'];
        }

        //change password
        if($user_password == sha1($current_password)){
            if(strlen($new_password) >= 6){
                if($confirm_new_password == $new_password){
                    $encrypt_new_password = sha1($new_password);
                    if(mysqli_query($connect, "UPDATE users SET user_password = '$encrypt_new_password' WHERE user_username = '".$_SESSION['username']."'")){
                        echo "Password Changed.";                    
                    }
                } else {
                    echo '<div role="alert" class="alert alert-warning"><span>New password does not match.</span></div>';
                }
            } else {
                echo '<div role="alert" class="alert alert-warning"><span>New password should be more than 6 character</span></div>';
            }
        } else {
            echo '<div role="alert" class="alert alert-warning"><span>Incorrect password.</span></div>';
        }
    }
}
mysqli_close($connect);
?>