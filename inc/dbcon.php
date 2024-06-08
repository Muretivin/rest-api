<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "phpapi";


$conn = mysqli_connect($host, $username, $password, $dbname);
 if (!$conn) {
    die("connection Failed:" .mysqli_connect_error());
 }

?>