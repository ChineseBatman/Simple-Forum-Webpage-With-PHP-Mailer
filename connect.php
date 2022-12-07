<?php
$servername = "localhost";
$dbname = "thecraftsmen";
$username = "root";
$password = "";

//Default Time
date_default_timezone_set('Asia/Manila');

// Create connection
$connect = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connect->connect_error) {
die("Connection failed: " . $connect->connect_error);
}
?>