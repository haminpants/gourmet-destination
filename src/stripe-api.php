<?php
$apiConfig = parse_ini_file(__DIR__ . "/../config/api_keys.ini");
if (!$apiConfig || empty($apiConfig["stripeSecretKey"])) die("API config has not been set up :(");

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/db.php");
$stripe = new \Stripe\StripeClient($apiConfig["stripeSecretKey"]);

function createCheckoutSessionForBooking(\Stripe\StripeClient $stripe, PDO $pdo, int $bookingId, string $challenge)
{
    $booking = getBookingById($pdo, $bookingId);
    if (!$booking) return false;

    $experience = getExperienceById($pdo, $booking["experience_id"]);
    if (!$experience) return false;

    $priceCents = $experience["price"] * 100;
    switch ($experience["pricing_method_id"]) {
        case 0:
            $quantity = $booking["participants"];
            break;
        case 1:
            $quantity = 1;
            break;
        default:
            return false;
    }

    $urlEncodedChallenge = urlencode($challenge);
    return $stripe->checkout->sessions->create([
        "line_items" => [[
            "price_data" => [
                "currency" => "cad",
                "product_data" => [
                    "name" => "GourmetDestination Experience Booking"
                ],
                "unit_amount" => $priceCents
            ],
            "quantity" => $quantity,
        ]],
        "mode" => "payment",
        "success_url" => "http://localhost/actions/confirm-booking.php?challenge={$urlEncodedChallenge}&bookingId={$booking["id"]}&userId={$booking["user_id"]}",
        "cancel_url" => "http://localhost/booking.php?booking_id={$booking["id"]}"
    ]);
}
