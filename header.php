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
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean">
        <div class="container"><a class="navbar-brand" href="./index.php"><img src="assets/img/logo.png" width="200"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">First Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Second Item</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Third Item</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><img class="rounded-circle" src="<?php echo $user_profile_picture; ?>" style="margin: 5px;" width="30" height="30"><?php echo $user_username; ?> </a>
                            <div class="dropdown-menu"><a class="dropdown-item" href="./profile.php">My Profile</a><a class="dropdown-item" href="accountsetting.php">Account Setting</a><a class="dropdown-item" href="index.php?action=logout">Logout</a></div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>