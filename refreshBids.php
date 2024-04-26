<?php
include 'db.php';

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Query the database for the latest bids for the product
    $bidSql = "SELECT * FROM bids WHERE product_id = $productId";
    $bidResult = $con->query($bidSql);

    if ($bidResult->num_rows > 0) {
        while ($bidRow = $bidResult->fetch_assoc()) {
            $userName = $con->query("select name from users where email='$bidRow[user_email]'");
            $userName = $userName->fetch_assoc();
            echo "<p>User: " . $userName['name'] . ", <b>Bid Amount: Rs." . $bidRow['bid_amount'] . "</b>, Bid Time: " . $bidRow['bid_time'] . "</p>";
        }
    } else {
        echo "No bids found for this product.";
    }
} else {
    echo "Product ID not provided.";
}

$con->close();
?>
