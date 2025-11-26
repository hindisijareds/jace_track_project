<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shortcut icon" href="./images/jacelogoclean.png" type="image/png" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./css/styles.css" />
    <title>JaceTrack - Landing</title>

    <style>
      #preloader {
        position: fixed;
        inset: 0;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
      }
      #preloader.hidden { display: none; }
       .logo-img {
    width: 70px;
    height: 70px;
    object-fit: contain;
  }

  /* Mobile adjustments */
  @media (max-width: 768px) {
    .logo-img {
      width: 45px;
      height: 45px;
    }
  }
    </style>
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <img src="./images/jacelogoclean.png" alt="JaceTrack Logo">
    </div>

<header class="header">
  <nav class="navbar">
    <div class="container d-flex align-items-center">

      <a href="" class="logo d-flex me-auto">
  <img src="./images/jacelogoclean.png" alt="JaceTrack" class="logo-img">
</a>

      <ul class="nav-list d-flex mx-auto">
        <span class="close d-lg-none"><i class="bx bx-x"></i></span>
        <a href="">Home</a>
        <a href="">Shipping</a>
        <a href="">Services</a>
        <a href="">Join Us</a>
        <a href="">About Us</a>
        <a href="">Contact</a>
        <li class="d-lg-none"><a href="#">Profile</a></li>
        <li class="d-lg-none"><a href="#">Cart</a></li>
      </ul>

      <div class="d-none d-lg-flex align-items-center ms-auto gap-3">
        <!-- Dashboard button triggers popup -->
       <button id="dashboardBtn" class="btn btn-outline-primary d-flex align-items-center gap-2 px-3">
  <i class="bx bx-user fs-5"></i>
  <span>Dashboard</span>
</button>
      </div>

      <div class="hamburger d-flex d-lg-none">
        <i class="bx bx-menu"></i>
      </div>
    </div>
  </nav>

<section class="tracking-bar py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="input-group input-group-lg shadow">
          <input type="search" class="form-control" placeholder="Enter Tracking Number" aria-label="Tracking Number">
          <button class="btn btn-primary px-4" type="button">
            <i class="bx bx-search"></i> Track
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="home">
  <div class="row container">
    <div class="col">
      <div class="faster">
        More than Faster
        <div class="image d-flex">
          <img src="./images/motorblue.png" alt="" />
        </div>
      </div>
      <h1>
        Door to Door, <br />
        same day <br />
        <span class="color">delivery</span>
      </h1>
      <p>
        Shipment that is delivered at the right time. The fast courier delivery
        partner. Fast delivery is what we offer.
      </p>
      <!-- Ship Now triggers popup -->
      <button id="shipNowBtn" class="btn btn-primary">Ship Now</button>
    </div>
    <div class="col">
      <img src="./images/herologo.png" alt="" />
    </div>
  </div>
</div>
</header>

<section class="section services" id="services">
  <div class="row container">
    <div class="col">
      <h2>We do our Best in our Province</h2>
      <p>
        We deliver your package safely and quickly. We are a courier service
        that you can trust.
      </p>
    </div>
    <div class="col">
      <div class="card">
        <img src="./images/delivery-shipping-ecommerce-svgrepo-com.svg" alt="" />
        <h3>Pickup Service</h3>
        <h4>Pick up parcels at your door</h4>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="./images/tag-price-discount-svgrepo-com.svg" alt="" />
        <h3>Less Shipping Fee</h3>
        <h4>We have low shipping fee</h4>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <img src="./images/cashback-cash-payment-svgrepo-com.svg" alt="" />
        <h3>COD Service</h3>
        <h4>Cash on Delivery Available</h4>
      </div>
    </div>
  </div>
</section>

