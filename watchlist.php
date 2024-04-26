<?php
include 'db.php'; // Include the database connection file

// Check if the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Your SQL query
$userEmail = $_SESSION['email'];
$userBidsSql = "SELECT b.id, p.product_name, b.bid_amount, b.bid_time, MAX(b2.bid_amount) AS highest_bid, p.end_date
                FROM bids b
                JOIN products p ON b.product_id = p.id
                JOIN bids b2 ON b.product_id = b2.product_id
                WHERE b.user_email = ?
                GROUP BY b.id";
$stmt = $con->prepare($userBidsSql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$userBidsResult = $stmt->get_result();

if ($userBidsResult === false) {
    die('Error executing query: ' . $con->error);
}


// Use the result set in your HTML table
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist</title>
    <!-- Include Bootstrap CSS -->
    <?php include './Bootstrap/Bootstrap.php';?>
</head>

<body>
    <?php include 'navbarSecure.php';?>
    <div class="container">
        <h2>Your Bids</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Your Bid Amount</th>
                    <th>Highest Bid</th>
                    <th>Bid Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $userBidsResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['bid_amount']; ?></td>
                    <td><?php echo $row['highest_bid']; ?></td>
                    <td><?php echo $row['bid_time']; ?></td>

                    <td>
                        <?php
                            // Display the auction status
                            $now = new DateTime();
                            $end_date = new DateTime($row['end_date']);
                            if ($now < $end_date) {
                                echo "In Progress";
                            } else {
                                if ($row['highest_bid'] == $row['bid_amount']) {
                                    echo "Won";
                                    if($end_date <= $now){
                                        ?>
            <!-- Checking in orders table is payment done -->
            <?php
$query = "SELECT id, payment_status FROM orders WHERE product_id = ".$row['id'];
 $stmt = $con->query($query);
$rs = $stmt->fetch_assoc();

if ($rs !== null && $rs['payment_status']=='done') {
    echo '<button type="button" class="btn btn-sm btn-success">Ordered</button>';
} else {
    echo '<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal' . $row['id'] . '">Checkout</button>';
}
            ?>
                
                        <!-- Checkout Modal -->
                        <div class="modal fade" id="checkoutModal<?php echo $row['id']; ?>" tabindex="-1"
                            aria-labelledby="checkoutModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="checkout.php" method="post">
                                            <!-- hidden fields -->
                                            <input type="number" hidden name="price"
                                                value="<?php echo $row['highest_bid'];?>">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address"
                                                    required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payment_method" class="form-label">Payment Method</label>
                                                <select name="payment_mode" class="form-control">
                                                    <option value="cash">Cash</option>
                                                    <option value="card" disabled>Card</option>
                                                    <option value="online" disabled>Online</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="user" value="<?php echo $userEmail; ?>">
                                            <input type="hidden" name="pid" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-primary"
                                                onclick="confirmPay()">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                                    }
                                } else {
                                    echo "Lost";
                                }
                            }
                            ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- Inserting order record if checkout.php request confirmOrder -->
    <?php 
        // Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productName']) && isset($_POST['pid']) && isset($_POST['price']) && isset($_POST['uemail']) && isset($_POST['contact']) && isset($_POST['address']) && isset($_POST['uname']) && isset($_POST['paymentStatus'])) {
    // Assign form data to variables
    $productName = $_POST['productName'];
    $productId = $_POST['pid'];
    $price = $_POST['price'];
    $userEmail = $_POST['uemail'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $userName = $_POST['uname'];
    $paymentStatus = $_POST['paymentStatus'];

    // Prepare and execute the query to insert data into the orders table
    $stmt = $con->prepare("INSERT INTO orders (product_name, product_id, price, user_email, user_contact, user_address, user_name, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssss", $productName, $productId, $price, $userEmail, $contact, $address, $userName, $paymentStatus);
    $stmt->execute();
    $stmt->close();

    // Display a success message
    echo "<script>alert('Order confirmed successfully!');</script>";
} else {
    // Display an error message
    echo "<script>alert('Error: Unable to confirm order.');</script>";
}
?>
    ?>
    <script>
    function confirmPay() {
        if (confirm("Are you sure?")) {
            // User clicked "OK"
            alert("Procced further!");
        } else {
            // User clicked "Cancel" or closed the dialog
            alert("Canceled!");
        }
    }
    </script>
</body>

</html>

<?php
$con->close();
?>