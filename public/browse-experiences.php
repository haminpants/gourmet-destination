<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Browsing Experiences</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<?php
require_once("../src/db.php");
include("../includes/nav-bar.php");

if (session_status() === PHP_SESSION_NONE) session_start();

$hostTags = getAllTagsByType($pdo, 0);
$cuisineTags = getAllTagsByType($pdo, 1);

$queryFilters = [];
$bindings = [];
if (!empty($_GET["host_filter"]) && is_numeric($_GET["host_filter"])) {
    $queryFilters[] = "ut.tag_id=:host_filter";
    $bindings[":host_filter"] = $_GET["host_filter"];
}
if (!empty($_GET["cuisine_filter"]) && is_numeric($_GET["cuisine_filter"])) {
    $queryFilters[] = "e.cuisine_tag_id=:cuisine_filter";
    $bindings[":cuisine_filter"] = $_GET["cuisine_filter"];
}
if (!empty($_GET["dow_filter"])) {
    $queryFilters[] = "(e.bookable_days & :dow_filter)";
    $bindings[":dow_filter"] = intval($_GET["dow_filter"]);
}
$queryFilterStr = implode(" AND ", $queryFilters);

$stmt = $pdo->prepare("SELECT e.id, e.title, e.description, e.min_participants, e.max_participants, e.bookable_days, e.price, e.cuisine_tag_id, ut.tag_id AS host_tag_id, t.name AS tag_name, u.first_name, u.last_name
    FROM experiences as e
    JOIN users AS u ON e.host_id=u.id
    JOIN user_tags AS ut ON u.id=ut.user_id
    JOIN tags AS t ON ut.tag_id=t.id AND t.type_id=0 " . (!empty($queryFilters) ? "WHERE {$queryFilterStr}" : ""));
$stmt->execute($bindings);
$filterResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body class="browsing-page">
    <section class="hero-banner">
        <h1>Explore Culinary Experiences</h1>
        <p>Discover hidden gems, local chefs, and unique food adventures around the world.</p>
    </section>

    <section class="search">
        <div class="centered-container">
            <form action="" class="search-bar">
                <h4>Filter Experiences</h4>
                <div class="search-element">
                    <label for="host-filter">Hosts</label>
                    <select name="host_filter" id="host-filter">
                        <option value="">Any</option>
                        <?php foreach ($hostTags as $tag) { ?>
                            <option value="<?php echo $tag["id"] ?>" <?php echo ($_GET["host_filter"] ?? "") == $tag["id"] ? "selected" : "" ?>><?php echo $tag["name"] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="search-element">
                    <label for="cuisine-filter">Cuisines</label>
                    <select name="cuisine_filter" id="cuisine-filter">
                        <option value="">All</option>
                        <?php foreach ($cuisineTags as $tag) { ?>
                            <option value="<?php echo $tag["id"] ?>" <?php echo ($_GET["cuisine_filter"] ?? "") == $tag["id"] ? "selected" : "" ?>><?php echo $tag["name"] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="search-element">
                    <label for="day-of-week-filter">Date</label>
                    <select name="dow_filter" id="day-of-week-filter">
                        <option value="">All</option>
                        <?php foreach ($daysBitMask as $day => $bit) { ?>
                            <option value="<?php echo $bit ?>" <?php echo ($_GET["dow_filter"] ?? "") == $bit ? "selected" : "" ?>><?php echo $day ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="search-element">
                    <button>Search</button>
                </div>
            </form>
        </div>
        <div class="centered-container">
            <div class="results">
                <?php foreach ($filterResults as $result) {
                    $bannerImgPath = "uploads/experience/{$result["id"]}/banner.png";
                    $bannerImg = file_exists($bannerImgPath) ? $bannerImgPath : "assets/default_banner.png" ?>
                    <div class="entry">
                        <div class="banner-img centered-container"><img src="<?php echo $bannerImg ?>" alt=""></div>
                        <div class="body">
                            <h4><?php echo htmlspecialchars($result["title"]) ?></h4>
                            <div class="description-container">
                                <p><?php echo htmlspecialchars($result["description"]) ?></p>
                            </div>
                            <form action="booking.php">
                                <input type="hidden" name="experience_id" value="<?php echo $result["id"] ?>">
                                <button>Book</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

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

    <section class="cta-banner">
        <div class="cta-overlay">
            <h2>Embark on a culinary journey like never before.</h2>
            <a href="sign-up.php" class="cta-button">Book with us today!</a>
        </div>
    </section>
</body>

</html>