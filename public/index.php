<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gourmet Destination</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>

<?php
session_start();
unset($_SESSION["loginErrorMsgs"]);
unset($_SESSION["loginFormData"]);
unset($_SESSION["signupErrorMsgs"]);
unset($_SESSION["signupFormData"]);
unset($_SESSION["profileAction"]);
unset($_SESSION["editProfileErrorMsgs"]);
unset($_SESSION["editProfileFormData"]);
unset($_SESSION["experienceErrorMsgs"]);
unset($_SESSION["experienceFormData"]);
unset($_SESSION["experienceId"]);
?>

<body>
  <?php include "../includes/nav-bar.php" ?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>GourmetDestination</h1>
      <div class="search-bar">
        <input type="text" placeholder="Search" />
        <button><span class="material-icons">search</span></button>
      </div>
    </div>
  </section>

  <!-- Discover Section -->
  <section class="discover">
    <div class="text">
      <h2>Discover Local Flavours And Unique Experiences</h2>
      <p>Engage with local guides and home cooks to uncover hidden culinary treasures. Experience authentic flavours and connect with your community through unique food events.</p>
      <div class="buttons">
        <button>Explore</button>
        <button class="light">Learn More</button>
      </div>
    </div>
    <div class="image">
      <img src="assets/Discover_Flavours.jpg" alt="Discover Food">
    </div>
  </section>

  <!-- Mission Section -->
  <section class="mission">
    <div class="mission-overlay">
      <h2>GourmetDestination’s Mission</h2>
      <p>To connect tourists with talented local guides and home cooks for an adventurous culinary experience. Explore authentic food experiences and discover the rich flavours of our community.</p>
    </div>
  </section>

  <!-- Explore Events Section -->
  <section class="explore-events">
    <div class="explore-text">
      <h2>Explore Local Food Events And Workshops</h2>
      <p>Join us for a culinary adventure in your community! Experience the flavours of local cuisine through exciting events and hands-on workshops.</p>
      <ul>
        <li>Taste the best local dishes at our events</li>
        <li>Learn cooking techniques from local chefs and experts</li>
        <li>Connect with fellow food lovers in your area</li>
      </ul>
      <div class="buttons">
        <button>Explore</button>
        <button class="light">Learn More</button>
      </div>
    </div>
    <div class="explore-image">
      <img src="assets/Discover_Flavours2.jpg" alt="Workshops">
    </div>
  </section>

  <!-- Discover Local Events Today Section -->
  <section class="discover-events">
    <h2>Discover Local Events Today</h2>
    <p>Uncover rich tapestry and culture. Connect with local guides and home cooks to discover hidden culinary treasures in your area.</p>
    <div class="card-row">
      <div class="card">
        <img src="assets/Discover_Local1.jpg" alt="Chefs">
        <h3>Meet Our Talented Local Chefs</h3>
        <p>Experience authentic dishes prepared by passionate home cooks.</p>
      </div>
      <div class="card">
        <img src="assets/Discover_Local2.jpg" alt="Hidden Restaurants">
        <h3>Find Hidden Restaurants Beyond the Path</h3>
        <p>Explore the best of local culture and cuisine with our guided tours.</p>
      </div>
      <div class="card">
        <img src="assets/Discover_Local3.jpg" alt="Workshops">
        <h3>Engage in Unique Food Activities and Workshops</h3>
        <p>Join for a culinary adventure through exciting events and hands-on workshops.</p>
      </div>
    </div>
  </section>

  <!-- Become a Local Guide Section -->
  <section class="local-guide">
    <div class="overlay">
      <h2>Become A Local Guide Or Home Cook Today!</h2>
      <p>Join our community to showcase your expertise and offer exciting local events.</p>
      <div class="buttons">
        <button>Sign Up</button>
        <button class="light">Learn More</button>
      </div>
    </div>
  </section>
</body>

</html>