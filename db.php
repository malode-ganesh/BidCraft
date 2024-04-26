<?php
$server = "localhost";
$uname = "root";
$pwd = "";
$dbname = "bidcraft";

$con = new mysqli($server, $uname, $pwd, $dbname);
// $con = mysqli_connect($server,$uname,$pwd,$dbname);
if($con->connect_error){
    die("Connection failed: " . $conn->connect_error);
}


?>