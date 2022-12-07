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

if(@$_GET['id']){
    require 'connect.php';
    $update_topic = mysqli_query($connect, "SELECT * FROM topics WHERE topic_id = '".$_GET['id']."'");
    $update_rows = mysqli_num_rows($update_topic);
    while($update_row = mysqli_fetch_assoc($update_topic)){
        $result_view = $update_row['topic_views'];
        $increment_view = $result_view + 1;
        $sql = "UPDATE topics SET topic_views = '$increment_view' WHERE topic_id = '".$_GET['id']."'";
        mysqli_query($connect, $sql);
    }
} else {
    header('Location: index.php');
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
}

$check_user_topic = mysqli_query($connect, "SELECT * FROM topics WHERE topic_id = '".$_GET['id']."'");
$rows = mysqli_num_rows($check_user_topic);
while($row = mysqli_fetch_assoc($check_user_topic)){
    $view_topic_id = $row['topic_id'];
    $view_user_topic = $row['topic_name'];
    $view_user_content = $row['topic_content'];
    $view_user_files = $row['topic_file'];
    $view_user_creator = $row['topic_creator'];
    $view_user_date = $row['topic_date'];

    $check_user_result = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '".$row['topic_creator']."'");
    $check_user_rows = mysqli_num_rows($check_user_result);
    while($check_user_row = mysqli_fetch_assoc($check_user_result)){
        $user_id = $check_user_row['user_id'];
    }
}

function file_type(){
    require 'connect.php';
    $check_user_topic = mysqli_query($connect, "SELECT * FROM topics WHERE topic_id = '".$_GET['id']."'");
    $rows = mysqli_num_rows($check_user_topic);
    while($row = mysqli_fetch_assoc($check_user_topic)){
        $view_user_files = $row['topic_file'];
        $ext_file= array('png', 'jpg', 'jpeg', 'gif');
        $ext_file2= array('mp4', 'ogg');
        $file_name = explode(".", $view_user_files);
        $file_ext = strtolower(end($file_name));
        $image_file = $view_user_files;
        $video_file = $view_user_files;
        if(!empty($view_user_files)){
            if(in_array($file_ext, $ext_file) === true){
                echo '<img src="'.$image_file.'" style="max-width: 100%;"/>';
            } elseif(in_array($file_ext, $ext_file2) === true){
                echo '<video style="max-width: 100%;" controls="">
                        <source src="'.$video_file.'" type="video/mp4">
                      </video>';
            } else {
                echo "<hr>";
            }
        }
    }
}


function confirm_user(){
    require 'connect.php';
    $check_user_topic = mysqli_query($connect, "SELECT * FROM topics WHERE topic_id = '".$_GET['id']."'");
    $rows = mysqli_num_rows($check_user_topic);
    while($row = mysqli_fetch_assoc($check_user_topic)){
        $view_user_topic = $row['topic_name'];
        $view_user_content = $row['topic_content'];
        $view_user_creator = $row['topic_creator'];
        $view_user_date = $row['topic_date'];
    }

    $check_user_info = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '".$_SESSION['username']."'");
    $rows = mysqli_num_rows($check_user_info);
    while($row = mysqli_fetch_assoc($check_user_info)){
        $user_level = $row['user_level'];
    }
    
    $user_confirm_level = 'admin';

    if($_SESSION['username'] == $view_user_creator || $user_level == $user_confirm_level){
        echo '<div class="container d-xl-flex justify-content-xl-end align-items-xl-center">
            <div><a class="btn btn-primary btn-lg" role="button" data-toggle="modal" href="#myModal" style="background: var(--red);">Delete Topic</a>
                <div class="modal fade" role="dialog" tabindex="-1" id="myModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Delete Topic</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-center text-muted">Are you sure you want to delete this topic? </p>
                            </div>
                            <form method="post"><div class="modal-footer"><button class="btn btn-light" data-dismiss="modal" type="button">Close</button><button class="btn btn-primary" style="background: var(--red);" type="submit" name="delete">Delete</button></div></form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>';
    } else {
        echo '<hr>';
    }
}

