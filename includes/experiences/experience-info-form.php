<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["action"]) || $_POST["action"] !== "add_experience") return;
require_once __DIR__ . "/../../src/db.php";
?>

<div class="experience-info-form" id="focus-form">
    <h2>Create Your Experience</h2>
    <form action="actions/experience-info-form-action.php" method="POST" enctype="multipart/form-data" class="experience-form">
        <div class="title">
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
        </div>

        <div class="description">
            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>

        <div class="min-participants">
            <label for="min_participants">Min. Participants</label>
            <input type="number" name="min_participants" id="min_participants" min="1" max="255">
        </div>

        <div class="max-participants">
            <label for="max_participants">Max Participants</label>
            <input type="number" name="max_participants" id="max_participants" min="1" max="255">
        </div>

        <div class="price">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" min="0" max="9999.99" step="0.01">
        </div>

        <div class="pricing-method">
            <label for="pricing_method">Pricing Method</label>
            <select name="pricing_method" id="pricing_method">
                <?php foreach (getPricingMethods($pdo) as $pricingMethod) { ?>
                    <option value="<?php echo $pricingMethod["id"] ?>"><?php echo $pricingMethod["name"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="bookable-days">
            <label for="">Bookable Days</label>
            <?php foreach ($bookableDays as $day => $bit) { ?>
                <div>
                    <input type="checkbox" name="bookable_days" id="<?php echo $day ?>" value="<?php echo $bit ?>">
                    <label for="<?php echo $day ?>"><?php echo $day ?></label>
                </div>
            <?php } ?>
        </div>

        <div class="duration">
            <label for="duration">Duration</label>
            <p class="info">(hours)</p>
            <input type="number" name="duration" id="duration" min="1" max="255">
        </div>

        <div class="bookings-open-start">
            <label for="bookings_open_start">Bookings Open</label>
            <p class="info">(Earliest Booking)</p>
            <input type="time" name="bookings_open_start" id="bookings_open_start">
        </div>

        <div class="bookings-open-end">
            <label for="bookings_open_end">Bookings Close</label>
            <p class="info">(Latest Booking)</p>
            <input type="time" name="bookings_open_end" id="bookings_open_end">
        </div>

        <div class="banner-img">
            <label for="banner_img">Banner Image</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            <input type="file" name="banner_img" id="banner_img">
        </div>

        <div class="submit">
            <button name="action" value="create_experience">Create Experience</button>
        </div>

        <div class="cancel">
            <button name="action" value="cancel">Cancel</button>
        </div>
    </form>
</div>