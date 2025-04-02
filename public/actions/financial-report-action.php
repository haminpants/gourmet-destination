<?php
require_once '../../src/db.php';
session_start();
// session_unset();

$hostSubscriptionTax = 19.99 * 1.12;
$touristSubscriotionTax = 9.99 * 1.12;
$_SESSION['bookingCommission'] = 0;

if (empty($_SESSION['hostSub'])) {
    $hostSubscription = 0;
}
// Retrieve local guide & home chef subscription
$stmt = $pdo->prepare("SELECT SUM(amount) as total_amount, COUNT(*) AS total_count
                       FROM transactions 
                       WHERE type = 'Host Premium Subscription'
                       ");
$stmt->execute();

$hostResults = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle NULL cases, if no matching rows
$_SESSION['hostAmount'] = number_format(($hostResults['total_amount'] ?? 0) / 1.12, 2);
$_SESSION['hostCount'] = $hostResults['total_count'] ?? 0;
$_SESSION['hostTotalRevenue'] =  $_SESSION['hostAmount'] * $_SESSION['hostCount'];

//====
$stmt2 = $pdo->prepare("SELECT COUNT(*) AS total_count, SUM(amount) as total_amount
                       FROM transactions 
                       WHERE type = 'Tourist Premium Subscription'");

$stmt2->execute();

$touristResults = $stmt2->fetch(PDO::FETCH_ASSOC);

// Validate query results for NULL
$_SESSION['touristAmount'] = number_format(($touristResults['total_amount'] ?? 0) / 1.12, 2);
$_SESSION['touristCount'] = $touristResults['total_count'] ?? 0;
$_SESSION['touristTotalRevenue'] = $_SESSION['touristAmount'] * $_SESSION['touristCount'];

//====


// Retrieve total number of bookings, revenue   
$stmt3 = $pdo->prepare("SELECT COUNT(*) as total_count, SUM(amount) AS total_amount
                        FROM transactions
                        WHERE type = 'Experience Booking'
                        ");
$stmt3->execute();
$bookingResults = $stmt3->fetch(PDO::FETCH_ASSOC);

$_SESSION['bookingAmount'] = number_format(($bookingResults['total_amount'] ?? 0) / 1.12, 2);
$_SESSION['bookingCount'] = $bookingResults['total_count'] ?? 0;

$stmt5 = $pdo->prepare("SELECT amount FROM transactions WHERE type = 'Experience Booking'");
$stmt5->execute();
// fetch the commission calculation for each booking in a seperate loop 

while ($bookingAmount = $stmt5->fetch(PDO::FETCH_ASSOC)) {
    $_SESSION['bookingCommission'] += ($bookingAmount['amount'] * 0.15);
}

$_SESSION['totalRevenue'] = $_SESSION['hostTotalRevenue'] + $_SESSION['touristTotalRevenue'] + $_SESSION['bookingCommission'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: ../financial-report.php");
}
