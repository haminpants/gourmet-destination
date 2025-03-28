<?php
if (empty($profileData)) die("Missing profile data");
?>

<div class="profile-banner">
    <div class="profile-picture">

    </div>
    <div class="profile-info">
        <h2><?php echo htmlspecialchars("{$profileData["first_name"]} {$profileData["last_name"]}") ?></h2>
        <p><?php echo htmlspecialchars($profileData["bio"]) ?></p>
    </div>
</div>