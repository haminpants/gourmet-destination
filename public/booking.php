<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Booking</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
// If an error is sent, display the corresponding error code 
if (!empty($_GET["err"]) && is_numeric($_GET["err"])) {
    switch (intval($_GET["err"])) {
        case 1:
            echo "No experience found for the given experience_id";
            break;
        case 2:
            echo "Failed to create booking in database";
            break;
        case 3:
            echo "Value of experience_id must be an integer";
            break;
        case 4:
            echo "Value of booking_id must be an integer";
            break;
        case 5:
            echo "No booking found for the given booking_id";
            break;
        case 6:
            echo "You do not have permission to view this booking";
            break;
        default:
            echo "Unsupported action";
            break;
    }
    echo ("<br>Redirecting to home page in 5 seconds...<br><a href=\"index.php\">Click here if not redirected</a>");
    header("Refresh:5; URL=index.php");
    return;
}
// ===========================
require_once("../src/db.php");
require_once("../includes/nav-bar.php");
if (session_status() === PHP_SESSION_NONE) session_start();

// Verify that the user is logged in
if (empty($_SESSION["userData"]["id"])) {
    header("Location: login.php");
    die();
}
$user = getUserById($pdo, $_SESSION["userData"]["id"]);

// If an experience_id is provided, if the user doesn't have a booking for that experience already, create one
if (!empty($_GET["experience_id"])) {
    if (!is_numeric($_GET["experience_id"])) redirectToError(3, $pdo); // Value of experience_id must be an integer

    // Check if the experience exists
    $stmt = $pdo->prepare("SELECT * FROM experiences WHERE id=:id");
    $stmt->execute([":id" => intval($_GET["experience_id"])]);
    $experience = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$experience) redirectToError(1, $pdo); // No experience for given experience_id

    // Check if the user already has a booking for the experience that is not yet completed
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id=:user_id AND experience_id=:experience_id AND status_id < 3");
    $stmt->execute([":user_id" => $user["id"], ":experience_id" => intval($_GET["experience_id"])]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the user hasn't made a booking for the experience, create one
    if (!$booking) {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, experience_id, participants) VALUES (:user_id, :experience_id, :participants)");
        $success = $stmt->execute([":user_id" => $user["id"], ":experience_id" => $experience["id"], ":participants" => $experience["min_participants"]]);

        if (!$success) redirectToError(2, $pdo); // Failed to create booking in database
        else $bookingId = $pdo->lastInsertId(); // On success, get the id of the created booking
    }

    // By this point, the user has a booking for the experience, redirect to the booking for it
    $bookingId ??= $booking["id"]; // bookingId will be null if a relevant booking was found
    header("Location: booking.php?booking_id={$bookingId}");
    $pdo = null;
    die();
}
// Otherwise, if a booking_id is provided, fetch the remaining necessary information and display the data
else if (!empty($_GET["booking_id"])) {
    if (!is_numeric($_GET["booking_id"])) redirectToError(4, $pdo); // Value of booking_id must be an integer

    // Check if the booking exists
    $booking = getBookingById($pdo, intval($_GET["booking_id"]));
    if (!$booking) redirectToError(5, $pdo); // No booking for given booking_id

    // Check that the user accessing the booking is also the person who created the booking
    if ($booking["user_id"] !== $user["id"]) redirectToError(6, $pdo);

    // By this point, we can display the booking, just fetch the remaining necessary data
    $experience = getExperienceById($pdo, $booking["experience_id"]);
    $host = getUserById($pdo, $experience["host_id"]);

    $decodedBookableDays = [];
    foreach ($daysBitMask as $day => $bit) if ($experience["bookable_days"] & $bit) $decodedBookableDays[] = $day;

    if (file_exists("uploads/pfp/{$host["id"]}.png")) $hostPfp = "uploads/pfp/{$host["id"]}.png";
    else $hostPfp = "assets/icons/person.png";

    if (file_exists("uploads/experience/{$experience["id"]}/banner.png")) $experienceBanner = "uploads/experience/{$experience["id"]}/banner.png";
    else $experienceBanner = "assets/default_banner.png";

    $errorMsgs = $_SESSION["bookingErrorMsgs"] ?? [];
    $successMsg = $_SESSION["bookingSuccessMsg"] ?? [];
    $formData = $_SESSION["bookingFormData"] ?? [];
    unset($_SESSION["bookingErrorMsgs"]);
    unset($_SESSION["bookingSuccessMsg"]);
    unset($_SESSION["bookingFormData"]);
}
// Otherwise, redirect to unknown error
else redirectToError(100, $pdo);
?>

