<?php

//   $userName = $_SESSION['email'];
//   $query ="SELECT * FROM users WHERE email='$userName'";
//   $result=mysqli_query($con,$query);
//   $row = mysqli_fetch_assoc($result);
//   $name = $row['name'];
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

                <ul class="nav nav-pills " id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                            aria-controls="pills-contact" aria-selected="false">bids</a>
                    </li>
                </ul>
                <!-- Authentication Links -->
            </ul>
            <a href="#" class="text-white" style="font-size:1.4em;"><span class="fa fa-user">
                    Admin&nbsp;</a>
            <!-- <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Serach" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
            &nbsp;
            <a class="btn btn-danger" href="logoutAdmin.php"> Logout</a>
        </div>
    </div>
</nav>