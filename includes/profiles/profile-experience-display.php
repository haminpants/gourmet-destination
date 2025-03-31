<?php
if (empty($profileData)) die("Missing profile data");
if ($profileData["role_id"] !== 2) return;
if (session_status() === PHP_SESSION_NONE) session_start();

$isHostView = isset($_SESSION["userData"]) && $_SESSION["userData"]["id"] === $profileData["id"];
?>

<section class="profile-experience-display">
    <h2><?php echo $isHostView ? "My" : htmlspecialchars("{$profileData["first_name"]}'s") ?> Experiences</h2>

    <div class="profile-experience-grid">


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