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
    $user_level = $row['user_level'];
    $user_profile_picture = $row['user_profile_picture'];
    $user_date_joined = $row['user_date'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Profile-Card.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
</head>

<body>
    <section><nav class="navbar navbar-light navbar-expand-md navigation-clean">
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
    <section>
    <div class="text-center profile-card" style="background-color:#ffffff;">
        <div class="profile-card-img" style="height: 150px;background: url(&quot;assets/img/background.jpg&quot;);"></div>
        <div><img class="rounded-circle" style="margin-top:-70px;" src="<?php echo $user_profile_picture; ?>" height="150px">
            <h3><?php echo $user_username; ?></h3>
            <p style="padding:10px;padding-bottom:0;padding-top:5px;">Email:&nbsp;<?php echo $user_email; ?></p>
            <p style="padding:10px;padding-bottom:0;padding-top:5px;">User Level:&nbsp;<?php echo $user_level; ?></p>
            <p style="padding:10px;padding-bottom:0;padding-top:5px;">Date Joined:&nbsp;<?php echo $user_date_joined; ?></p>
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