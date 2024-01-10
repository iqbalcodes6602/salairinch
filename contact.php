<!DOCTYPE html>
<html lang="en">

<head>
<?php include('header.php'); ?>
</head>

<body>
    <!-- Start Breadcrumb 
    ============================================= -->
    <div class="banner-area banner-style-five auto-height bg-dark text-light text-multi-weight">
        <div class="shape-top-right" style="background-image: url(assets/img/shape/37.png);"></div>
        <div class="container  text-center shadow dark text-light ">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1 class="pb-5">Contact Us</h1>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Contact Area 
    ============================================= -->
    <div id="contact" class="contact-area default-padding">
        <div class="container">
            <div class="contact-content">
                <div class="row">
                    <div class="col-lg-4 info">
                        <div class="content text-center text-light">
                            <div class="thumb">
                                <img src="assets/img/illustration/4.png" alt="Thumb">
                            </div>
                            <ul>
                                <li>
                                    <i class="fal fa-map-marker-alt"></i>
                                    <p>
                                        <?= $address?>
                                    </p>
                                </li>
                                <li>
                                    <i class="fal fa-headphones-alt"></i>
                                    <p>
                                        <?= $mobile?>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 contact-form-box">
                        <div class="form-box">
                            <h2>Let's talk?</h2>
                            <p>
                                It's all about the humans behind a brand and those experiencing it, we're right there.
                                In the middle performance quick.
                            </p>
                            <form id="submitcontactus" class="contact-form">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control" id="name" name="name" placeholder="Name"
                                                type="text" required>
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input class="form-control" id="email" name="email" placeholder="Email (Optional)"
                                                type="email">
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input class="form-control" id="mobile" name="mobile" placeholder="Phone"
                                                type="text" required>
                                            <input class="form-control"  name="status"
                                                type="hidden" value='1'>
                                            <span class="alert-error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group comments">
                                            <textarea class="form-control" id="message" name="message"
                                                placeholder="Describe your desire service  *" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" >
                                            Send Message <i class="fa fa-paper-plane"></i>
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

    <!-- Star Google Maps
    ============================================= -->
    <!-- <div class="maps-area">
        <div class="container">
            <div class="google-maps">
                <div class="row">
                    <div class="col-lg-12">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d14767.262289338461!2d70.79414485000001!3d22.284975!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1424308883981"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Google Maps -->

    <!-- Footer  -->
    <?php include('footer.php'); ?>

</body>

</html>