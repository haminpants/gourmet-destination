<?php
require_once(__DIR__ . "/../../src/db.php");
if (session_status() === PHP_SESSION_NONE) session_start();

$canLeaveReview = canReviewExperience($pdo, intval($_SESSION["userData"]["id"]), $experience["id"]);

$reviews = getExperienceReviews($pdo, $experience["id"]);
$reviewStats = getExperienceReviewStats($pdo, $experience["id"]);

$pfpDir = __DIR__ . "/../../public/uploads/pfp";
?>

<?php if ($canLeaveReview) {
    $reviewType = "experience";
    $reviewAuthorId = $_SESSION["userData"]["id"];
    $reviewTargetId = $experience["id"];
    $successRedirect = "booking.php?experience_id={$experience["id"]}";
    $failRedirect = "booking.php?experience_id={$experience["id"]}"; ?>
    <div class="centered-container">
        <?php require(__DIR__ . "/../../includes/review-form.php"); ?>
    </div>
<?php } ?>

<div class="centered-container">
    <div class="profile-reviews">
        <h2>Experience Reviews</h2>
        <?php if ($reviewStats["total_ratings"] === 0) { ?>
            <h4>No reviews yet!</h4>
        <?php } else { ?>
            <h4>Average Rating: <?php echo $reviewStats["average_rating"] ?></h4>
            <div class="summary">
                <div class="ratings">
                    <div class="entry">
                        <label for="five_star_reviews">5⭐</label>
                        <meter id="five_star_reviews" value="<?php echo $reviewStats["five_star_ratings"] / $reviewStats["total_ratings"] ?>"></meter>
                        <span>(<?php echo $reviewStats["five_star_ratings"] ?>)</span>
                    </div>
                    <div class="entry">
                        <label for="four_star_reviews">4⭐</label>
                        <meter id="four_star_reviews" value="<?php echo $reviewStats["four_star_ratings"] / $reviewStats["total_ratings"] ?>"></meter>
                        <span>(<?php echo $reviewStats["four_star_ratings"] ?>)</span>
                    </div>
                    <div class="entry">
                        <label for="three_star_reviews">3⭐</label>
                        <meter id="three_star_reviews" value="<?php echo $reviewStats["three_star_ratings"] / $reviewStats["total_ratings"] ?>"></meter>
                        <span>(<?php echo $reviewStats["three_star_ratings"] ?>)</span>
                    </div>
                    <div class="entry">
                        <label for="two_star_reviews">2⭐</label>
                        <meter id="two_star_reviews" value="<?php echo $reviewStats["two_star_ratings"] / $reviewStats["total_ratings"] ?>"></meter>
                        <span>(<?php echo $reviewStats["two_star_ratings"] ?>)</span>
                    </div>
                    <div class="entry">
                        <label for="one_star_reviews">1⭐</label>
                        <meter id="one_star_reviews" value="<?php echo $reviewStats["one_star_ratings"] / $reviewStats["total_ratings"] ?>"></meter>
                        <span>(<?php echo $reviewStats["one_star_ratings"] ?>)</span>
                    </div>
                </div>
            </div>

            <div class="review-list">
                <?php foreach ($reviews as $review) {
                    $datePosted = date_format(new DateTime($review["created_at"]), "F j, Y") ?>
                    <div class="review">
                        <div class="header">
                            <div class="pfp-container"><img src="<?php echo file_exists("{$pfpDir}/{$review["user_id"]}.png") ? "uploads/pfp/{$review["user_id"]}.png" : "assets/icons/person.png" ?>" class="pfp"></div>
                            <div class="user">
                                <h3><?php echo htmlspecialchars("{$review["first_name"]} {$review["last_name"]}") ?></h3>
                                <p><?php echo $datePosted ?></p>
                                <p><?php for ($i = 0; $i < $review["rating"]; $i++) echo "⭐" ?></p>
                            </div>
                            <div class="description">
                                <p><?php echo htmlspecialchars($review["description"]) ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>