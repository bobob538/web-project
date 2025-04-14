<?php

$hostname = "localhost";
$dbUser = "root";
$dbpassword ="";
$dbName ="login-register";

$coon = mysqli_connect($hostname , $dbUser , $dbpassword , $dbName);
if (!$coon) {
   die("somthing went worng");
}


?>