<?php
if (empty($profileData)) die("Missing profile data");
if (session_status() === PHP_SESSION_NONE) session_start();

$profileTags = getUserTags($pdo, $profileData["id"]);

$profilePicturePath = __DIR__ . "/../../public/uploads/pfp/{$profileData["id"]}.png";
?>

<div class="profile-banner">
    <div class="profile-picture">
        <img src="<?php echo file_exists($profilePicturePath) ? "uploads/pfp/{$profileData["id"]}.png?" . time() : "assets/icons/person.png" ?>" alt="">
    </div>
    <div class="profile-info">
        <h2><?php echo htmlspecialchars("{$profileData["first_name"]} {$profileData["last_name"]}") ?></h2>
        <p><?php echo htmlspecialchars($profileData["bio"]) ?></p>
        <p><span class="role-name"><?php echo $profileData["role_name"] ?></span><span class="country"><?php echo $profileData["country_id"] != 0 ? " | {$profileData["country_name"]}" : "" ?></span><span class="subdivision"><?php echo $profileData["subdivision_id"] != 0 ? " | {$profileData["subdivision_name"]}" : "" ?></span></p>
        <div class="profile-tag-display">
            <?php foreach ($profileTags as $tag) {
                $typeClassName = str_replace(" ", "-", strtolower($tag["type_name"])); ?>
                <span class="tag <?php echo $typeClassName ?>"><?php echo $tag["tag_name"] ?></span>
            <?php } ?>
        </div>
    </div>
    <div class="profile-actions">
        <?php if (!empty($_SESSION["userData"]) && $_SESSION["userData"]["id"] === $profileData["id"]) { ?>
            <form action="#focus-form" method="POST">
                <input type="hidden" name="id" value="<?php echo $profileData["id"] ?>">
                <button name="action" value="edit_profile" <?php echo isset($_POST["id"]) ? "disabled" : "" ?>>Edit Profile</button>
            </form>
            <form action="actions/logout-action.php">
                <button>Log Out</button>
            </form>
            <?php if ($_SESSION["userData"]["roleId"] === 0) { ?>
                <form action="financial-report.php">
                    <button>View Financial Report</button>
                </form>
            <?php } ?>
        <?php } ?>
    </div>
</div>