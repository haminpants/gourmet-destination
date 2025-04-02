<?php
if (empty($_POST["action"])) redirectShowError("action is required", "profile.php");
if (empty($_POST["user_id"]) || !is_numeric($_POST["user_id"])) redirectShowError("user_id must be an integer value", "profile.php");

require_once(__DIR__ . "/../../src/db.php");
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION["premiumErrorMsgs"] = [];
unset($_SESSION["transactionInfo"]);

$user = getUserById($pdo, intval($_POST["user_id"]));
if (!$user) redirectShowError("user with user_id does not exist", "profile.php");

require_once(__DIR__ . "/../../src/stripe-api.php");

// Get stripe customer
try {
    $customer = $stripe->customers->retrieve($user["stripe_customer_id"]);
} catch (Exception $e) {
    redirectSessionError(["Stripe API failed to fetch customer"], $pdo);
}

if ($_POST["action"] === "subscribe") {
    // Create the price item for the subscription
    $isHost = $user["role_id"] === 2;
    try {
        $stripePrice = $stripe->prices->create([
            "currency" => "cad",
            "recurring" => ["interval" => "month"],
            "unit_amount" => $isHost ? 1999 : 999,
            "product_data" => ["name" => $isHost ? "Host Premium Subscription" : "Tourist Premium Subscription",]
        ]);
    } catch (Exception $e) {
        redirectSessionError(["Stripe API failed to create price"], $pdo);
    }

    // Create the checkout session for the price item
    try {
        $challenge = random_bytes(16);
        $encodedChallenge = urlencode($challenge);
        $stripeCheckout = $stripe->checkout->sessions->create([
            "customer" => $customer->id,
            "line_items" => [
                [
                    "price" => $stripePrice->id,
                    "quantity" => 1,
                ]
            ],
            "mode" => "subscription",
            "metadata" => [
                "subscriptionType" => $isHost ? "Host" : "Tourist",
            ],
            "cancel_url" => "http://localhost/profile.php",
            "success_url" => "http://localhost/actions/confirm-subscription.php?challenge={$encodedChallenge}"
        ]);

        $_SESSION["transactionInfo"] = [
            "userId" => $user["id"],
            "challenge" => $challenge,
            "checkoutId" => $stripeCheckout->id
        ];

        header("HTTP/1.1 303 See Other");
        header("Location: " . $stripeCheckout->url);
        $pdo = null;
        die();
    } catch (Exception $e) {
        redirectSessionError(["Stripe API failed to create checkout", "Price ID {$stripePrice->id}", "Customer ID {$customer->id}", strval($e)]);
    }
} else if ($_POST["action"] === "unsubscribe") {
    if (empty($_POST["subscription_id"])) redirectShowError("subscription_id is required", "profile.php");

    try { $subscription = $stripe->subscriptions->cancel($_POST["subscription_id"]); }
    catch (Exception $e) { redirectSessionError(["Stripe API failed to fetch subscription"]); }

    $stmt = $pdo->prepare("UPDATE users SET stripe_subscription_id=null WHERE id=:id");
    if (!$stmt->execute([":id" => $_POST["user_id"]])) redirectSessionError(["Failed to update database"]);

    header("Location: ../profile.php");
    $pdo = null;
    die();
}

function redirectShowError(string $err, string $url = "index.php")
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