<body class="booking-page">
    <div class="header">
        <div class="background-img centered-container"><img src="<?php echo $experienceBanner ?>" alt=""></div>
        <div class="content">
            <h1><?php echo htmlspecialchars($experience["title"]) ?></h1>
            <div class="host-details">
                <div class="profile-picture centered-container"><img src="<?php echo $hostPfp ?>" alt=""></div>
                <h3><?php echo htmlspecialchars("{$host["first_name"]} {$host["last_name"]}") ?></h3>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="experience-info centered-container">
            <div class="blob">
                <h4>Experience Info</h4>
                <div>
                    <div class="info-block">
                        <img src="assets/icons/calendar.png" alt="">
                        <div class="text-container availability">
                            <p class="title">Availability</p>
                            <p class="description"><?php echo implode(" ", array_map(fn($day) => substr($day, 0, 3), $decodedBookableDays)) ?></p>
                        </div>
                    </div>
                    <div class="info-block">
                        <img src="assets/icons/clock.png" alt="">
                        <div class="text-container booking-time">
                            <p class="title">Booking Times</p>
                            <p class="description"><?php echo formatTime($experience["bookings_open_start"]) ?> Open</p>
                            <p class="description"><?php echo formatTime($experience["bookings_open_end"]) ?> Close</p>
                        </div>
                    </div>
                    <div class="info-block">
                        <img src="assets/icons/person.png" alt="">
                        <div class="text-container participants">
                            <p class="title">Participants</p>
                            <p class="description"><?php echo "{$experience["min_participants"]} - {$experience["max_participants"]}" ?></p>
                            <p class="description">Per booking</p>
                        </div>
                    </div>
                    <div class="info-block">
                        <img src="assets/icons/cash.png" alt="">
                        <div class="text-container price">
                            <p class="title">Price</p>
                            <p class="description">$<?php echo $experience["price"] ?></p>
                            <p class="description"><?php echo $experience["pricing_method_name"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="experience-description">
            <div class="blob">
                <h3>Description</h3>
                <p><?php echo htmlspecialchars($experience["description"]); ?></p>
                <h3>Cancellation Policy</h3>
                <p>Bookings can not be cancelled on the day of the booking. Cancelling bookings incurs a 10% cancellation fee.</p>
            </div>
        </div>

        <div class="booking-info centered-container">
            <div class="blob">
                <h2>Your Booking</h2>
                <?php foreach ($errorMsgs as $msg) { ?>
                    <p class="error-msg"><?php echo $msg ?></p>
                <?php } ?>
                <?php if (!empty($successMsg)) { ?>
                    <p class="success-msg"><?php echo $successMsg ?></p>
                <?php } ?>
                <form action="actions/booking-form-action.php" method="POST">
                    <input type="hidden" name="booking_id" value="<?php echo $booking["id"] ?>">
                    <div>
                        <label for="participants">Participants</label>
                        <input type="number" name="participants" id="participants" min="<?php echo $experience["min_participants"] ?>" max="<?php echo $experience["max_participants"] ?>" value="<?php echo $formData["participants"] ?? $booking["participants"] ?>" <?php echo $booking["status_id"] === 3 ? "readonly" : "" ?> required>
                    </div>
                    <div>
                        <label for="time">Booking Date</label>
                        <input type="date" name="booking_date" id="booking_date" value="<?php echo $formData["booking_date"] ?? formatDateInput($booking["booking_time"]) ?>" <?php echo $booking["status_id"] === 3 ? "readonly" : "" ?> required>
                    </div>
                    <div>
                        <label for="time">Booking Time</label>
                        <input type="time" name="booking_time" id="booking_time" value="<?php echo $formData["booking_time"] ?? formatTimeInput($booking["booking_time"]) ?>" <?php echo $booking["status_id"] === 3 ? "readonly" : "" ?> required>
                    </div>
                    <?php if ($booking["status_id"] < 3) { ?>
                        <div>
                            <button name="action" value="save">Save for Later</button>
                        </div>
                        <div>
                            <button name="action" value="check_datetime">Check Booking</button>
                        </div>
                    <?php } ?>
                    <?php if ($booking["status_id"] === 0) { ?>
                        <div>
                            <button name="action" value="confirm_booking">Confirm Booking</button>
                        </div>
                    <?php } ?>
                    <?php if ($booking["status_id"] === 3 && bookingHasHappened($booking["booking_time"])) { ?>
                        <div>
                            <button name="action" value="cancel_booking" onclick="return confirm('Are you sure you want to cancel this booking?\nA 10% cancellation fee will apply.')">Cancel Booking</button>
                        </div>
                    <?php } ?>
                    <?php if ($booking["status_id"] < 3) { ?>
                        <div class="delete">
                            <button name="action" value="delete_booking" onclick="return confirm('Are you sure you want to delete this booking?')">Delete Booking</button>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
function redirectToError(int $errorCode, PDO $pdo = null)
{
    header("Location: booking.php?err={$errorCode}");
    $pdo = null;
    die();
}
function formatDate(string $dateTime)
{
    $date = new DateTime($dateTime);
    return $date->format("D, M d");
}
function formatDateInput($date)
{
    $date = new DateTime($date);
    return $date->format("Y-m-d");
}
function formatTime(string $dateTime)
{
    $time = new DateTime($dateTime);
    return $time->format("g:i A");
}
function formatTimeInput(string $time)
{
    $time = new DateTime($time);
    return $time->format("H:i");
}
function bookingHasHappened(string $bookingDateTimeStr)
{
    $bookingDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $bookingDateTimeStr, new DateTimeZone("America/Vancouver"));
    $bookingDateStr = $bookingDateTime->format("Y-m-d");

    $nowDateTime = new DateTime("now", new DateTimeZone("America/Vancouver"));
    $nowTimeStr = $nowDateTime->format("H:i:s");
    
    $compareBookingDateTime = DateTime::createFromFormat("Y-m-d H:i:s", "{$bookingDateStr} {$nowTimeStr}", new DateTimeZone("America/Vancouver"));
    return $compareBookingDateTime > $nowDateTime ? true : false;
}
?>