<?php
$to = 'malodeganesh5@gmail.com';
$subject = 'Test Email';
$message = 'This is a test email';
$headers = 'From: uistudio397@gmail.com';

if (mail($to, $subject, $message, $headers)) {
    echo 'Email sent successfully';
} else {
    echo 'Email not sent';
}
?>
=============================================================
watchlist.php dt11/4/24
<?php 
session_start();
include 'db.php';
if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './Bootstrap/Bootstrap.php';?>
    <title>Sell Product</title>
</head>
<body>
<?php include 'navbarSecure.php';?>    
<h2 class="container font-monospace mt-3">Upload Product</h2>
<div class="container-fluid p-5" style="width:60% ;">
    <form action="uploadProduct.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Product Name</label>
            <input type="text" name="product_name" placeholder="Enter Product Name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="startBid" class="form-label">Starting Bid Price</label>
            <input type="number" name="sbid" id="startBid" class="form-control" placeholder="Example Rs.2000" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">End Date</label>
            <input type="datetime-local" name="end_date" class="form-control" id="date" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Image Upload</label>
            <input type="file" name="img" id="" accept="image/*" required>
        </div>
        
        <!-- ganeshmalode@gmail.com ->$userName -->            
            <input type="email" name="userEmail" value="<?php echo $userName;?>" hidden>
        
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
<hr>
<div class="container">
    <h2  class=" font-monospace">Manage Products Orders</h2>
    <div class="container">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Starting Bid Amount</th>
        <th>End Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
    //   $userEmail = $_SESSION['email'];
      $sql = "SELECT * FROM products WHERE userEmail =?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("s", $userName);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>". $row['id']. "</td>";
          echo "<td>". $row['product_name']. "</td>";
          echo "<td>". $row['starting_bid_price']. "</td>";
          echo "<td>". $row['end_date']. "</td>";
          $check = "select * from orders where id=".$row['id']." and payment_status='done'";
          $orderResult = $con->query($check);
          $r = $orderResult->fetch_assoc();
          if($orderResult->num_rows){
            echo "<td><button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#deliverModal".$row['id']."'>Deliver</button></td>";
        }else{
            echo "<td><button class='btn btn-warning btn-sm'>Pending</button></td>";
          }
          echo "</tr>";
           // Modal for Deliver Confirmation
           echo "<div class='modal fade' id='deliverModal".$row['id']."' tabindex='-1' aria-labelledby='deliverModalLabel".$row['id']."' aria-hidden='true'>";
           echo "<div class='modal-dialog'>";
           echo "<div class='modal-content'>";
           echo "<div class='modal-header'>";
           echo "<h5 class='modal-title' id='deliverModalLabel".$row['id']."'>Confirm Delivery</h5>";
           echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
           echo "</div>";
           echo "<div class='modal-body'>";
           echo "<p>Are you sure you want to deliver this product?</p>";
           echo "</div>";
           echo "<div class='modal-footer'>";
           echo "<form method='post'>";
           echo "<input type='hidden' name='deliverProductId' value='".$row['id']."'>";
           echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
           echo "<button type='submit' class='btn btn-primary'>Deliver</button>";
           echo "</form>";
           echo "</div>";
           echo "</div>";
           echo "</div>";
           echo "</div>";
        }
      } else {
        echo "<tr>";
        echo "<td colspan='4'>No products uploaded.</td>";
        echo "</tr>";
      }
     ?>
    </tbody>
  </table>
</div>
</div>
</body>
<div>
</html>