function user_topic_reply(){
    require 'connect.php';
    $sql = "SELECT * FROM post WHERE post_topic = '".$_GET['id']."'";
    $check_post_id = mysqli_query($connect, $sql);
    $rows = mysqli_num_rows($check_post_id);
    while($row = mysqli_fetch_assoc($check_post_id)){
        $posted_by = $row['post_by'];
        $user_post_content = $row['post_content'];
        $user_post_date = $row['post_date'];
        $user_post_by = $row['post_by'];

        $check_user_info = mysqli_query($connect, "SELECT * FROM users WHERE user_username = '$posted_by'");
        $rows = mysqli_num_rows($check_user_info);
        while($row = mysqli_fetch_assoc($check_user_info)){
            $user_id = $row['user_id'];
            $user_username = $row['user_username'];
            $user_profile_picture = $row['user_profile_picture'];

            echo '<li class="list-group-item" style="margin-bottom:6px;">';
            echo '<div class="media">';
            echo '<div></div>';
            echo '<div class="media-body">';  
            echo '<div class="media" style="overflow:visible;">';       
            echo "<div><img class='mr-3' style='width: 25px; height:25px;' src='$user_profile_picture'></div>";
            echo '<div class="media-body" style="overflow:visible;">';               
            echo '<div class="row">';            
            echo '<div class="col-md-12">';
            echo "<p><a href='viewprofile.php?id=$user_id'>$user_post_by:</a> $user_post_content <br>";                    
            echo "<small class='text-muted'> $user_post_date</small></p>";
            echo '              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>';
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $view_user_topic ?></title>
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
                        <li class="nav-item"><a class="nav-link" href="./index.php">Home</a></li>
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
        <div class="container" style="border-radius: 16px;margin-top: 13px;box-shadow: 5px 5px 20px rgba(33,37,41,0.2);color: rgb(252,117,54);border: 1px solid rgb(137,82,56) ;">
            <div class="row" style="padding: 10px;">
                <div class="col-md-12">
                    <h2><?php echo $view_user_topic; ?></h2>
                    <small class="d-inline" style="margin-right: 20px;">Posted by:&nbsp;<a href="viewprofile.php?id=<?php echo $user_id ?>"><?php echo $view_user_creator; ?></a></small>
                    <small class="d-inline">Date: <?php echo $view_user_date; ?></small>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p style="padding: 5px;margin: 20px;"><?php echo $view_user_content; ?></p>
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col">
                    <?php file_type(); ?>
                </div>
            </div>
        </div>
    </section>
    <section style="margin: 18px;">
        <?php confirm_user(); ?>
    </section>
    <section style="margin: 18px;">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4>Comment</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php user_topic_reply(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section style="margin: 18px;">
        <div class="container">
        <form method="post">
            <h4>Reply</h4><textarea name="user-reply" style="width: 369px;height: 150px;"></textarea><button class="btn btn-primary d-block" type="submit" name="reply" style="background: rgb(249,121,57);">Reply</button>
            </div>
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

if(isset($_POST['delete'])){
    $sql = "DELETE FROM topics WHERE topic_id = '".$_GET['id']."'";
    mysqli_query($connect, $sql);
    echo "<script>alert('Topic has been delete.'); location.href='index.php';</script>";
}

if(isset($_POST['reply'])){
    $reply_content = $_POST['user-reply'];
    $reply_user = $_SESSION['username'];
    $get_topic_id = $view_topic_id;
    $today = date("Y-m-d H:i:s");
    if(!empty($reply_content)){
        $sql = "INSERT INTO post (post_id, post_content, post_date, post_topic, post_by) VALUES ('', '$reply_content', '$today','$get_topic_id',  '$reply_user')";
        if(mysqli_query($connect, $sql)){
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Failed".$connect->error;
        } 
    } else {
        // echo "Fill the field.";
    }
}

?>