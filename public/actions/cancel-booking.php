<?php
session_start();

$challenge = isset($_GET["challenge"]) ? urldecode($_GET["challenge"]) : false;
$bookingId = $_GET["bookingId"] ?? false;
$userId = $_GET["userId"] ?? false;
$transactionInfo = $_SESSION["transactionInfo"] ?? false;
unset($_SESSION["transactionInfo"]);

if (
    !$challenge || !$bookingId || !$userId || !$transactionInfo ||
    ($challenge === $transactionInfo["challenge"] && $bookingId === $transactionInfo["bookingId"] && $userId === $transactionInfo["userId"])
) {
    header("Location: ../index.php");
    die();
}

require_once("../../src/db.php");
$stmt = $pdo->prepare("DELETE FROM bookings WHERE id=:id");
$stmt->execute([":id" => $bookingId]);

$stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, type, stripe_checkout_id) VALUES (:user_id, :amount, :type, :stripe_checkout_id)");
$stmt->execute([
    ":user_id" => $userId,
    ":amount" => $transactionInfo["totalAmount"] / 100,
    ":type" => "Cancel Booking",
    ":stripe_checkout_id" => $transactionInfo["checkoutId"]
]);

header("Location: ../profile.php");
die();
