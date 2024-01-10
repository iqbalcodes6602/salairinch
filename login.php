<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('header.php');
  if (isset($_SESSION['type']) && isset($_SESSION['uid']) && $_SESSION['type'] = 'user' && $_SESSION['uid'] > 0) {
    if (isset($_SESSION['subcategoryid'])) {
      header("Location: servicedetail.php?subcategoryid=" . $_SESSION['subcategoryid']);
      $_SESSION['subcategoryid'] = '';
    } else {
      header("Location: index.php");
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
          <h1 class="pb-5">Login</h1>
        </div>
      </div>
    </div>
  </div>


  <!-- Start Contact Area 
    ============================================= -->
  <div id="contact" class="contact-area default-padding">
    <div class="container">
      <div class="contact-content">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center">
          <div class="col-lg-6 info">
            <div class="content text-center text-light">
              <div class="thumb">
                <img src="assets/img/login.png" alt="Login">
              </div>
            </div>
          </div>
          <div class="col-lg-6 contact-form-box">
            <div class="form-box">
              <h2>Login Here</h2>
              <p>
                Get Discovered by Top service , find experts ...
              </p>
              <form id="otpregistration" method="POST" class="contact-form">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <input class="form-control" id="mobile" name="mobile" placeholder="Mobile no" type="text" required>
                      <input value="1" class="form-control" id="status" name="status" placeholder="Status" type="hidden" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <button type="submit" name="submit" id="submit">
                      Send Otp <i class="fa fa-paper-plane"></i>
                    </button>
                  </div>
                </div>
              </form>
              <form style="display:none" id="otpverification" method="POST" class="contact-form">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <input class="form-control" id="mobile" name="mobile" placeholder="Mobile no" type="text" required readonly><br />
                      <input class="form-control" id="otp" name="otp" placeholder="Enter OTP sent to your mobile number" type="text" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <button type="submit" name="submit" id="submit">
                      Send Otp <i class="fa fa-paper-plane"></i>
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
  <!-- End Contact Area -->



  <!-- Footer  -->
  <?php include('footer.php'); ?>

</body>

</html>