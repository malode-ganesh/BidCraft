<?php
include 'db.php'; // Include the database connection file

// Check if the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Retrieve user information from the session
$userEmail = $_SESSION['email'];

// Retrieve product information from the database based on the product ID
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['pid'];
    $productSql = "SELECT * FROM products WHERE id = ?";
    $stmt = $con->prepare($productSql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $productResult = $stmt->get_result();
    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
    } else {
        die('Product not found');
    }
} else {
    die('Invalid request');
}

// Retrieve user information from the database based on the user email
$userSql = "SELECT * FROM users WHERE email = ?";
$stmt = $con->prepare($userSql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$userResult = $stmt->get_result();
if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
} else {
    die('User not found');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <?php include './Bootstrap/Bootstrap.php';?>
</head>
<body>
    <div class="container">
        <h2>Invoice / Receipt</h2>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h4>User Information</h4>
                <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Mobile Number:</strong> <?php echo $user['contact']; ?></p>
                <p><strong>Address:</strong> <?php echo $_POST['address'];?></p>
            </div>
            <div class="col-md-6">
                <h4>Product Information</h4>
                <p><strong>Product Name:</strong> <?php echo $product['product_name']; ?></p>
                <p><strong>Product ID:</strong> <?php echo $product['id']; ?></p>
                <p><strong>Price:</strong> <?php echo $_POST['price']; ?></p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <h4>Payment Details</h4>
                <p><strong>Payment Mode:</strong> <?php echo isset($_POST['payment_mode']) ? $_POST['payment_mode'] : ''; ?></p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <form action="watchlist.php" method="POST" name="confirmOrder">
                    <input name="productName" value="<?php echo $product['product_name'];?>" hidden>
                    <input name="pid" value="<?php echo $product['id'];?>" hidden>
                    <input name="price" value="<?php echo $_POST['price'];?>" hidden>
                    <input name="uemail" value="<?php echo $user['email'];?>" hidden>
                    <input name="contact" value="<?php echo $user['contact'];?>" hidden>
                    <input name="address" value="<?php echo $_POST['address'];?>" hidden>
                    <input name="uname" value="<?php echo $user['name'];?>" hidden>
                    <input name="paymentStatus" value="done" hidden>
                    <input class="btn btn-primary" type="submit"  value="Confirm">
                    <button class="btn btn-success" onclick="window.print()">Print Reciept</button>
                </form>
            </div>
        </div>
    </div>
   <script>
    function downloadPDF() {
  var link = document.createElement('a');
  link.href = 'data:application/pdf;base64,' + btoa(document.documentElement.outerHTML);
  link.download = 'invoice.pdf';
  link.click();
}
   </script>
</body>
</html>
