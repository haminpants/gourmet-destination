<?php
if (empty($profileData)) die("Missing profile data");
if (session_status() === PHP_SESSION_NONE) session_start();

$isHostView = isset($_SESSION["userData"]) && $_SESSION["userData"]["id"] === $profileData["id"];
?>

<section class="profile-experience-display">
    <h2><?php echo $isHostView ? "My" : htmlspecialchars("{$profileData["first_name"]}'s") ?> Experiences</h2>

    <div class="profile-experience-grid">
        <div>
            <form action="" method="POST" class="create-new-experience">
                <button name="action" value="add_experience"><img src="assets/icons/add.png" alt=""><h3>Add An Experience</h3></button>
            </form>
        </div>
    </div>
</section>