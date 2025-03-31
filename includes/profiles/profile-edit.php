<?php
include __DIR__ . "/../../src/subdivision-data.php";
if (!isset($_SESSION["editProfileErrorMsgs"])) $_SESSION["editProfileErrorMsgs"] = [];
if (!isset($_SESSION["editProfileFormData"])) $_SESSION["editProfileFormData"] = [];

if (isset($_SESSION["profileAction"]) && $_SESSION["profileAction"] === "editProfile") unset($_SESSION["profileAction"]);
else if (
    $_SERVER["REQUEST_METHOD"] !== "POST" ||
    empty($_POST["action"]) || $_POST["action"] !== "edit_profile" ||
    empty($_POST["id"]) || $_POST["id"] != $_SESSION["userData"]["id"]
) return;
?>

<div class="profile-edit">
    <h2>Edit Profile</h2>
    <p>Edit your profile information!</p>
    <?php foreach ($_SESSION["editProfileErrorMsgs"] as $msg) { ?>
        <p class="error-msg"><?php echo $msg ?></p>
    <?php } ?>
    <form action="actions/edit-profile-action.php" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        <div class="first-name">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName" required value="<?php echo htmlspecialchars(isset($_SESSION["editProfileFormData"]["firstName"]) ? $_SESSION["editProfileFormData"]["firstName"] : $profileData["first_name"]); ?>">
        </div>

        <div class="last-name">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName" required value="<?php echo htmlspecialchars(isset($_SESSION["editProfileFormData"]["lastName"]) ? $_SESSION["editProfileFormData"]["lastName"] : $profileData["last_name"]); ?>">
        </div>

        <div class="bio">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" maxlength="512"><?php echo !empty($profileData["bio"]) ? htmlspecialchars(isset($_SESSION["editProfileFormData"]["bio"]) ? $_SESSION["editProfileFormData"]["bio"] : $profileData["bio"]) : "" ?></textarea>
        </div>

        <div class="country">
            <label for="country">Country</label>
            <select name="country" id="country" <?php if ($profileData["role_id"] === 2) echo "required" ?>>
                <?php if ($profileData["role_id"] !== 2 || $profileData["country_id"] == 0) { ?>
                    <option value="<?php echo $profileData["role_id"] !== 2 ? "0" : "" ?>" <?php echo $profileData["country_id"] == 0 ? "selected" : "" ?> <?php echo $profileData["role_id"] === 2 ? "disabled" : "" ?>>Hidden</option>
                <?php } ?>
                <?php foreach (array_keys($subdivisionData) as $country) { ?>
                    <option value="<?php echo $country ?>" <?php echo (isset($_SESSION["editProfileFormData"]["country_id"]) && $_SESSION["editProfileFormData"]["country_id"] === $country) || $profileData["country_id"] === $country ? "selected" : "" ?>><?php echo $subdivisionData[$country]["name"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="subdivision">
            <label for="subdivision">State/Province</label>
            <select name="subdivision" id="subdivision" <?php if ($profileData["role_id"] === 2) echo "required" ?>>
                <?php if ($profileData["role_id"] !== 2 || $profileData["subdivision_id"] == 0) { ?>
                    <option value="<?php echo $profileData["role_id"] !== 2 ? "0" : "" ?>" <?php echo $profileData["subdivision_id"] == 0 ? "selected" : "" ?> <?php echo $profileData["role_id"] === 2 ? "disabled" : "" ?>>Hidden</option>
                <?php } ?>
                <?php foreach ($subdivisionData as $country) { ?>
                    <optgroup label="<?php echo $country["name"] ?>">
                        <?php foreach ($country["subdivisions"] as $subdivisionId => $subdivisionName) { ?>
                            <option value="<?php echo $subdivisionId ?>" <?php echo (isset($_SESSION["editProfileFormData"]["subdivision_id"]) && $_SESSION["editProfileFormData"]["subdivision_id"] === $subdivisionId) || $profileData["subdivision_id"] === $subdivisionId ? "selected" : "" ?>><?php echo $subdivisionName ?></option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </div>

        <div class="profile-picture">
            <label for="profilePicture">Update Profile Picture<br></label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            <input type="file" name="profilePicture" id="profilePicture" accept="image/png, image/jpeg">
        </div>

        <div class="submit">
            <input type="hidden" name="id" value="<?php echo $profileData["id"] ?>">
            <button name="action" value="edit_profile">Save Changes</button>
        </div>

        <div class="cancel">
            <button name="action" value="cancel">Cancel</button>
        </div>
    </form>
</div>