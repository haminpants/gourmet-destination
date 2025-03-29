<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gourmet Destination</title>
  <link rel="stylesheet" href="assets/style.css" />
</head>

<?php
session_start();
unset($_SESSION["loginErrorMsgs"]);
unset($_SESSION["loginFormData"]);
unset($_SESSION["signupErrorMsgs"]);
unset($_SESSION["signupFormData"]);
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
</body>
</html>
<!-- Mission Section -->
<section class="mission">
  <div class="mission-overlay">
    <h2>GourmetDestination’s Mission</h2>
    <p>To connect tourists with talented local guides and home cooks for an adventurous culinary experience. Explore authentic food experiences and discover the rich flavours of our community.</p>
  </div>
</section>

