<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('header.php'); ?>
</head>

<body>



  <!-- Start Banner 
    ============================================= -->
  <div class="banner-area banner-style-five auto-height bg-dark text-light text-multi-weight">
    <div class="shape-top-right" style="background-image: url(assets/img/shape/37.png);"></div>
    <div class="banner-items">
      <div class="container">
        <div class="row align-center">
          <div class="col-lg-6">
            <div class="content">
              <h4 class="wow slideInLeft">Highly Trained Staff</h4>
              <h2 class="wow slideInRight">Alwasy ready <span> to solve plumbing</span></h2>
              <p class="wow fadeInUp" data-wow-delay="500ms">
                Salairinch is your trusted source for expert plumbing solutions. Our licensed plumbers offer fast, reliable service for all your plumbing needs. Contact us today for affordable and effective solutions.
              </p>
              <!-- <a class="btn btn-light primary effect btn-md wow fadeInDown" data-wow-delay="900ms" href="#">Book a
                Schedule</a> -->
            </div>
          </div>
          <div class="col-lg-6">
            <div class="thumb wow fadeInUp">
              <img src="assets/img/illustration/1.png" alt="Thumb">
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- End Banner -->

  <!-- Start About 
    ============================================= -->
  <div class="about-style-four-area default-padding-bottom">
    <div class="container">
      <div class="row">

        <div class="col-lg-5">
          <div class="about-style-four">
            <div class="form">
              <div class="appinment-forms standard">
                <div class="top-heading">
                  <h2>Book Online</h2>
                  <p>
                    Online Booking For Appointments.
                  </p>
                </div>
                <form id="submitbooking" action='#' class="contact-form">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <input class="form-control" required name="name" placeholder="Name" type="text">
                        <span class="alert-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <input class="form-control" name="email" placeholder="Email (Optional)" type="email">
                        <input class="form-control" name="status" type="hidden" value='1'>
                        <span class="alert-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <input class="form-control" required name="mobile" placeholder="Phone" type="text" value="<?php if(isset($_SESSION['mobile'])) echo $_SESSION['mobile'] ?>">
                        <span class="alert-error"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <select required name='subject'>
                          <?= $categoryOptions ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <button class="" type="submit">
                        <span>Book Now <i class="fas fa-angle-right"></i></span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="about-style-four">
            <div class="about-list-item">
              <div class="services-list">
                <h4>What's Included</h4>
                <ul>
                  <li>Certifiled Materials</li>
                  <li>Professional Staff</li>
                  <li>Reasonable Rates</li>
                  <li>Latest Technology</li>
                  <li>Modern Astique Furniture </li>
                  <li>Instant Solution</li>
                  <li>Job Order Contracting</li>
                </ul>
              </div>
              <div class="info">
                <h2>We have over 25 years experience in Plumbing Service</h2>
                <p>
                  At Salairinch, we understand that plumbing emergencies can happen at any time. That's why we offer 24/7 emergency service to help you when you need it most. Our team of licensed plumbers is always ready to provide prompt and reliable service, no matter the time of day or night. Contact us now for emergency plumbing services.
                </p>
                <div class="call-us">
                  <div class="icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="content">
                    <h5>Call for Service</h5>
                    <span>+91 <?= $mobile ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- End About Area -->

  <!-- Start Process
    ============================================= -->
  <div class="process-style-four-area text-center default-padding-bottom">
    <div class="container">
      <div class="process-style-four-box">
        <div class="shape" style="background-image: url(assets/img/shape/38.png);"></div>
        <div class="row">
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="process-style-four">
              <div class="content">
                <i class="fas fa-calendar-alt"></i>
                <h3>Book Online</h3>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="process-style-four">
              <div class="content">
                <i class="fas fa-house-leave"></i>
                <h3>We Arrive</h3>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="process-style-four">
              <div class="content">
                <i class="fad fa-shower"></i>
                <h3>Solve Problem</h3>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Process -->

  <!-- Start Services Area 
    ============================================= -->
  <div class="services-style-four-area default-padding bg-gray">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>What we do</h4>
            <h2>Our Most Popular <br> Plumbing Services For You</h2>
            <div class="devider"></div>
            <p>
              At Salairinch, we specialize in a range of plumbing services to meet all your needs. Our most popular services include installations, repairs, and maintenance for residential and commercial properties. With our licensed plumbers and competitive pricing, you can trust us for all your plumbing needs.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="services-style-four-carousel owl-carousel owl-theme">
            <!-- Single Item -->
            <div class="services-style-four">
              <div class="thumb">
                <img src="assets/img/whatwedo/1.jpg" alt="Thumb">
                <i class="fas fa-sink"></i>
                <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
              </div>
              <div class="content">
                <h4><a href="#">Kitchen Plumbing</a></h4>
                <p>
                  Continue indulged speaking the man horrible for domestic position. Seeing rather her you not esteem
                  men settle.
                </p>
                <a class="btn-common" href="services.php">View Details</a>
              </div>
            </div>
            <!-- End Single Item -->
            <!-- Single Item -->
            <div class="services-style-four">
              <div class="thumb">
                <img src="assets/img/whatwedo/2.jpg" alt="Thumb">
                <i class="fas fa-gas-pump"></i>
                <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
              </div>
              <div class="content">
                <h4><a href="#">Gas Line Services </a></h4>
                <p>
                  Continue indulged speaking the man horrible for domestic position. Seeing rather her you not esteem
                  men settle.
                </p>
                <a class="btn-common" href="services.php">View Details</a>
              </div>
            </div>
            <!-- End Single Item -->
            <!-- Single Item -->
            <div class="services-style-four">
              <div class="thumb">
                <img src="assets/img/whatwedo/3.jpg" alt="Thumb">
                <i class="fas fa-faucet-drip"></i>
                <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
              </div>
              <div class="content">
                <h4><a href="#">Water Line Repair </a></h4>
                <p>
                  Continue indulged speaking the man horrible for domestic position. Seeing rather her you not esteem
                  men settle.
                </p>
                <a class="btn-common" href="services.php">View Details</a>
              </div>
            </div>
            <!-- End Single Item -->
            <!-- Single Item -->
            <div class="services-style-four">
              <div class="thumb">
                <img src="assets/img/whatwedo/4.jpg" alt="Thumb">
                <i class="far fa-toilet"></i>
                <div class="shape" style="background-image: url(assets/img/shape/brush.png);"></div>
              </div>
              <div class="content">
                <h4><a href="#">Bathroom Plumbing </a></h4>
                <p>
                  Continue indulged speaking the man horrible for domestic position. Seeing rather her you not esteem
                  men settle.
                </p>
                <a class="btn-common" href="services.php">View Details</a>
              </div>
            </div>
            <!-- End Single Item -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Services Area -->

  <!-- Start Fun Factor Area
    ============================================= -->
  <div class="fun-factor-area bg-theme text-light">

    <!-- Shape -->
    <div class="shape">
      <img src="assets/img/illustration/11.png" alt="Shape">
    </div>
    <!-- End Shape -->

    <div class="container">
      <div class="fun-fact-items text-center default-padding">
        <div class="row">
          <div class="col-lg-4 col-md-6 item">
            <div class="fun-fact">
              <div class="counter">
                <div class="timer" data-to="1267" data-speed="5000">1267</div>
                <div class="operator">+</div>
              </div>
              <span class="medium">Orders</span>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 item">
            <div class="fun-fact">
              <div class="counter">
                <div class="timer" data-to="846" data-speed="5000">846</div>
                <div class="operator">+</div>
              </div>
              <span class="medium">Trusted Clients</span>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 item">
            <div class="fun-fact">
              <div class="counter">
                <div class="timer" data-to="36" data-speed="5000">36</div>
                <div class="operator">+</div>
              </div>
              <span class="medium">Years Of Experience</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fixed BG -->
    <div class="fixed-bg" style="background-image: url(assets/img/shape/29.png);"></div>
    <!-- Fixed BG -->
  </div>
  <!-- End Fun Factor Area -->

  <!-- Start Team 
    ============================================= -->
  <div class="team-area default-padding-top bottom-less">
    <!-- Fixed Shape -->
    <div class="fixed-sahpe-bottom">
      <img src="assets/img/shape/19.png" alt="Shape">
    </div>
    <!-- End Fixed Shape -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>awesome team</h4>
            <h2>The best team to <br> clean your surrounding area.</h2>
            <div class="devider"></div>
            <p>
              At Salairinch, we have an exceptional team of licensed plumbers who are dedicated to providing high-quality service. With years of experience and a commitment to customer satisfaction, our team is the best choice for all your plumbing needs. Trust us to clean and maintain your surrounding area with ease.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="team-style-one-box">
        <div class="row">
          <!-- Single Item -->
          <div class="col-lg-4 col-md-6 text-center team-style-one">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/team/1.jpg" alt="Thumb">
              </div>
              <div class="info">
                <h4><a href="team-single.html">Anna Green</a></h4>
                <p>
                  Carpet Cleaner
                </p>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="col-lg-4 col-md-6 text-center team-style-one">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/team/3.jpg" alt="Thumb">
              </div>
              <div class="info">
                <h4><a href="team-single.html">Liana Rob</a></h4>
                <p>
                  Office Cleaner
                </p>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
          <!-- Single Item -->
          <div class="col-lg-4 col-md-6 text-center team-style-one">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/team/2.jpg" alt="Thumb">
              </div>
              <div class="info">
                <h4><a href="team-single.html">Thomas Pual</a></h4>
                <p>
                  Cleaning Manager
                </p>
              </div>
            </div>
          </div>
          <!-- End Single Item -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Team-->

  <!-- Start Projects Area 
    ============================================= -->
  <div class="projects-area default-padding">
    <div class="container">
      <div class="heading-left">
        <div class="row">
          <div class="col-lg-5">
            <h5>Successful Project</h5>
            <h2>
              Keep your vision to our latest projects.
            </h2>
          </div>
          <div class="col-lg-6 offset-lg-1">
            <p>
              Salairinch has a proven track record of successful plumbing projects for residential and commercial properties. Our experienced team of licensed plumbers takes pride in delivering high-quality results that exceed expectations. From installations to repairs and maintenance, we can help bring your vision to life. We're committed to ensuring projects are completed on time and within budget. Check out our latest projects and let us help you achieve your plumbing goals.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fill">
      <div class="project-items project-carousel owl-carousel owl-theme">
        <!-- Single Item -->
        <div class="project-style-one">
          <img src="assets/img/portfolio/2.jpg" alt="Thumb">
          <div class="info">
            <h4><a href="project-details.html">Door Cleaning</a></h4>
            <span>House, Office</span>
          </div>
        </div>
        <!-- End Single Item -->
        <!-- Single Item -->
        <div class="project-style-one">
          <img src="assets/img/portfolio/5.jpg" alt="Thumb">
          <div class="info">
            <h4><a href="project-details.html">Garden Cleaning</a></h4>
            <span>Apartment</span>
          </div>
        </div>
        <!-- End Single Item -->
        <!-- Single Item -->
        <div class="project-style-one">
          <img src="assets/img/portfolio/1.jpg" alt="Thumb">
          <div class="info">
            <h4><a href="project-details.html">Bedroom Cleaning</a></h4>
            <span>Residential, Office</span>
          </div>
        </div>
        <!-- End Single Item -->
        <!-- Single Item -->
        <div class="project-style-one">
          <img src="assets/img/portfolio/3.jpg" alt="Thumb">
          <div class="info">
            <h4><a href="project-details.html">House Cleaning</a></h4>
            <span>Home, Apartment</span>
          </div>
        </div>
        <!-- End Single Item -->
        <!-- Single Item -->
        <div class="project-style-one">
          <img src="assets/img/portfolio/4.jpg" alt="Thumb">
          <div class="info">
            <h4><a href="project-details.html">Furniture Cleaning</a></h4>
            <span>Office, House</span>
          </div>
        </div>
        <!-- End Single Item -->
      </div>
    </div>
  </div>
  <!-- End Projects Area Area -->

  <!-- Start Pricing Area 
    ============================================= -->
  <div class="pricing-area shadow default-padding-bottom bottom-less d-none">
    <!-- Fixed Shape -->
    <div class="fixed-sahpe-bottom">
      <img src="assets/img/shape/19.png" alt="Shape">
    </div>
    <!-- End Fixed Shape -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>Cleaning Plans</h4>
            <h2>Take a look of our Pricing and <br> select Your Choice</h2>
            <div class="devider"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="pricing pricing-simple">
        <div class="row">
          <div class="col-lg-4 col-md-6 single-item">
            <div class="pricing-item">
              <div class="pricing-header">
                <h4>Residential</h4>
              </div>
              <div class="price">
                <h2><sup>$</sup>20</h2>
                <p>
                  For Homes
                </p>
              </div>
              <ul>
                <li>Profetional Cleaner <i class="fas fa-check-circle"></i></li>
                <li>2 Bedrroms Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Kitchen Cleaning <i class="fas fa-times-circle"></i></li>
                <li>2 Bathroom Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Roof Cleaning <i class="fas fa-check-circle"></i></li>
              </ul>
              <a class="btn btn-dark effect btn-sm" href="contact.html">Book Now</a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 single-item">
            <div class="pricing-item active">
              <div class="pricing-header">
                <h4>Commercial</h4>
              </div>
              <div class="price">
                <h2><sup>$</sup>36</h2>
                <p>
                  For Business
                </p>
              </div>
              <ul>
                <li>Profetional Cleaner <i class="fas fa-check-circle"></i></li>
                <li>Windows Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Kitchen Cleaning <i class="fas fa-check-circle"></i></li>
                <li>2 Bathroom Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Roof Cleaning <i class="fas fa-times-circle"></i></li>
              </ul>
              <a class="btn btn-theme secondary effect btn-sm" href="contact.html">Book Now</a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 single-item">
            <div class="pricing-item">
              <div class="pricing-header">
                <h4>Ressort</h4>
              </div>
              <div class="price">
                <h2><sup>$</sup>49</h2>
                <p>
                  For Strata
                </p>
              </div>
              <ul>
                <li>Profetional Cleaner <i class="fas fa-check-circle"></i></li>
                <li>2 Livingroom Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Kitchen Cleaning <i class="fas fa-times-circle"></i></li>
                <li>2 Bathroom Cleaning <i class="fas fa-check-circle"></i></li>
                <li>Roof Cleaning <i class="fas fa-check-circle"></i></li>
              </ul>
              <a class="btn btn-dark effect btn-sm" href="contact.html">Book Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Pricing Area -->

  <!-- Start Testimonials Area 
    ============================================= -->
  <div class="testimonials-area carousel-shadow relative half-bg mb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>Testimonials</h4>
            <h2>What Clients Say About Us</h2>
            <div class="devider"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="testimonial-items">
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <div class="testimonial-carousel owl-carousel owl-theme">
              <!-- Signle Item -->
              <div class="item">
                <img src="assets/img/testimonial/1.jpg" alt="Thumb">
                <div class="content">
                  <img src="assets/img/shape/quote.png" alt="Quote">
                  <p>
                    I recently had an urgent plumbing issue and called Salairinch for help. To my relief, they were able to send a licensed plumber to my home within a few hours. The plumber was professional, courteous, and took the time to explain the issue and how it could be fixed. I appreciated that they had all the necessary tools and equipment with them, so they were able to fix the problem quickly. I highly recommend Salairinch for any plumbing needs. Thank you for your prompt and excellent service.
                  </p>
                  <div class="provider">
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5>John Smith, satisfied customer.</h5>
                  </div>
                </div>
              </div>
              <!-- End Signle Item -->
              <!-- Signle Item -->
              <div class="item">
                <img src="assets/img/testimonial/2.jpg" alt="Thumb">
                <div class="content">
                  <img src="assets/img/shape/quote.png" alt="Quote">
                  <p>
                    I had a great experience with Salairinch. I called them to fix a leaky faucet, and they were able to schedule an appointment that same day. The plumber arrived on time and was very friendly and knowledgeable. They took the time to explain the problem and how it could be fixed. I was impressed by their attention to detail and how they made sure everything was cleaned up before they left. Overall, I had an excellent experience with Salairinch and would highly recommend them to anyone looking for plumbing services.
                  </p>
                  <div class="provider">
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h5>Sarah Johnson, happy client.</h5>
                  </div>
                </div>
              </div>
              <!-- End Signle Item -->
              <!-- Signle Item -->
              <div class="item">
                <img src="assets/img/testimonial/3.jpg" alt="Thumb">
                <div class="content">
                  <img src="assets/img/shape/quote.png" alt="Quote">
                  <p>
                    Salairinch provided excellent service for our business. We had a major plumbing issue that was causing significant downtime. They were able to quickly identify and fix the problem, which helped minimize our losses. The plumber was professional, courteous, and took the time to explain the problem and the steps they were taking to fix it. We appreciated their attention to detail and their ability to work around our schedule to minimize disruptions to our business. We highly recommend Salairinch for any commercial plumbing needs.
                  </p>
                  <div class="provider">
                    <div class="rating">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                    </div>
                    <h5>Alex Chen, satisfied customer.</h5>
                  </div>
                </div>
              </div>
              <!-- End Signle Item -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Testimonials Area  -->

  <!-- Start Blog 
    ============================================= -->
  <div class="blog-area grid-style default-padding bottom-less bg-gray d-none">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <div class="site-heading text-center">
            <h4>From the blog</h4>
            <h2>Latest News & Articles</h2>
            <div class="devider"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="blog-items">
        <div class="row">
          <!-- Single Itme -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/800x600.png" alt="Thumb">
                <div class="date">Jul <strong>21</strong></div>
              </div>
              <div class="info">
                <div class="meta">
                  <ul>
                    <li>
                      <span>By </span>
                      <a href="#">John Baus</a>
                    </li>
                    <li>
                      <span>In </span>
                      <a href="#">Agency</a>
                    </li>
                  </ul>
                </div>
                <h4><a href="blog-single-with-sidebar.html">Discovery incommode earnestly commanded mentions.</a></h4>
                <p>
                  Etensive repulsive belonging depending promotion be zealously as. Preference point inquietude ask now
                  are dispatched.
                </p>
                <a href="blog-single-with-sidebar.html" class="btn-simple"><i class="fas fa-plus"></i> Read More</a>
              </div>
            </div>
          </div>
          <!-- End Single Itme -->
          <!-- Single Itme -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/800x600.png" alt="Thumb">
                <div class="date">Aug <strong>18</strong></div>
              </div>
              <div class="info">
                <div class="meta">
                  <ul>
                    <li>
                      <span>By </span>
                      <a href="#">Monus Botha</a>
                    </li>
                    <li>
                      <span>In </span>
                      <a href="#">Agency</a>
                    </li>
                  </ul>
                </div>
                <h4><a href="blog-single-with-sidebar.html">Everything melancholy uncommonly but solicitude.</a></h4>
                <p>
                  Etensive repulsive belonging depending promotion be zealously as. Preference point inquietude ask now
                  are dispatched.
                </p>
                <a href="blog-single-with-sidebar.html" class="btn-simple"><i class="fas fa-plus"></i> Read More</a>
              </div>
            </div>
          </div>
          <!-- End Single Itme -->
          <!-- Single Itme -->
          <div class="single-item col-lg-4 col-md-6">
            <div class="item">
              <div class="thumb">
                <img src="assets/img/800x600.png" alt="Thumb">
                <div class="date">Sep <strong>15</strong></div>
              </div>
              <div class="info">
                <div class="meta">
                  <ul>
                    <li>
                      <span>By </span>
                      <a href="#">Mills Paul</a>
                    </li>
                    <li>
                      <span>In </span>
                      <a href="#">Agency</a>
                    </li>
                  </ul>
                </div>
                <h4><a href="blog-single-with-sidebar.html">Providing top quality cleaning and related services
                    charms.</a></h4>
                <p>
                  Etensive repulsive belonging depending promotion be zealously as. Preference point inquietude ask now
                  are dispatched.
                </p>
                <a href="blog-single-with-sidebar.html" class="btn-simple"><i class="fas fa-plus"></i> Read More</a>
              </div>
            </div>
          </div>
          <!-- End Single Itme -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Blog Area  -->


  <!-- Footer  -->
  <?php include('footer.php'); ?>


</body>

</html>