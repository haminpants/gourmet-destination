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

require_once "../src/db.php";
include "../includes/nav-bar.php";

$stmt = $pdo->prepare("SELECT id FROM experiences");
$stmt->execute();
$experienceIds = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

// Check if any admin accounts are registered. If none, create the default admin account
$stmt = $pdo->prepare("SELECT * FROM users WHERE role_id=0");
$stmt->execute();
if (!$stmt->fetch()) {
    require_once("../src/stripe-api.php");
    try { $customer = $stripe->customers->create(["name" => "ADMIN", "email" => "admin@gourmetdestination.com"]); }
    catch (Exception $e) { echo "Stripe API failed to create customer for default admin account. Default admin account has not been created."; }

    $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, role_id, stripe_customer_id)
        VALUES (:email, :password, :first_name, :last_name, :role_id, :stripe_customer_id)");
    $stmt->execute([
        ":email" => "admin@gourmetdestination.com",
        ":password" => password_hash("adminpassword", PASSWORD_DEFAULT),
        ":first_name" => "ADMIN",
        ":last_name" => "DEFAULT",
        "role_id" => 0,
        ":stripe_customer_id" => $customer->id
    ]);
}
?>

<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Gourmet Destination</h1>
            <form action="booking.php">
                <input type="hidden" name="experience_id" value="<?php echo $experienceIds[array_rand($experienceIds)] ?>">
                <button>Show Me Something New</button>
            </form>
        </div>
    </section>

    <!-- Discover Section -->
    <section class="discover">
        <div class="text">
            <h2>Discover Local Flavours And Unique Experiences</h2>
            <p>Engage with local guides and home cooks to uncover hidden culinary treasures. Experience authentic flavours and connect with your community through unique food events.</p>
            <div class="buttons">
                <form action="browse-experiences.php">
                    <button>Explore</button>
                </form>
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
                <form action="browse-experiences.php">
                    <button>Explore</button>
                </form>
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
                <form action="sign-up.php">
                    <button>Sign Up</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>