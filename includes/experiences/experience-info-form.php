<?php
if (isset($_SESSION["profileAction"]) && $_SESSION["profileAction"] === "manage_experience") unset($_SESSION["profileAction"]);
else if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["action"]) || $_POST["action"] !== "manage_experience") return;

require_once __DIR__ . "/../../src/db.php";
if (!isset($_SESSION["experienceErrorMsgs"])) $_SESSION["experienceErrorMsgs"] = [];
if (!isset($_SESSION["experienceFormData"])) $_SESSION["experienceFormData"] = [];

if (isset($_SESSION["experienceFormData"]["title"])) $title = $_SESSION["experienceFormData"]["title"];
else $title = "";
if (isset($_SESSION["experienceFormData"]["description"])) $description = $_SESSION["experienceFormData"]["description"];
else $description = "";
if (isset($_SESSION["experienceFormData"]["min_participants"])) $minParticipants = $_SESSION["experienceFormData"]["min_participants"];
else $minParticipants = "1";
if (isset($_SESSION["experienceFormData"]["max_participants"])) $maxParticipants = $_SESSION["experienceFormData"]["max_participants"];
else $maxParticipants = "1";
if (isset($_SESSION["experienceFormData"]["price"])) $price = $_SESSION["experienceFormData"]["title"];
else $price = "0.00";
if (isset($_SESSION["experienceFormData"]["pricing_method"])) $pricingMethod = $_SESSION["experienceFormData"]["pricing_method"];
else $pricingMethod = "0";
if (isset($_SESSION["experienceFormData"]["bookable_days"])) $bookableDays = $_SESSION["experienceFormData"]["bookable_days"];
else $bookableDays = 0;
if (isset($_SESSION["experienceFormData"]["duration"])) $duration = $_SESSION["experienceFormData"]["duration"];
else $duration = 1;
if (isset($_SESSION["experienceFormData"]["bookings_open_start"])) $bookingsOpenStart = $_SESSION["experienceFormData"]["bookings_open_start"];
else $bookingsOpenStart = "24:00:00";
if (isset($_SESSION["experienceFormData"]["bookings_open_end"])) $bookingsOpenEnd = $_SESSION["experienceFormData"]["bookings_open_end"];
else $bookingsOpenEnd = "23:59:00";
?>

<div class="experience-info-form" id="focus-form">
    <h2>Create Your Experience</h2>
    <?php foreach ($_SESSION["experienceErrorMsgs"] as $msg) { ?>
        <p class="error-msg"><?php echo $msg ?></p>
    <?php } ?>
    <form action="actions/experience-info-form-action.php" method="POST" enctype="multipart/form-data" class="experience-form">
        <div class="title">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>">
        </div>

        <div class="description">
            <label for="description">Description</label>
            <textarea name="description" id="description" maxlength="50000"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="min-participants">
            <label for="min_participants">Min. Participants</label>
            <input type="number" name="min_participants" id="min_participants" min="1" max="255" value="<?php echo htmlspecialchars($minParticipants); ?>">
        </div>

        <div class="max-participants">
            <label for="max_participants">Max Participants</label>
            <input type="number" name="max_participants" id="max_participants" min="1" max="255" value="<?php echo htmlspecialchars($maxParticipants); ?>">
        </div>

        <div class="price">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" min="0" max="9999.99" step="0.01" value="<?php echo htmlspecialchars($price); ?>">
        </div>

        <div class="pricing-method">
            <label for="pricing_method">Pricing Method</label>
            <select name="pricing_method" id="pricing_method">
                <?php foreach (getPricingMethods($pdo) as $pricingMethod) { ?>
                    <option value="<?php echo $pricingMethod["id"] ?>" <?php echo $pricingMethod == $pricingMethod["id"] ? "selected" : "" ?>><?php echo $pricingMethod["name"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="bookable-days">
            <label for="">Bookable Days</label>
            <?php foreach ($daysBitMask as $day => $bit) { ?>
                <div>
                    <input type="checkbox" name="bookable_days[]" id="<?php echo $day ?>" value="<?php echo $bit ?>" <?php echo $bookableDays & $bit ? "checked" : "" ?>>
                    <label for="<?php echo $day ?>"><?php echo $day ?></label>
                </div>
            <?php } ?>
        </div>

        <div class="duration">
            <label for="duration">Duration</label>
            <p class="info">(hours)</p>
            <input type="number" name="duration" id="duration" min="1" max="255" value="<?php echo htmlspecialchars($duration); ?>">
        </div>

        <div class="bookings-open-start">
            <label for="bookings_open_start">Bookings Open</label>
            <p class="info">(Earliest Booking)</p>
            <input type="time" name="bookings_open_start" id="bookings_open_start" value="<?php echo date("H:i", strtotime($bookingsOpenStart)); ?>">
        </div>

        <div class="bookings-open-end">
            <label for="bookings_open_end">Bookings Close</label>
            <p class="info">(Latest Booking)</p>
            <input type="time" name="bookings_open_end" id="bookings_open_end" value="<?php echo date("H:i", strtotime($bookingsOpenEnd)); ?>">
        </div>

        <div class="banner-img">
            <label for="banner_img">Banner Image</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input type="file" name="banner_img" id="banner_img">
        </div>

        <div class="submit">
            <input type="hidden" name="id" value="<?php echo $profileData["id"] ?>">
            <button name="action" value="create_experience">Create Experience</button>
        </div>

        <div class="cancel">
            <button name="action" value="cancel">Cancel</button>
        </div>
    </form>
</div>