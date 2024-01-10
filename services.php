<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('header.php');

  include('./ETWeb/includes/config.php');

  if (isset($_GET['categoryid'])) {
    $categoryid = mysqli_real_escape_string($conn, $_GET['categoryid']);
    $sql = "SELECT * FROM subcategory where categoryid='$categoryid' and status=1";

    $subcategory = mysqli_query($conn, $sql);
    $subcategoryCards = "";
    if (mysqli_num_rows($subcategory) > 0) {
      while ($subcategoryData = mysqli_fetch_assoc($subcategory)) {
        $subcategoryCards .= '
      <!-- Single Item -->
      <div class="col-12 col-md-6 col-lg-4 ">
        <div class="services-style-four">
          <div class="thumb">
            <img src="assets/img/' . $subcategoryData['image'] . '" alt="services img">
            <i class="fas fa-sink"></i>
            <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
          </div>
          <div class="content ">
            <h4><a href="servicedetail.php?subcategoryid=' . $subcategoryData['id'] . '"> ' . $subcategoryData['title'] . ' </a></h4>
            <p>
              ' . $subcategoryData['description'] . '
            </p>
            <a class="btn-common" href="servicedetail.php?subcategoryid=' . $subcategoryData['id'] . '">View Details</a>
          </div>
        </div>
      </div>
      <!-- End Single Item -->
      ';
      };
    } else {
      header("Location: services.php");
      die();
    }
  } else {
    $sql = "SELECT * FROM category where status=1";

    $category = mysqli_query($conn, $sql);
    $categoryCards = "";
    if (mysqli_num_rows($category) > 0) {
      while ($categoryData = mysqli_fetch_assoc($category)) {
        $categoryCards .= '
      <!-- Single Item -->
      <div class="col-12 col-md-6 col-lg-4 ">
        <div class="services-style-four">
          <div class="thumb">
            <img src="assets/img/' . $categoryData['image'] . '" alt="services img">
            <i class="fas fa-sink"></i>
            <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
          </div>
          <div class="content ">
            <h4><a href="servicedetail.php?subcategoryid=' . $categoryData['id'] . '"> ' . $categoryData['title'] . ' </a></h4>
            <p>
              ' . $categoryData['description'] . '
            </p>
            <a class="btn-common" href="services.php?categoryid=' . $categoryData['id'] . '">View Details</a>
          </div>
        </div>
      </div>
      <!-- End Single Item -->
      ';
      };
    } else {
      header("Location: services.php");
      die();
    }
  }




  ?>
</head>

<body>


  <!-- Start Breadcrumb 
    ============================================= -->
  <div class="banner-area banner-style-five auto-height bg-dark text-light text-multi-weight">
    <div class="shape-top-right" style="background-image: url(assets/img/shape/37.png);"></div>
    <div class="container  text-center shadow dark text-light ">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <h1 class="pb-5">All Services</h1>
        </div>
      </div>
    </div>
  </div>


  <!-- Start Services 
    ============================================= -->
  <div class="container">
    <div class="row py-5 gap-5">

      <?php
      if (isset($_GET['categoryid'])) {
        echo $subcategoryCards;
      } else {
        echo $categoryCards;
      }
      ?>

    </div>
  </div>
  <!-- End Services-->

  <!-- Start Process Area
    ============================================= -->
  <div class="work-process-area text-center default-padding-bottom">
    <!-- Shape -->
    <div class="shape">
      <img src="assets/img/shape/13.png" alt="Shape">
    </div>
    <!-- End Shape -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>Work Process</h4>
            <h2>How it Works</h2>
            <div class="devider"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="process-items">
        <div class="row">
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
              <img src="assets/img/services/12.jpg" alt="Thumb">
                <span>01</span>
              </div>
              <h5>Book Online Form</h5>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/services/14.jpg" alt="Thumb">
                <span>02</span>
              </div>
              <h5>Get expert cleaner</h5>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/services/13.jpg" alt="Thumb">
                <span>03</span>
              </div>
              <h5>Relax & enjoy cleaning</h5>
            </div>
          </div>
          <!-- End Single Item -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Process Area -->


  <!-- Footer  -->
  <?php include('footer.php'); ?>

</body>

</html>