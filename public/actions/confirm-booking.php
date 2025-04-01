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
$stmt = $pdo->prepare("UPDATE bookings SET status_id=3 WHERE id=:id");
$stmt->execute([":id" => $userId]);
header("Location: ../booking.php?booking_id={$bookingId}");
die();