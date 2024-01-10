<!DOCTYPE html>
<html lang="en">
<?php
include('header.php');
if (!isset($_SESSION['type']) || !isset($_SESSION['uid']) || $_SESSION['type'] != 'user' || $_SESSION['uid'] < 0) {
  $_SESSION['subcategoryid'] = $_GET['subcategoryid'];
  header("Location: login.php");
}
?>

<head>
  <?php

  include('./ETWeb/includes/config.php');

  if (isset($_GET['subcategoryid'])) {
    $subcategoryid = mysqli_real_escape_string($conn, $_GET['subcategoryid']);

    $sql = "SELECT * FROM subcategory where id='$subcategoryid'";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
      $title = $row["title"];
      $description = $row["description"];
      $image = $row["image"];
    } else {
      header("Location: services.php");
      die();
    }
  } else {
    header("Location: services.php");
    die();
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
          <h1 class="pb-5"><?= $title ?></h1>
        </div>
      </div>
    </div>
  </div>
  <!-- End Breadcrumb -->

  <!-- Star Project Details Area
  ============================================= -->
  <div class="project-details-area default-padding py-5">
    <div class="container">
      <div class="project-details-items">
        <div class="thumb text-center">
          <?php if ($image != "") : ?>
            <img src="assets/img/<?= $image ?>" alt="Thumb">
          <?php endif; ?>
        </div>
        <div class="top-info">
          <div class="row">
            <div class="col-lg-7 left-info">
              <p>
                <?= $description ?>
              </p>
            </div>
            <div class="col-lg-5 right-info">
              <div class="project-info">
                <h4>Book a Schedule For <?= $title ?></h4>
                <ul>
                  <li>
                    Date <span><?= date('d/m/Y') ?></span>
                  </li>
                  <li>
                    Category <span>Technology</span>
                  </li>
                </ul>
                <!-- Booking modal -->
                <!-- <button type="button" class="btn btn-primary mt-3 ms-3" data-bs-toggle="modal"
                  data-bs-target="#exampleModal">
                  Book a Schedule
                </button> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Book a Schedule
                </button>
                <!-- Modal Body -->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Book a Schedule For <?= $title ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Booking Form  -->
                        <form id="setorder" action='#' class="contact-form">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <input type="hidden" name='subcategory' value="<?= $title?>">
                                <label>Name</label>
                                <input class="form-control" required name="name" placeholder="Name" type="text">
                                <span class="alert-error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" placeholder="Email (Optional)" type="email">
                                <span class="alert-error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>Mobile</label>
                                <input class="form-control" required name="mobile" placeholder="Phone" value="<?= $_SESSION['mobile']?>" type="text">
                                <span class="alert-error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" placeholder="Address" required></textarea>
                                <span class="alert-error"></span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                              <button class="btn btn-primary w-100 py-2" type="submit">
                                <span>Book Now <i class="fas fa-angle-right"></i></span>
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="main-content">

          <p>
            Give lady of they such they sure it. Me contained explained my education. Vulgar as hearts by garret.
            Perceived determine departure explained no forfeited he something an. Contrasted dissimilar get joy you
            instrument out reasonably. Again keeps at no meant stuff. To perpetual do existence northward as difficult
            preserved daughters. Continued at up to zealously necessary breakfast. Surrounded sir motionless she end
            literature. Gay direction neglected but supported yet her. Facilisis inceptos nec, potenti nostra aenean
            lacinia varius semper ant nullam nulla primis placerat facilisis. Netus lorem rutrum arcu dignissim at sit
            morbi phasellus nascetur eget urna potenti cum vestibulum cras. Tempor nonummy metus lobortis. Sociis velit
            etiam, dapibus. Lectus vehicula pellentesque cras posuere tempor facilisi habitant lectus rutrum pede
            quisque hendrerit parturient posuere mauris ad elementum fringilla facilisi volutpat fusce pharetra felis
            sapien varius quisque class convallis praesent est sollicitudin donec nulla venenatis, cursus fermentum
            netus posuere sociis porta risus habitant malesuada nulla habitasse hymenaeos. Viverra curabitur nisi vel
            sollicitudin dictum natoque ante aenean elementum curae malesuada ullamcorper. vivamus nonummy nisl posuere
            rutrum
          </p>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <img src="assets/img/800x600.png" alt="Thumb">
            </div>
            <div class="col-lg-6 col-md-6">
              <img src="assets/img/800x600.png" alt="Thumb">
            </div>
          </div>
        </div> -->

      </div>
    </div>
  </div>
  <!-- End Project Details Area -->

  <!--Booking Modal Start-->



  <!-- Footer  -->
  <?php include('footer.php'); ?>

</body>

</html>