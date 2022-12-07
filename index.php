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
    <title>TheCraftsman</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <section>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean">
            <div class="container"><a class="navbar-brand" href="./index.php"><img src="assets/img/logo.png" width="200"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link active" href="./index.php">Home</a></li>
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><img class="rounded-circle" src="<?php echo $user_profile_picture; ?>" style="margin: 5px;" width="30" height="30"><?php echo $user_username; ?> </a>
                                <div class="dropdown-menu"><a class="dropdown-item" href="./profile.php">My Profile</a><a class="dropdown-item" href="accountsetting.php">Account Setting</a><a class="dropdown-item" href="index.php?action=logout">Logout</a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header style="background: url(&quot;assets/img/background.jpg&quot;) right / cover;height: 223px;"></header>
    </section>
    <section class="d-xl-flex justify-content-xl-center align-items-xl-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><span class="d-flex d-xl-flex justify-content-end justify-content-xl-end align-items-xl-center" style="padding: 0;margin: 0px;padding-bottom: 10px;padding-top: 10px;"><a href="./post_topic.php"><button class="btn btn-primary" type="button" style="width: 132.5px;padding: 9px 12px;">Post Topic</button></a></span></div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 630px;">Topic</th>
                                    <th style="width: 160px;">Views</th>
                                    <th style="width: 160px;">Poster By</th>
                                    <th style="width: 160px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $check_topics = mysqli_query($connect, "SELECT * FROM topics");
                                $topics_rows = mysqli_num_rows($check_topics);

                                if($topics_rows != 0){
                                    while($row = mysqli_fetch_assoc($check_topics)){
                                        $id = $row['topic_id'];
                                        echo "<tr><td><a href='./forum.php?id=$id'>".$row['topic_name']."</a></td>";
                                        echo "<td>".$row['topic_views']."</td>";

                                        $check_user_result = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '".$row['topic_creator']."'");
                                        $check_user_rows = mysqli_num_rows($check_user_result);
                                        while($check_user_row = mysqli_fetch_assoc($check_user_result)){
                                            $user_id = $check_user_row['user_id'];
                                            echo "<td><a href='viewprofile.php?id=$user_id'>".$row['topic_creator']."</td>";
                                        }
                                        
                                        echo "<td>".$row['topic_date']."</td></tr>";
                                    }
                                }                  
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col d-xl-flex justify-content-xl-end align-items-xl-center">
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                    <li class="page-item"><a class="page-link" href="#Page1">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#Page2">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#Page3">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#Page4">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#Page5">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
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