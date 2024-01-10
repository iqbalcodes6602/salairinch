<?php
include('./ETWeb/includes/config.php');
session_start();

$category = mysqli_query($conn, "SELECT id as categoryid, title from category where status=1");
$categoryHTML = "";
$categoryOptions = "";
if (mysqli_num_rows($category) > 0) {
  while ($categoryData = mysqli_fetch_assoc($category)) {
    $categoryHTML .= '<li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> ' . $categoryData["title"] . ' </a>
                          <ul id="' . $categoryData['categoryid'] . '" class="dropdown-menu"></ul>
                        </li>';
    $categoryOptions .= '<option value="' . $categoryData["title"] . '">
                        ' . $categoryData["title"] . '
                      </option>';
  }
}
$subcategory = mysqli_query($conn, "SELECT id as subcategoryid, categoryid, title from subcategory where status=1");
$subcategoryHTML = "";
if (mysqli_num_rows($subcategory) > 0) {
  while ($subcategoryData = mysqli_fetch_assoc($subcategory)) {
    $subcategoryHTML .= '<script>
                            document.getElementById(' . $subcategoryData['categoryid'] . ').innerHTML += `<li><a href="servicedetail.php?subcategoryid=' . $subcategoryData['subcategoryid'] . '">' . $subcategoryData['title'] . '</a></li>`;
                          </script>';
  }
}

//section for getting adress,email,mobile
$setting = mysqli_query($conn, "SELECT id as settingid, slug, value from setting");

$address = "";
$mobile = "";
$email = "";

if (mysqli_num_rows($setting) > 0) {
  while ($settingData = mysqli_fetch_assoc($setting)) {
    if ($settingData["slug"] == "address") {
      $address = $settingData["value"];
    }
    if ($settingData["slug"] == "mobile") {
      $mobile = $settingData["value"];
    }
    if ($settingData["slug"] == "email") {
      $email = $settingData["value"];
    }
  }
}
?>

<!-- ========== Meta Tags ========== -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Cleanu - Cleaning Services ">

<!-- ========== Page Title ========== -->
<title>Salairinch</title>

<!-- ========== Favicon Icon ========== -->
<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

<!-- ========== Start Stylesheet ========== -->

<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
<link href="assets/css/themify-icons.css" rel="stylesheet" />
<link href="assets/css/elegant-icons.css" rel="stylesheet" />
<link href="assets/css/flaticon-set.css" rel="stylesheet" />
<link href="assets/css/magnific-popup.css" rel="stylesheet" />
<link href="assets/css/owl.carousel.min.css" rel="stylesheet" />
<link href="assets/css/owl.theme.default.min.css" rel="stylesheet" />
<link href="assets/css/animate.css" rel="stylesheet" />
<link href="assets/css/bootsnav.css" rel="stylesheet" />
<link href="style.css" rel="stylesheet">
<link href="assets/css/responsive.css" rel="stylesheet" />
<!-- ========== End Stylesheet ========== -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


<!-- Preloader Start -->
<div class="se-pre-con"></div>
<!-- Preloader Ends -->

<!-- Start Header Top 
    ============================================= -->
<div class="top-bar-area fixed text-light multi-content d-none">
  <div class="container">
    <div class="row align-center">
      <div class="col-lg-12 info item-flex space-between">
        <ul>
          <li>
            <i class="fas fa-clock"></i> Working Hours: 8:00 AM – 7:45 PM
          </li>
        </ul>
        <div class="social">
          <ul>
            <li>
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Header Top -->

<!-- Header 
    ============================================= -->
<header id="home">
  <div class="container box-nav">
    <div class="row">
      <!-- Start Navigation -->
      <nav class="navbar top-less navbar-default navbar-fixed dark bootsnav on no-full nav-box no-background bg-white">

        <!-- Start Top Search -->
        <div class="top-search ">
          <div class="container">
            <form method="get">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
              </div>
            </form>
          </div>
        </div>
        <!-- End Top Search -->

        <div class="container nav-container">
          <div class="row d-flex align-center">
            <!-- Start Header Navigation -->
            <div class="col-lg-2 d-flex justify-content-center">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                  <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.php">
                  <img src="assets/img/SalaiRinchLogo.png" class="logo" alt="Logo">
                </a>
              </div>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-lg-8">
              <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav" data-in="fadeInDown" data-out="fadeOutUp">
                  <li><a href="index.php" class="active">home</a></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle " data-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                      <?= $categoryHTML ?>
                      <?= $subcategoryHTML ?>
                    </ul>
                  </li>
                  <!-- <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects</a>
                      <ul class="dropdown-menu">
                        <li><a href="projects.php">Projects</a></li>
                        <li><a href="project-details.php">Project Details</a></li>
                      </ul>
                    </li> -->
                  <!-- <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Services</a>
                      <ul class="dropdown-menu">
                        <li><a href="services.php">Services Version One</a></li>
                        <li><a href="services-2.php">Services Version Two</a></li>
                        <li><a href="services-details.php">Services Details</a></li>
                      </ul>
                    </li> -->
                  <li><a href="contact.php">contact</a></li>
                  <li>
                      <?php
                      if (isset($_SESSION['type']) && isset($_SESSION['uid']) && $_SESSION['type'] = 'user' && $_SESSION['uid'] > 0) {
                        echo '<a id="logouthandler" href="#">Logout</a>';
                      }else{
                        echo '<a href="login.php">Login</a>';
                      }
                      ?>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.navbar-collapse -->

            <!-- Start Atribute Navigation -->
            <div class="col-lg-2 right-bar">
              <div class="attr-nav">
                <ul>
                  <li class="search"><a href="#"><i class="fas fa-search"></i></a></li>
                  <li class="side-menu">
                    <a href="#">
                      <span class="bar-1"></span>
                      <span class="bar-2"></span>
                      <span class="bar-3"></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- End Atribute Navigation -->
          </div>

        </div>

        <!-- Start Side Menu -->
        <div class="side">
          <a href="#" class="close-side"><i class="icon_close"></i></a>
          <div class="widget">
            <img src="assets/img/SalaiRinchLogo.png" alt="Logo">
            <p>
              At Salairinch, we understand that plumbing emergencies can happen at any time. That's why we offer 24/7 emergency service to help you when you need it most. Our team of licensed plumbers is always ready to provide prompt and reliable service, no matter the time of day or night. Contact us now for emergency plumbing services.
            </p>
          </div>
          <div class="widget address">
            <div>
              <ul>
                <li>
                  <div class="content">
                    <p>Address</p>
                    <strong><?= $address ?></strong>
                  </div>
                </li>
                <li>
                  <div class="content">
                    <p>Email</p>
                    <strong><?= $email ?></strong>
                  </div>
                </li>
                <li>
                  <div class="content">
                    <p>Contact</p>
                    <strong>+91 <?= $mobile ?></strong>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="widget newsletter d-none">
            <h4 class="title">Get Subscribed!</h4>
            <form action="#">
              <div class="input-group stylish-input-group">
                <input type="email" placeholder="Enter your e-mail" class="form-control" name="email">
                <span class="input-group-addon">
                  <button type="submit">
                    <i class="arrow_right"></i>
                  </button>
                </span>
              </div>
            </form>
          </div>
          <div class="widget social d-none">
            <ul class="link">
              <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
              <li><a href="#"><i class="fab fa-behance"></i></a></li>
            </ul>
          </div>
        </div>
        <!-- End Side Menu -->
      </nav>
      <!-- End Navigation -->
    </div>
  </div>
</header>
<!-- End Header -->