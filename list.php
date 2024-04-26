<?php 
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}
?>

    
<h2 class="mb-4">List of Products</h2>
<div class="row">
<?php
include 'db.php';
$currentDateTime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM products WHERE end_date >= '$currentDateTime'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
    <div class="col-md-4 mb-4 p-5">
        <div class="card">
            <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                <p class="card-text">Starting Bid Price: <?php echo $row['starting_bid_price']; ?></p>
                <p class="card-text">End Date: <?php echo date('F j, Y, g:i a', strtotime($row['end_date'])); ?></p>
                <div class="rounded-5 bg-secondary  text-center " style="font-weight: bold;"  id="countdown<?php echo $row['id']; ?>" class="countdown "></div>
                <br>
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#bidModal<?php echo $row['id']; ?>">Bid Now / See More</button>
            </div>
        </div>
    </div>

    <!-- Bid Now Modal -->
    <div class="modal fade" id="bidModal<?php echo $row['id']; ?>" tabindex="-1"
        aria-labelledby="bidModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bidModalLabel<?php echo $row['id']; ?>">Place Your Bid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-2" id="bidModalBody<?php echo $row['id']; ?>">
                    <?php
                    $productId = $row['id'];
                    $bidSql = "SELECT * FROM bids WHERE product_id = $productId";
                    $bidResult = $con->query($bidSql);
                    if ($bidResult->num_rows > 0) {
                        while ($bidRow = $bidResult->fetch_assoc()) {
                            $userName = $con->query("select name from users where email='$bidRow[user_email]'")->fetch_assoc();
                            
                            echo "<p>User: " . $userName['name'] . ", <b>Bid Amount: Rs." . $bidRow['bid_amount'] . "</b>, Bid Time: " . $bidRow['bid_time'] . "</p>";
                        }
                    } else {
                        echo "No bids found for this product.";
                    }
                    ?>
                </div>
                <hr>
                <div class="modal-body">
                    <form action="placeBid.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="userEmail" value="<?php echo $_SESSION['email']; ?>">
                        <div class="mb-3">
                            <label for="bidPrice" class="form-label">Your Bid Price:</label>
                            <input type="number" class="form-control" id="bidPrice" name="bidPrice" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Place Bid</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
         // Refresh bid now modal content every 5 seconds
         setInterval(function() {
                    var modalBody = document.getElementById('bidModalBody<?php echo $row['id']; ?>');
                    var productId = <?php echo $row['id']; ?>;
                    fetch('refreshBids.php?productId=' + productId)
                        .then(response => response.text())
                        .then(data => {
                            modalBody.innerHTML = data;
                        });
                }, 5000); // Refresh every 5 seconds



        // Set the date we're counting down to
        var countDownDate<?php echo $row['id']; ?> = new Date("<?php echo $row['end_date']; ?>").getTime();

        // Update the countdown every 1 second
        var x<?php echo $row['id']; ?> = setInterval(function() {
            // Get the current date and time
            var now = new Date().getTime();
            // Calculate the distance between now and the count down date
            var distance = countDownDate<?php echo $row['id']; ?> - now;
            // Calculate days, hours, minutes, and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Display the countdown
            document.getElementById("countdown<?php echo $row['id']; ?>").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";
            // If the countdown is over, display text
            if (distance < 0) {
                clearInterval(x<?php echo $row['id']; ?>);
                document.getElementById("countdown<?php echo $row['id']; ?>").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

<?php
    }
} else {
    echo "No products found";
}
$con->close();
?>

