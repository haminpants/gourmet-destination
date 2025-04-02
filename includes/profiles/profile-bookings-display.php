<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION["userData"]["id"]) || $_SESSION["userData"]["id"] != $profileData["id"]) return;

$bookings = getBookingsByUserId($pdo, $profileData["id"]);
$experiences = [];
foreach ($bookings as $booking) $experiences[$booking["id"]] = getExperienceById($pdo, $booking["experience_id"]);
?>

<div class="bookings-display">
    <h2>Recently Viewed Experiences</h2>
    <div class="container">
        <div class="bookings-grid">
            <?php foreach ($bookings as $booking) {
                $experience = $experiences[$booking["id"]];
                $bannerImgPath = __DIR__ . "/../../public/uploads/experience/{$experience["id"]}/banner.png";
                $bannerImg = file_exists($bannerImgPath) ? "uploads/experience/{$experience["id"]}/banner.png" : "assets/default_banner.png"; ?>

                <div class="booking">
                    <div class="banner-img centered-container"><img src="<?php echo $bannerImg ?>" alt=""></div>
                    <div class="body">
                        <h3 class="title"><?php echo htmlspecialchars($experience["title"]) ?></h3>
                        <div>
                            <p><?php echo $booking["status_name"] ?></p>
                        </div>
                        <div class="info-bar">
                            <div class="info-item"><img src="assets/icons/calendar.png" class="icon">
                                <p><?php echo formatDate($booking["booking_time"]) ?></p>
                            </div>
                            <div class="info-item"><img src="assets/icons/clock.png" class="icon">
                                <p><?php echo formatTime($booking["booking_time"]) ?></p>
                            </div>
                            <div class="info-item"><img src="assets/icons/person.png" class="icon">
                                <p><?php echo $booking["participants"] ?></p>
                            </div>
                        </div>
                    </div>
                    <form action="booking.php" class="action-row centered-container">
                        <button name="booking_id" value="<?php echo $booking["id"] ?>">Go To Booking</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
function formatDate(string $dateTime)
{
    $date = new DateTime($dateTime);
    return $date->format("D, M d");
}
function formatTime(string $dateTime)
{
    $time = new DateTime($dateTime);
    return $time->format("g:i A");
}
?>