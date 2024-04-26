<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BidCraft | Home</title>
    <style>
    .main {
        /* background-image: url("./images/auct1.jpg");
        background-repeat: no-repeat;
        background-size:cover;
        background-attachment: fixed; */
        background-color: #f0f0f0;
    }
    .slide{
        align: center;
        border:1px solid #ccc;
      
    }
    </style>
    <?php include './Bootstrap/Bootstrap.php';?>
</head>

<body>
    <?php include 'navbar.php';?>
    <div class="slide" align="center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/auct1.jpg" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/auct3.png" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/auct2.jpg" class="d-block img-fluid" alt="...">
                </div>
            </div>
        </div>
    </div>
    <!-- <a href="login.php">Login</a> -->
    <br>
    <section class="hero">
    <div class="container text-center">
      <h1 class="font-monospace">Welcome to BidCraft</h1>
      <p>Your destination for exciting auctions!</p>
      <a href="login.php" class="btn btn-primary">Get Started</a>
    </div>
  </section>
  <br><br><BR><Br>
  <?php include 'footer.php'; ?>
</body>

</html>