<?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmOrder'])) {
            $stmt = $con->prepare("INSERT INTO orders (product_name, product_id, price, user_email, user_contact, user_address, user_name, payment_status) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sissssss", $productName, $productId, $price, $userEmail, $contact, $address, $userName, $paymentStatus);
            $productName = $_POST['productName'];
            $productId = $_POST['pid'];
            $price = $_POST['price'];
            $userEmail = $_POST['uemail'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $userName = $_POST['uname'];
            $paymentStatus = $_POST['paymentStatus'];
            $stmt->execute();
            echo "<script>alert('Order confirmed successfully!');</script>";

          }else{
            echo"failed to order".$_POST['productName'];
            if(isset($_POST['confirmOrder'])){
                echo"isst";
            }
          }
    ?>