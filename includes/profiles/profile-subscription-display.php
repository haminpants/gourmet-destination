<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION["userData"]["id"]) || $_SESSION["userData"]["id"] !== $profileData["id"]) return;

$errorMsgs = $_SESSION["premiumErrorMsgs"] ?? [];
unset($_SESSION["premiumErrorMsgs"]);

require_once(__DIR__ . "/../../src/db.php");
require_once(__DIR__ . "/../../src/stripe-api.php");

$user = getUserById($pdo, $_SESSION["userData"]["id"]);
if (!empty($user["stripe_subscription_id"])) {
    try {
        $subscription = $stripe->subscriptions->retrieve($user["stripe_subscription_id"]);
    } catch (Exception $e) {
        $erroprMsgs[] = "Stripe API failed to fetch subscription data";
    }
}
$subscription ??= false;
if ($subscription) {
    $subscriptionStatus = $subscription->status;
    $subscriptionType = $subscription->metadata["subscriptionType"];
}
?>

<div class="centered-container">
    <div class="premium-subscription">
        <h2>Premium Subscription Management</h2>

        <?php foreach ($errorMsgs as $msg) { ?>
            <p class="error-msg"><?php echo $msg ?></p>
        <?php } ?>

        <?php if ($subscription && $subscriptionStatus === "active") { ?>
            <p>You're subscribed! Enjoy the benefits~!</p>
            <form action="actions/premium-subscription-action.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user["id"] ?>">
                <input type="hidden" name="subscription_id" value="<?php echo $subscription->id ?>">
                <button name="action" value="unsubscribe">Unsubscribe</button>
            </form>
        <?php } else if (!$subscription) { ?>
            <p>Elevate your experience on GourmetDestination with a premium subscription! Gain access to exclusive experiences and discounts!</p>
            <form action="actions/premium-subscription-action.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user["id"] ?>">
                <button name="action" value="subscribe">Subscribe Now</button>
            </form>
        <?php } ?>
    </div>
</div>