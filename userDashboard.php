<?php
session_start();
include 'db.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include './Bootstrap/Bootstrap.php';?>
    <title>Dashboard</title>

</head>

<body>

    <?php include 'navbarSecure.php';?>
    <div class="p-3">
        <?php 
    if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your product listed successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    if (isset($_GET['msg']) && $_GET['msg'] == 'failed') {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Failed to upload.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    // BidPlaced
    if (isset($_GET['msg']) && $_GET['msg'] == 'bidPlaced') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your bid  has been placed successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    // errorBid
    if(isset($_GET['msg']) && $_GET['msg'] == 'errorBid'){
        echo "<script> alert(<?php echo'Error placing your bid! Please try again later.' ?>);</script>";
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error placing your bid! Please try again later
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        // Check if there is an error message
        if (isset($_SESSION['error_message'])) {
        $error_message = $_SESSION['error_message'];
        echo "<div class='alert alert-danger'>$error_message</div>";
        unset($_SESSION['error_message']); // Clear the session variable
        }
        ?>
        <!--  -->
        <?php include 'list.php';?>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>