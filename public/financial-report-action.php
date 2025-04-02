<?php
require_once '../src/db.php';
session_start();

$hostSubscriptionTax = 19.99 * 1.12;
$touristSubscriotionTax = 9.99 * 1.12;

if (empty($_SESSION['hostSub'])) {
    $hostSubscription = 0;
}
// Retrieve local guide & home chef subscription
$stmt = $pdo->prepare("SELECT SUM(amount) as total_amount, COUNT(*) AS total_count
                       FROM transactions 
                       WHERE type = 'subscription' AND amount = :amount");
$stmt->execute([':amount' => $hostSubscriptionTax]);

$hostResults = $stmt->fetch(PDO::FETCH_ASSOC); 

// Handle NULL cases, if no matching rows
$_SESSION['hostAmount'] = ($hostResults['total_amount'] ?? 0) /1.12; 
$_SESSION['hostCount'] = $hostResults['total_count'] ?? 0 ;
$_SESSION['hostTotalRevenue'] =  $_SESSION['hostAmount'] * $_SESSION['hostCount'];


// Retrieve tourist subscription, gross revenue, and count
$stmt2 = $pdo->prepare("SELECT SUM(amount) as total_amount, COUNT(*) AS total_count
                       FROM transactions 
                       WHERE type = 'subscription' AND amount = :amount");

$stmt2->execute([':amount' => $touristSubscriotionTax]);

$touristResults = $stmt->fetch(PDO::FETCH_ASSOC);

// Validate query results for NULL
    $_SESSION['touristAmount'] = ($touristResults['total_amount'] ?? 0) / 1.12;
    $_SESSION['touristCount'] = $touristResults['total_count'] ?? 0;
    $_SESSION['touristTotalRevenue'] = $_SESSION['touristAmount'] * $_SESSION['touristCount'];

// Retrieve total number of bookings, revenue
$stmt3 = $pdo->prepare("SELECT COUNT(*) as total_count, SUM(amount) AS total_amount
                        FROM transactions
                        WHERE type = 'booking'
                        ");
$stmt3->execute();
$bookingResults = $stmt3->fetch(PDO::FETCH_ASSOC);

$_SESSION['bookingAmount'] = ($bookingtResults['total_amount'] ?? 0) / 1.12;
$_SESSION['bookingCount'] = $bookingResults['total_count'] ?? 0;

// fetch the commission calculation for each booking in a seperate loop 
$stmt3->execute();

while ($bookingResults = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    $_SESSION['bookingCommission'] += ($bookingResults['amount'] * 0.15);
}

$_SESSION['totalRevenue'] = $_SESSION['hostTotalRevenue'] + $_SESSION['touristTotalRevenue'] + $_SESSION['bookingCommission'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: financial-report.php");
}

?>





