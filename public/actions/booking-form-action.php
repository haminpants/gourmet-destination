<?php
// Make sure this page is only reached by a post request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("index.php");
    $pdo = null;
    die();
}

// Check that required inputs were submitted and are the right type
if (empty($_POST["action"])) redirectWithError("action is required");
else if (empty($_POST["booking_id"])) redirectWithError("booking_id cannot be empty");
else if (!is_numeric($_POST["booking_id"])) redirectWithError("booking_id must be an integer");
else if (empty($_POST["participants"])) redirectWithError("participants cannot be blank");
else if (!is_numeric($_POST["participants"])) redirectWithError("participants must be an integer");
else if (empty($_POST["booking_date"])) redirectWithError("booking_date cannot be blank");
else if (empty($_POST["booking_time"])) redirectWithError("booking_time cannot be blank");

require_once("../../src/db.php");
$booking = getBookingById($pdo, intval($_POST["booking_id"]));
if (!$booking) redirectWithError("No booking found for given booking_id");

session_start();
$_SESSION["bookingErrorMsgs"] = [];
if (empty($_SESSION["userData"]["id"]) || $_SESSION["userData"]["id"] != $booking["user_id"]) redirectWithError("You do not have access to this resource");

// Check if this is a delete or cancel action
if ($_POST["action"] === "delete_booking") {
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id=:id AND status_id<3");
    $stmt->execute([":id" => $booking["id"]]);
    header("Location: ../profile.php");
    $pdo = null;
    die();
} else if ($_POST["action"] === "cancel_booking") {
    require_once(__DIR__ . "/../../src/stripe-api.php");
    $challenge = random_bytes(16);
    $checkoutSession = createCheckoutSessionForCancelBooking($stripe, $pdo, $booking["id"], $challenge);
    if ($checkoutSession) {
        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkoutSession->url);
        $pdo = null;
        die();
    }

    $_SESSION["bookingErrorMsgs"][] = "Failed to initiate payment through stripe";
}

// ===================================================
$isConfirmBooking = $_POST["action"] === "confirm_booking";
$isSaveBooking = $_POST["action"] === "save";
$isCheckBooking = $_POST["action"] === "check_datetime";

$user = getUserById($pdo, $booking["user_id"]);
$experience = getExperienceById($pdo, $booking["experience_id"]);

$participants = intval($_POST["participants"]);
if ($participants < $experience["min_participants"]) $_SESSION["bookingErrorMsgs"][] = "The minimum number of participants is {$experience["min_participants"]}";
else if ($participants > $experience["max_participants"]) $_SESSION["bookingErrorMsgs"][] = "The maximum number of participants is {$experience["max_participants"]}";

$bookingDateTime = DateTime::createFromFormat("Y-m-d H:i", "{$_POST["booking_date"]} {$_POST["booking_time"]}", new DateTimeZone("America/Vancouver"));
$bookingDate = $bookingDateTime->format("Y-m-d");
$now = new DateTime("now", new DateTimeZone("America/Vancouver"));
$bookingsOpenStart = DateTime::createFromFormat("Y-m-d H:i:s", "{$bookingDate} {$experience["bookings_open_start"]}", new DateTimeZone("America/Vancouver"));
$bookingsOpenEnd = DateTime::createFromFormat("Y-m-d H:i:s", "{$bookingDate} {$experience["bookings_open_end"]}", new DateTimeZone("America/Vancouver"));

if (!$bookingDateTime) $_SESSION["bookingErrorMsgs"][] = "Invalid date and time provided";
else if ($now > $bookingDateTime) $_SESSION["bookingErrorMsgs"][] = "Booking date is in the past";
else if (!(intval($experience["bookable_days"]) & $daysBitMask[$bookingDateTime->format("l")])) $_SESSION["bookingErrorMsgs"][] = "Booking date is not supported by the host";
else if (!($bookingDateTime > $bookingsOpenStart && $bookingDateTime < $bookingsOpenEnd)) $_SESSION["bookingErrorMsgs"][] = "Booking time is not supported by the host";
else if (!isTimeAvailableToBook($pdo, $experience["id"], $bookingDateTime)) $_SESSION["bookingErrorMsgs"][] = "Selected booking time has already been booked";

// Everything is valid in here
if (empty($_SESSION["bookingErrorMsgs"])) {
    if ($isCheckBooking) {
        $_SESSION["bookingSuccessMsg"] = "This booking is open!";
        $_SESSION["bookingFormData"] = ["participants" => $participants, "booking_date" => $bookingDateTime->format("Y-m-d"), "booking_time" => $bookingDateTime->format("H:i")];
    }
    if ($isSaveBooking || $isConfirmBooking) {
        $stmt = $pdo->prepare("UPDATE bookings SET participants=:participants, booking_time=:booking_time WHERE id=:id");
        $success = $stmt->execute([":participants" => $participants, ":booking_time" => $bookingDateTime->format("Y-m-d H:i:s"), ":id" => $booking["id"]]);
        if ($success && !$isConfirmBooking) $_SESSION["bookingSuccessMsg"] = "Your booking information has been saved!";
    }
    if ($isConfirmBooking) {
        require_once(__DIR__ . "/../../src/stripe-api.php");
        $challenge = random_bytes(16);
        $checkoutSession = createCheckoutSessionForBooking($stripe, $pdo, $booking["id"], $challenge);
        if ($checkoutSession) {
            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkoutSession->url);
            $pdo = null;
            die();
        }

        $_SESSION["bookingErrorMsgs"][] = "Failed to initiate payment through Stripe";
    }
}


header("Location: ../booking.php?booking_id={$booking["id"]}");
$pdo = null;
die();

function redirectWithError(string $err, string $url = "../index.php")
{
    echo "{$err}<br>Redirecting in 5 seconds...<br><a href=\"{$url}\">Click here if not redirected</a>";
    header("Refresh: 5; URL={$url}");
    die();
}
