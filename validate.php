<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE email='$email' AND pwd='$password'";
    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['email'] = $email;
        header("Location: userDashboard.php");
    } else {
        header("Location: login.php?msg=invalid");
    }
}
?>