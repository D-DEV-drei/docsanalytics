<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dmpar_db";

// establish connection
$con = mysqli_connect($host, $username, $password, $database);

//check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error()); // if connection failed, this will executed
}
