<?php
session_start();
$server = "localhost";
$dbName = "group4";
$dbuser = "root";
$dbpassword = "";
$con = mysqli_connect($server,$dbuser,$dbpassword,$dbName);

if (!$con) {
    die("error".mysqli_connect_error());
}
?>