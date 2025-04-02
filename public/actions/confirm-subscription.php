<?php
if (empty($_GET["challenge"])) redirectShowError("challenge is required", "profile.php");

if (session_status() === PHP_SESSION_NONE) session_start();
$transactionInfo = $_SESSION["transactionInfo"] ?? [];
unset($_SESSION["transactionInfo"]);
if (empty($transactionInfo) || urldecode($_GET["challenge"]) !== $transactionInfo["challenge"]) redirectShowError("invalid session", "profile.php");

require_once(__DIR__ . "/../../src/stripe-api.php");
try {
    $stripeCheckout = $stripe->checkout->sessions->retrieve($transactionInfo["checkoutId"]);
} catch (Exception $e) {
    redirectSessionError(["Stripe API failed to fetch checkout"]);
}

try {
    $stripeSubscription = $stripe->subscriptions->update($stripeCheckout->subscription, [
        "metadata" => ["subscriptionType" => $stripeCheckout->metadata["subscriptionType"]]
    ]);
} catch (Exception $e) {
    redirectSessionError(["Stripe API failed to update subscription"]);
}

require_once(__DIR__ . "/../../src/db.php");
$stmt = $pdo->prepare("UPDATE users SET stripe_subscription_id=:subscription_id WHERE id=:id");
if (!$stmt->execute([":subscription_id" => $stripeSubscription->id, ":id" => $transactionInfo["userId"]])) redirectSessionError(["Failed to update database"]);

$stmt = $pdo->prepare("INSERT INTO transactions (user_id, amount, type, stripe_checkout_id) VALUES (:id, :amount, :type, :checkout_id)");
$stmt->execute([
    ":id" => $transactionInfo["userId"],
    ":amount" => $stripeCheckout->amount_total / 100,
    ":type" => "{$stripeSubscription->metadata["subscriptionType"]} Premium Subscription",
    ":checkout_id" => $stripeCheckout->id
]);

header("Location: ../profile.php");
$pdo = null;
die();

function redirectShowError(string $err, string $url)
{
    echo "{$err}<br>Redirecting in 5 seconds...<br><a href=\"../{$url}\">Click here if not redirected</a>";
    header("Refresh: 5; URL=\"../{$url}\"");
    die();
}

function redirectSessionError($errorMsgs, PDO $pdo = null)
{
    $_SESSION["premiumErrorMsgs"] = $errorMsgs;
    header("Location: ../profile.php");
    $pdo = null;
    die();
}
