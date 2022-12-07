<?php

require 'connect.php';

$verify_code = $_GET['user_verification_code'];

$activate_user = "UPDATE users SET user_verification_status = 1 WHERE user_verification_code = '".$verify_code."'";
if(mysqli_query($connect, $activate_user)){
    echo "<script>alert('Account Has Been Verified.'); location.href='index.php';</script>";
}

?>