<section class="section about" id="about">
  <div class="row container">
    <div class="col">
      <img src="./images/delivery-guy-2.svg" alt="JaceTrack Delivery" />
    </div>
    <div class="col">
      <h2>About JaceTrack</h2>
      <p>
        JaceTrack is a reliable courier and logistics platform dedicated to making 
        deliveries easier, faster, and more secure. From local parcels to business shipments, 
        we ensure every package reaches its destination with speed and care.
      </p>
      <div class="d-grid">
        <div class="card">
          <img src="./images/car-icon.svg" alt="Fast Delivery" />
          <h4>Fast & Reliable Delivery</h4>
          <span>On-time shipping Pangasinan</span>
        </div>
        <div class="card">
          <img src="./images/dollar-icon.svg" alt="Affordable Rates" />
          <h4>Affordable Rates</h4>
          <span>Transparent pricing, no hidden charges</span>
        </div>
        <div class="card">
          <img src="./images/security-icon.svg" alt="Safe & Secure" />
          <h4>Safe & Secure</h4>
          <span>Your parcels are always protected</span>
        </div>
        <div class="card">
          <img src="./images/time-icon.svg" alt="Customer Support" />
          <h4>24/7 Support</h4>
          <span>Always here to assist your delivery needs</span>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="row container">
    <div class="col">
      <div class="logo d-flex">
        <img src="./images/jacelogoclean.png" height="70px" width="70" alt="logo" />
      </div>
      <p>
        We deliver your package safely and quickly. We are a courier service
        that you can trust.
      </p>
      <div class="icons d-flex">
        <div class="icon d-flex"><i class="bx bxl-facebook"></i></div>
        <div class="icon d-flex"><i class="bx bxl-twitter"></i></div>
      </div>
    </div>
    <div class="col">
      <div>
        <h4>Company</h4>
        <a href="">About Us</a>
      </div>
      <div>
        <h4>Services</h4>
        <a href="">Shipment tracking</a>
        <a href="">COD Service</a>
        <a href="">Terms & Conditions</a>
      </div>
      <div>
        <h4>Support</h4>
        <a href="">FAQ</a>
        <a href="">Policy</a>
      </div>
      <div>
        <h4>Contact</h4>
        <a href="">Facebook</a>
        <a href="">Contact Number</a>
        <a href="">Quick Chat</a>
      </div>
    </div>
  </div>
</footer>
<div class="footer-bottom">
  <div class="row container d-flex">
    <p>Copyright © 2025 JaceTrack</p>
    <p>Created by Team Illegal</p>
  </div>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="loginPopup" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header border-0">
        <h5 class="modal-title text-primary"><i class="bx bx-lock"></i> Login Required</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>You need to <strong>Sign In</strong> or <strong>Sign Up</strong> to continue.</p>
        <img src="./images/jacelogoclean.png" width="60" class="my-2" alt="JaceTrack Logo">
      </div>
      <div class="modal-footer border-0 justify-content-center">
        <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>

      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/testimonial.js"></script>
<script src="./js/products.js"></script>
<script src="./js/main.js"></script>
<script src="./js/preloader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Preloader
  function hidePreloader() {
    const preloader = document.getElementById("preloader");
    if (preloader) preloader.classList.add("hidden");
  }
  window.addEventListener("load", hidePreloader);
  setTimeout(hidePreloader, 3000);

  // Show login popup
  function showLoginPopup() {
    const popup = new bootstrap.Modal(document.getElementById("loginPopup"));
    popup.show();
  }
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const loggedIn = localStorage.getItem("loggedIn");
  const role = localStorage.getItem("role");

  const dashboardBtn = document.getElementById("dashboardBtn");
  const shipNowBtn = document.getElementById("shipNowBtn");

  function redirectToDashboard() {
  if (role === "user") window.location.href = "/dashboard";
  else if (role === "rider") window.location.href = "/dashboard";
  else if (role === "admin") window.location.href = "/dashboard";
}


  if (loggedIn && role) {
    dashboardBtn.addEventListener("click", redirectToDashboard);
    shipNowBtn.addEventListener("click", redirectToDashboard);
  } else {
    dashboardBtn.addEventListener("click", showLoginPopup);
    shipNowBtn.addEventListener("click", showLoginPopup);
  }
});


</script>


</body>
</html>

