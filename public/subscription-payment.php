<?php
require_once '../src/db.php';
require '../vendor/autoload.php';

// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
// $stripe = new \Stripe\StripeClient([
//     "api_key" => "sk_test_51QrrB5GD9MOU8zP2kVhQOpa2GkB7z1pDTqgKFC7qeXorAbptHQ1JcKnf1eLQ53zKlDqV1GjhPX0Q7KsSsyhBYKAp00zLVoYeJZ""sk_test_51QrrB5GD9MOU8zP2kV...SsyhBYKAp00zLVoYeJZ",
//     "stripe_version" => "2025-01-27.acacia; custom_checkout_beta=v1;"
//   ]);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
  
</head>
<body>
    <form method="POST" action="subscription-payment-action.php">
        <div class="subscription-paymemt">
            <label for="email">Email</label>
            <input  id="email" name="email" type="email" placeholder="Email Address" required>
        </div>
    
        <h2>Subscriptions</h2>
        <div class="button-container">
            <label>Local Guide & Home Chef Subscription</label>
            <a href="https://buy.stripe.com/test_dR69C09ud3As2bu7ss" class="pay-button" target="_blank">Subscribe Now</a><br>
            <label>Tourist Subscription</label>
            <a href="https://buy.stripe.com/test_eVa3dC5dX0ogcQ8aEF"class="pay-button" target="_blank">Subscribe Now</a><br>
        </div>

          

</body>
</html>