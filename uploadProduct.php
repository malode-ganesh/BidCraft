<?php
include 'db.php';
// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $starting_bid_price = $_POST['sbid'];
    $end_date = $_POST['end_date'];
    $userEmail = $_POST['userEmail'];

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

    // Insert data into the database
    $sql = "INSERT INTO products (product_name, starting_bid_price, end_date, image_path,userEmail)
    VALUES ('$product_name', '$starting_bid_price', '$end_date', '$target_file','$userEmail')";

    if ($con->query($sql) === TRUE) {
        // echo "Product uploaded successfully";
        header("Location: userDashboard.php?msg=success");
    } else {
        // $_SESSION['error_message'] = "Error uploading product: " . $con->error;
        header("Location: userDashboard.php?msg=failed");
    }
}

$con->close();
?>