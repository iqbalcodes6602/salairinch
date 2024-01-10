<?php
include('./ETWeb/includes/config.php');
$category = mysqli_query($conn, "SELECT id as categoryid, title from category where status=1 limit 5");
$categoryFooter = "";
if (mysqli_num_rows($category) > 0) {
  while ($categoryData = mysqli_fetch_assoc($category)) {
    $categoryFooter .= '<li>
                          <a href="services.php?categoryid=' . $categoryData['categoryid'] . '"><i class="fas fa-angle-right"></i>' . $categoryData["title"] . '</a>
                        </li>';
  }
}

//section for getting adress,email,mobile
$setting = mysqli_query($conn, "SELECT id as settingid, slug, value from setting where status=1");

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
<!-- Start Footer 
    ============================================= -->
<footer class="bg-theme text-light">
  <!-- illustration -->
  <div class="animate-illustration">
    <img src="assets/img/illustration/2.png" alt="illustration">
  </div>
  <!-- End illustration -->
  <div class="container">
    <div class="f-items default-padding">
      <div class="row">
        <div class="col-lg-4 col-md-6 item">
          <div class="f-item about">
            <br />
            <p>
              Choose Salairinch for expert and excellency in plumbing solutions. We offer 24/7 emergency service and are committed to exceeding your expectations.
            </p>
            <form action="#" class="d-none">
              <input type="email" placeholder="Your Email" class="form-control" name="email">
              <button type="submit"> <i class="arrow_right"></i></button>
            </form>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 item">
          <div class="f-item link">
            <h4 class="widget-title">Quick Links</h4>
            <ul>
              <li>
                <a href="index.php"><i class="fas fa-angle-right"></i> Home</a>
              </li>
              <li class="d-none">
                <a href="contact.php"><i class="fas fa-angle-right"></i> About us</a>
              </li>
              <li>
                <a href="contact.php"><i class="fas fa-angle-right"></i> Contact us</a>
              </li>
              <li>
                <a href="services.php"><i class="fas fa-angle-right"></i> Services</a>
              </li>
              <li>
                <a href="login.php"><i class="fas fa-angle-right"></i> Login</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 item">
          <div class="f-item link">
            <h4 class="widget-title">Services</h4>
            <ul>
              <?= $categoryFooter ?>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 item">
          <div class="f-item contact-widget">
            <h4 class="widget-title">Contact Info</h4>
            <div class="address">
              <ul>
                <li>
                  <?= $address ?>
                </li>
                <li>
                  <div class="icon">
                    <i class="fas fa-clock"></i>
                  </div>
                  <div class="content">
                    <strong>Opening Hours:</strong>
                    8:00 AM – 7:45 PM
                  </div>
                </li>
                <li>
                  <div class="icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="content">
                    <strong>Phone:</strong>
                    <a href="tel:2151234567">+91 <?= $mobile ?></a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Start Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <div class="footer-bottom-box">
        <div class="row">
          <div class="col-lg-12 text-center">
            <p>&copy; Copyright 2023. All Rights Reserved by <a href="https://etechmy.com/">ETECHMY </a></p>
          </div>
          <div class="col-lg-6 text-right link d-none">
            <ul>
              <li>
                <a href="#">Terms</a>
              </li>
              <li>
                <a href="#">Privacy</a>
              </li>
              <li>
                <a href="#">Support</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Footer Bottom -->
  <!-- Fixed Shape -->
  <div class="fixed-shape-left">
    <img src="assets/img/shape/5.png" alt="Shape">
  </div>
  <!-- End Fixed Shape -->
</footer>
<!-- End Footer -->

<!-- jQuery Frameworks
    ============================================= -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.appear.js"></script>
<script src="assets/js/jquery.easing.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/modernizr.custom.13711.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/progress-bar.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/count-to.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/YTPlayer.min.js"></script>
<script src="assets/js/jquery.event.move.js"></script>
<script src="assets/js/jquery.twentytwenty.js"></script>
<script src="assets/js/bootsnav.js"></script>
<script src="assets/js/main.js"></script>


<!-- Scripts  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="./vendor/rajvaibhavjain/etlib/js/SweetAlert.js"></script>
<script src="./assets/js/function.js"></script>