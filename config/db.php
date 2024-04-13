<?php
// local
$host = "localhost";
$username = "root";
$password = "";
$database = "sust_main";
$port = 3306;

// live
// $host = "194.110.173.106";
// $username = "sust_matthew";
// $password = "qwe";
// $database = "sust_main";
// $port = 3306;

// establish connection
$con = mysqli_connect($host, $username, $password, $database);

//check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error()); // if connection failed, this will executed
}
?>