<?php
if (empty($profileData)) die("Missing profile data");
if (session_status() === PHP_SESSION_NONE) session_start();
$profilePicturePath = __DIR__ . "/../../public/uploads/pfp/{$profileData["id"]}.png";
?>

<div class="profile-banner">
    <div class="profile-picture">
        <img src="<?php echo file_exists($profilePicturePath) ? "uploads/pfp/{$profileData["id"]}.png?" . time() : "assets/icons/default_profile_picture.png" ?>" alt="">
    </div>
    <div class="profile-info">
        <h2><?php echo htmlspecialchars("{$profileData["first_name"]} {$profileData["last_name"]}") ?></h2>
        <p><?php echo htmlspecialchars($profileData["bio"]) ?></p>
    </div>
    <div class="profile-actions">
        <?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["id"] === $profileData["id"]) { ?>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $profileData["id"] ?>">
                <button name="action" value="edit_profile" <?php echo isset($_POST["id"]) ? "disabled" : "" ?>>Edit Profile</button>
            </form>
        <?php } ?>
    </div>
</div>