<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dmpar_db";
$port = 3308; // Specify the port number here

// establish connection
$con = mysqli_connect($host, $username, $password, $database, $port);

//check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error()); // if connection failed, this will executed
}
?>