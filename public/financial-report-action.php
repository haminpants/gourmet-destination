<?php
require_once '../src/db.php';
session_start();

$hostSubscriptionTax = 19.99 * 1.12;
$touristSubscriotionTax = 9.99 * 1.12;

if (empty($_SESSION['hostSub'])) {
    $hostSubscription = 0;
}
// Retrieve local guide & home chef subscription
// $stmt = $pdo->prepare("SELECT * FROM transactions WHERE type = 'subscription' AND amount = :amount");
$stmt = $pdo->prepare("SELECT SUM(amount) as total_amount, COUNT(*) AS total_count
                       FROM transactions 
                       WHERE type = 'subscription' AND amount = :amount");
$stmt->execute([':amount' => $hostSubscriptionTax]);

$hostResults = $stmt->fetch(PDO::FETCH_ASSOC); 

// Handle NULL cases, if no matching rows
$hostGrossRevenue = $hostResults['total_amount'] ?? 0; //gross revenue
$_SESSION['hostCount'] = $hostResults['total_count'] ?? 0 ;
$_SESSION['hostRevenue'] = $hostGrossRevenue / 1.12; //divide by tax rate to get the net income


// while ($_SESSION['hostSub'] = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     echo $hostSubscription += $_SESSION['hostSub']['amount'];
// }

// Retrieve tourist subscription, gross revenue, and count
// $stmt2 = $pdo->prepare("SELECT * FROM transactions WHERE type = 'subscription' AND amount = :amount"); 
// $stmt2->execute(['amount' => $touristSubscriotionTax]);

$stmt2 = $pdo->prepare("WITH filtered_data AS (
                            SELECT amount, type
                            FROM transactions
                            WHERE amount = :amount
                            )
                            SELECT COUNT(*) FROM AS total_count, SUM(amount) AS total_amount
                            FROM filtered_data;");

$stmt2->execute(['amount' => $touristSubscriotionTax]);

$touristResults = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['touristAmount'] = $touristResults['total_amount'];
$_SESSION['touristCount'] = $touristResults['total_amount'];

$touristGrossRevenue = $touristResults['total_amount'] ?? 0; //gross revenue
$_SESSION['touristCount'] = $hostResults['total_count'] ?? 0 ;
$_SESSION['touristRevenue'] = $touristGrossRevenue / 1.12;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    header("Location: financial-report.php");
}

?>






