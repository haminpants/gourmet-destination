<?php
if (empty($profileData)) die("Missing profile data");
if ($profileData["role_id"] !== 2) return;
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION["log"])) $_SESSION["log"] = [];

require_once __DIR__ . "/../../src/db.php";
$isHostView = isset($_SESSION["userData"]) && $_SESSION["userData"]["id"] === $profileData["id"] && $profileData["role_id"] === 2;
$experienceAssetsDir = __DIR__ . "/../../public/uploads/experience"
?>

<section class="profile-experience-display">
    <h2><?php echo $isHostView ? "My" : htmlspecialchars("{$profileData["first_name"]}'s") ?> Experiences</h2>
    <?php if(isset($_SESSION["log"])) { print_r($_SESSION["log"]); } unset($_SESSION["log"]);  ?>

    <div class="profile-experience-grid">
        <?php foreach (getExperiencesByUserId($pdo, $profileData["id"]) as $experience) {
            $assetDir = "{$experienceAssetsDir}/{$experience["id"]}" ?>
            <div class="experience-container">
                <div class="banner centered-container">
                    <img src="<?php echo file_exists("{$assetDir}/banner.png") ? "uploads/experience/{$experience["id"]}/banner.png?" . time() : "assets/default_banner.png" ?>" alt="">
                </div>
                <div class="info-body">
                    <h3 class="title"><?php echo htmlspecialchars($experience["title"]); ?></h3>
                    <p class="description"><?php echo htmlspecialchars($experience["description"]); ?></p>

                    <div class="misc-info">
                        <div>
                            <img src="assets/icons/person.png" alt="">
                            <div>
                                <p>Participants</p>
                                <p><?php echo htmlspecialchars("{$experience["min_participants"]}-{$experience["max_participants"]}"); ?></p>
                            </div>
                        </div>
                        <div>
                            <img src="assets/icons/clock.png" alt="">
                            <div>
                                <p>Duration</p>
                                <p><?php echo htmlspecialchars("{$experience["duration"]}"); ?> hours</p>
                            </div>
                        </div>
                        <div>
                            <img src="assets/icons/cash.png" alt="">
                            <div>
                                <p>Price</p>
                                <p>$<?php echo htmlspecialchars("{$experience["price"]}{$experience["pricing_method_description"]}"); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="action-row">
                        <?php if ($isHostView) { ?>
                            <form action="#focus-form" method="POST">
                                <input type="hidden" name="experience_id" value="<?php echo $experience["id"] ?>">
                                <button name="action" value="manage_experience">Edit</button>
                            </form>
                        <?php } ?>
                        <form action="">
                            <input type="hidden" name="experience_id" value="<?php echo $experience["id"] ?>">
                            <button>Book</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($isHostView) { ?>
            <div>
                <form action="#focus-form" method="POST" class="create-new-experience">
                    <button name="action" value="manage_experience" <?php echo !empty($_POST["action"]) && $_POST["action"] === "manage_experience" ? "disabled" : "" ?>>
                        <img src="assets/icons/add.png" alt="">
                        <h3>Add An Experience</h3>
                    </button>
                </form>
            </div>
        <?php } ?>
    </div>
</section>