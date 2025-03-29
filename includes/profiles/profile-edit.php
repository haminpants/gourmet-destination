<?php
include __DIR__ . "/../../src/subdivision-data.php";

if (isset($_SESSION["profileAction"]) && $_SESSION["profileAction"] === "editProfile") unset($_SESSION["profileAction"]);
else if (
    $_SERVER["REQUEST_METHOD"] !== "POST" ||
    empty($_POST["action"]) || $_POST["action"] !== "edit_profile" ||
    empty($_POST["id"]) || $_POST["id"] != $_SESSION["userData"]["id"]
) return
?>

<div class="profile-edit">
    <h2>Edit Profile</h2>
    <p>Edit your profile information!</p>
    <form action="actions/edit-profile-action.php" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        <div class="first-name">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName" required value="<?php echo htmlspecialchars($profileData["first_name"]); ?>">
        </div>

        <div class="last-name">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName" required value="<?php echo htmlspecialchars($profileData["last_name"]); ?>">
        </div>

        <div class="bio">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" maxlength="512"><?php echo !empty($profileData["bio"]) ? htmlspecialchars($profileData["bio"]) : "" ?></textarea>
        </div>

        <div class="country">
            <label for="country">Country</label>
            <select name="country" id="country">
                <?php foreach (array_keys($subdivisionData) as $country) { ?>
                    <option value="<?php echo $country ?>" <?php echo $profileData["country_id"] === $country ? "selected" : "" ?>><?php echo $subdivisionData[$country]["name"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="subdivision">
            <label for="subdivision">State/Province</label>
            <select name="subdivision" id="subdivision">
                <?php foreach ($subdivisionData as $country) { ?>
                    <optgroup label="<?php echo $country["name"] ?>">
                        <?php foreach ($country["subdivisions"] as $subdivisionId => $subdivisionName) { ?>
                            <option value="<?php echo $subdivisionId ?>" <?php echo $subdivisionId === $profileData["subdivision_id"] ? "selected" : "" ?>><?php echo $subdivisionName ?></option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </div>

        <div class="profile-picture">
            <label for="profilePicture">Update Profile Picture<br></label>
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