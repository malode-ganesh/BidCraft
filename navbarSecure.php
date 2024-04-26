<?php

  $userName = $_SESSION['email'];
  $query ="SELECT * FROM users WHERE email='$userName'";
  $result=mysqli_query($con,$query);
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
?>

<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.php">
            <img src="./images/logo.png" alt="BidCraft" width="170px">
        </a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 " id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="userDashboard.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                 <a href="product.php" class="nav-link">Sell </a>
                </li>
                <li class="nav-item" >
                <a href="watchlist.php" class="nav-link">Watchlist</a>
                </li>
                
            </ul>
            <a href="#" class="text-white" style="font-size:1.4em;"><span class="fa fa-user">
                    <?php echo "$name";?>&nbsp;</a>
            <form class="d-flex">

                <input class="form-control me-2" type="search" placeholder="Serach" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            &nbsp;
            <a class="btn btn-danger" href="logout.php"> Logout</a>
        </div>
    </div>
</nav>