<?php include __DIR__ . '/../includes/nav-bar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browsing Experiences</title>
  <link rel="stylesheet" href="assets/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="browsing-page">
  <div class="browsing-experiences">

    <!-- Hero Section -->
    <section class="hero-banner">
      <h1>Explore Culinary Experiences</h1>
      <p>Discover hidden gems, local chefs, and unique food adventures around the world.</p>
    </section>

   <!-- Featured Experiences -->
<section class="featured-experiences">
  <h2 class="section-title">Featured Experiences</h2>
  <p class="section-subtitle">Taste the flavors of the world with our curated selection.</p>

  <div class="card-row">
    <div class="card">
      <div class="card-image" style="background-image: url('../assets/FeaturedExperiencesPastaClass.jpg');"></div>
      <div class="card-content">
        <h3>Pasta Making Class</h3>
        <p>Rome, Italy</p>
      </div>
    </div>

    <div class="card">
      <div class="card-image" style="background-image: url('../assets/FeaturedExperiencesSushiClass.jpg');"></div>
      <div class="card-content">
        <h3>Sushi Masterclass</h3>
        <p>Tokyo, Japan</p>
      </div>
    </div>

    <div class="card">
      <div class="card-image" style="background-image: url('../assets/FeaturedExperiencesWineTasting.jpg');"></div>
      <div class="card-content">
        <h3>Wine Tasting Tour</h3>
        <p>Bordeaux, France</p>
      </div>
    </div>
  </div>
</section>


  

<section class="local-chefs-section">
  <h2>Featured Local Home Chefs</h2>
  <p>Indulge in home-cooked meals crafted with love by our skilled chefs.</p>

  <div class="chef-cards">
    <div class="chef-card">
      <div class="chef-image-container">
        <img src="../assets/ChefGiovanni.jpg" alt="Chef Giovanni">
      </div>
      <div class="chef-info">
        <h3>Chef Giovanni's Table</h3>
        <p class="subtitle">Italian Fusion Creations</p>
        <p class="description">A blend of modern and traditional Italian dishes.</p>
        <span class="chef-badge master">Master Chef</span>
        <p class="chef-name"> Giovanni Rossi</p>
      </div>
    </div>

    <div class="chef-card">
      <div class="chef-image-container">
        <img src="../assets/ChefMaria.jpg" alt="Chef Maria">
      </div>
      <div class="chef-info">
        <h3>Chef Maria's Kitchen</h3>
        <p class="subtitle">Traditional Spanish Cuisine</p>
        <p class="description">Experience authentic flavors from Spain.</p>
        <span class="chef-badge five-star">5-star Chef</span>
        <p class="chef-name"> Maria Lopez</p>
      </div>
    </div>
  </div>
</section>


    <!-- Customer Reviews -->
    <section class="customer-reviews">
      <h2>Customer Reviews</h2>
      <div class="reviews-container">
        <div class="review-card">
          <p>"Absolutely loved the pasta making class in Rome!"<br><strong>- Jessica</strong></p>
        </div>
        <div class="review-card">
          <p>"The wine tasting tour in Bordeaux was a dream."<br><strong>- Alex</strong></p>
        </div>
        <div class="review-card">
          <p>"Chef Maria’s Spanish cooking was a true delight."<br><strong>- Emily</strong></p>
        </div>
      </div>
    </section>

    <!-- Explore by Cuisine -->
    <section class="explore-cuisine-section">
  <div class="cuisine-text">
    <h2>Explore by Cuisine</h2>
    <p>Find the perfect culinary experience based on your preferred cuisine.</p>
  </div>
  <div class="cuisine-cards">
    <div class="cuisine-card">
      <span class="material-icons cuisine-icon">local_pizza</span>
      <div>
        <h3>Italian Cuisine</h3>
        <p>Pasta Making, Pizza Workshops</p>
      </div>
    </div>
    <div class="cuisine-card">
      <span class="material-icons cuisine-icon">ramen_dining</span>
      <div>
        <h3>Japanese Delicacies</h3>
        <p>Sushi Classes, Ramen Tours</p>
      </div>
    </div>
    <div class="cuisine-card">
      <span class="material-icons cuisine-icon">lunch_dining</span>
      <div>
        <h3>Mediterranean Flavors</h3>
        <p>Greek Feasts, Tapas Nights</p>
      </div>
    </div>
  </div>
</section>

</body>
<section class="tour-guides-section">
  <div class="tour-guide-photo"></div>
  <h2>Meet Our Tour Guides</h2>
  <div class="guide-tags">
    <span class="tag">Local Experts</span>
    <span class="tag">Food Enthusiasts</span>
  </div>
  <p>Discover the stories behind each culinary journey.</p>
</section>

<section class="personalized-recommendations">
  <h2>Get Personalized Recommendations</h2>
  <p>Tell us your preferences, and we’ll match you with the perfect culinary experience.</p>

  <form class="recommendation-form">
    <div class="input-group">
      <label for="cuisine">Cuisine Preference</label>
      <input type="text" id="cuisine" placeholder="E.g., Italian, Japanese, Mexican">
    </div>

    <div class="input-group">
      <label for="region">Region of Interest</label>
      <input type="text" id="region" placeholder="E.g., Europe, Asia, South America">
    </div>

    <button type="submit">Get Recommendations</button>
  </form>
</section>
<section class="cta-banner">
  <div class="cta-overlay">
    <h2>Embark on a culinary journey like never before.</h2>
    <a href="sign-up.php" class="cta-button">Book with us today!</a>
  </div>
</section>
<footer class="site-footer">
  <div class="footer-container">
    <a href="#">About Us</a>
    <a href="#">Contact</a>
    <a href="#">Terms of Service</a>
    <a href="#">Privacy Policy</a>
  </div>
</footer>

</html>
