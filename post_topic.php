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
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/styles.css">
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
    <section class="contact-clean" style="background: url(&quot;assets/img/background.jpg&quot;)right / cover no-repeat;">
        <form method="post" enctype="multipart/form-data">
            <h2 class="text-center">Create a Topic</h2>
            <div class="form-group"><input class="form-control" type="text" name="title" placeholder="Title"></div>
            <div class="form-group"><textarea class="form-control" name="content" placeholder="Content" rows="14"></textarea></div>
            <div class="form-group"><input class="form-control" type="file" name="upload-file"></div>
            <div class="form-group"><?php post_topic(); ?></div>
            <div class="form-group"><button class="btn btn-primary" type="submit" name="submit">Post </button></div>
        </form>
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

function post_topic(){
    $topic_title = @$_POST['title'];
    $topic_content = @$_POST['content'];
    $topic_date = date("Y-m-d");
    require 'connect.php';
    if(isset($_POST['submit'])){
        $allowed_ext = array('png', 'jpg', 'jpeg', 'gif', 'mp4', 'ogg');
        $file_get = $_FILES['upload-file'];
        $file_name = $file_get['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $file_size = $file_get['size'];
        $file_tmp = $file_get['tmp_name'];
        $allowed_size = pow(1024, 50);
        if(in_array($file_ext, $allowed_ext) === true){
            if($file_size <= $allowed_size){
                if(!empty($topic_title && $topic_content || $file_get)){
                    move_uploaded_file($file_tmp, 'assets/files/'.$file_name);
                    $file_upload = 'assets/files/'.$file_name;
                    $sql = "INSERT INTO topics (topic_id, topic_name, topic_content, topic_file, topic_creator, topic_date) VALUES ('', '$topic_title', '$topic_content', '$file_upload', '".$_SESSION['username']."', '$topic_date')";
                    if(mysqli_query($connect, $sql)){
                        echo "<script>alert('Successfully Posted.'); location.href='index.php';</script>";
                    } else {
                        echo "Failed".$connect->error;
                    }
                } else {
                    Echo '<div role="alert" class="alert alert-warning"><span>Please fill all the field.</span></div>';
                }
            }
        } else {
            if(!empty($topic_title && $topic_content)){
                move_uploaded_file($file_tmp, 'assets/files/'.$file_name);
                $file_upload = 'assets/files/'.$file_name;
                $sql = "INSERT INTO topics (topic_id, topic_name, topic_content, topic_creator, topic_date) VALUES ('', '$topic_title', '$topic_content', '".$_SESSION['username']."', '$topic_date')";
                if(mysqli_query($connect, $sql)){
                    echo "<script>alert('Successfully Posted.'); location.href='index.php';</script>";
                } else {
                    echo "Failed".$connect->error;
                }
            } else {
                Echo '<div role="alert" class="alert alert-warning"><span>Please fill all the field.</span></div>';
            }
        }       
    }
}

?>