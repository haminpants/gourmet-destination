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

    // By this point, we can display the booking, just fetch the remaining necessary data
    $stmt = $pdo->prepare("SELECT * FROM experiences WHERE id=:id");
    $stmt->execute([":id" => $booking["experience_id"]]);
    $experience = $stmt->fetch(PDO::FETCH_ASSOC);

    $host = getUserById($pdo, $experience["host_id"]);
}
// Otherwise, redirect to unknown error
else redirectToError(100, $pdo);
?>

<body class="booking-page">
    <section class="header">

    </section>
    <section class="experience_details">

    </section>
    <section class="booking_details">

    </section>
    <section class="reviews">

    </section>
</body>

</html>

<?php
function redirectToError(int $errorCode, PDO $pdo = null)
{
    header("Location: booking.php?err={$errorCode}");
    $pdo = null;
    die();
}
?>