<?php

$hostname = "localhost";
$dbUser = "root";
$dbpassword ="";
$dbName ="login-register";

$conn = mysqli_connect($hostname , $dbUser , $dbpassword , $dbName);
if (!$conn) {
   die("somthing went worng". mysqli_connect_error());
}


?>