<?php
session_start();
include 'db.php';

if (isset($_POST['adminLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    // Validate email and password
    if ($email == 'admin.bidcraft@gmail.com' && $password == 'admin') {
        $_SESSION['admin'] = true;
        header("Location: adminDashboard.php");
        exit;
    } else {
        // Display error message or handle incorrect credentials
        echo "Invalid email or password.";
    }
}

// Fetch users data from the database
$sql = "SELECT * FROM users";
$result = $con->query($sql);

// Fetch products data from the database
$sql_products = "SELECT * FROM products";
$result_products = $con->query($sql_products);

// Fetch bids data from the database
$sql_bids = "SELECT * FROM bids";
$result_bids = $con->query($sql_bids);

// Check if form is submitted for deleting a product
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql_delete = "DELETE FROM products WHERE id='$id'";
    if($con->query($sql_delete)){
        echo "<script>alert('Product deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete product');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include './Bootstrap/Bootstrap.php';?>
</head>
<body>
    <?php include './adminSecureNav.php'; ?>
    <br>    

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="container mt-3">
                <h2>Users</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['contact'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No users found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="container mt-3">
                <h2>Products</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Starting Bid Price</th>
                            <th>End Date</th>
                            <th>User Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_products->num_rows > 0) {
                            while ($row = $result_products->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "<td>" . $row['starting_bid_price'] . "</td>";
                                echo "<td>" . $row['end_date'] . "</td>";
                                echo "<td>" . $row['userEmail'] . "</td>";
                                echo "<td>";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn btn-danger' name='delete'>Delete</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No products found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <div class="container mt-3">
                <h2>Bids</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>User Email</th>
                            <th>Bid Amount</th>
                            <th>Bid Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_bids->num_rows > 0) {
                            while ($row = $result_bids->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['product_id'] . "</td>";
                                echo "<td>" . $row['user_email'] . "</td>";
                                echo "<td>" . $row['bid_amount'] . "</td>";
                                echo "<td>" . $row['bid_time'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No bids found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
