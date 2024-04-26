<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $user_email = $_POST['userEmail'];
    $bid_amount = $_POST['bidPrice'];

    // Check the starting bid price of the product
    $starting_bid_sql = "SELECT starting_bid_price FROM products WHERE id = ?";
    $stmt = $con->prepare($starting_bid_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $starting_bid_result = $stmt->get_result();
    $starting_bid_row = $starting_bid_result->fetch_assoc();
    $starting_bid_price = $starting_bid_row['starting_bid_price'];

    // Check the last bid amount
    $last_bid_sql = "SELECT bid_amount FROM bids WHERE product_id = ? ORDER BY bid_time DESC LIMIT 1";
    $stmt = $con->prepare($last_bid_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $last_bid_result = $stmt->get_result();
    $last_bid_row = $last_bid_result->fetch_assoc();
    $last_bid_amount = $last_bid_row ? $last_bid_row['bid_amount'] : $starting_bid_price;

    if ($bid_amount >= $starting_bid_price && $bid_amount > $last_bid_amount) {
        // Insert the bid into the database
        $insert_sql = "INSERT INTO bids (product_id, user_email, bid_amount, bid_time) 
                       VALUES (?, ?, ?, NOW())";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("isd", $product_id, $user_email, $bid_amount);
        if ($stmt->execute()) {
            header("Location: userDashboard.php?msg=bidPlaced");
            exit();
        } else {
            header("Location: userDashboard.php?msg=errorBid");
            exit();
        }
    } else {
        session_start();
        $_SESSION['error_message'] = "Your bid must be higher than or equal to the starting bid price and the current highest bid";
        header("Location: userDashboard.php?msg=bidNotPlaced");
        exit();
    }
}

$con->close();
?>
