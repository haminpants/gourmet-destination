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
      <!-- <div class="search-bar"> -->
        <!-- <input type="text" placeholder="Search" />
        <button><span class="material-icons">search</span></button> -->
        
        <?php if (!empty($_GET['error'])) echo "<p>Sorry, there's no search results. Please try again.</p>"; ?>
        <form class="search-bar" method="POST" action="actions/search-action.php">
        <button><span class="material-icons">search</span></button>
        <input list="searchItem" name="searchBar" placeholder="Search by: Pronvinces and States">
            <datalist id="searchItem">
                <option value="AB">Alberta</option>
                <option value="BC">British Columbia</option>
                <option value="MB">Manitoba</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="NS">Nova Scotia</option>
                <option value="ON">Ontario</option>
                <option value="PE">Prince Edward Island</option>
                <option value="QC">Quebec</option>
                <option value="SK">Saskatchewan</option>
                <option value="NT">Northwest Territories</option>
                <option value="NU">Nunavut</option>
                <option value="YT">Yukon</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
                <!-- <button><span class="material-icons">search</span></button> -->
                <?php
                
                //diplays existing users and their roles in the search bar
                    // $stmt = $pdo->prepare("SELECT users.first_name, users.last_name, roles.name
                    //                        FROM users
                    //                        JOIN roles ON users.role_id = roles.id
                    //                        ");
                    // $stmt->execute();

                    // while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //     echo "<option value='" . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "'>"
                    //                 . htmlspecialchars($user['name']) . "</option>";
                                    
                    // }

                    //displays existing experiences
                    // $stmt2 = $pdo->prepare("SELECT name, description FROM experiences");
                    // $stmt2->execute();

                    // while ($experience = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //     echo "<option value='" . htmlspecialchars($experience['name']) . "'>"
                    //             . htmlspecialchars($experience['description']) . "</option>";
                    // }
                    
                ?>
            </datalist>
       </form>
      <!-- </div> -->
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