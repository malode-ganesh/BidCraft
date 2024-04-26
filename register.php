<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $pwd = $_POST['pwd'];

    //check user if already exists
    $checkQuery = "Select * from users where email='$email'";
    $result = $con->query($checkQuery);
    if($result->num_rows >0){
        echo "<script>alert('User with this email is already registered.');</script>";
    }else{
        $sql = "insert into users(email, name,contact,pwd) values('$email','$name','$contact','$pwd')";
        if($con->query($sql) === TRUE){
            #echo "<script>alert('User registered successfully.');</script>";
            header("Location:login.php?msg=valid");
        } else {
            echo "Error: " . $insert_query . "<br>" . $con->error;
        }
    }
}
?>