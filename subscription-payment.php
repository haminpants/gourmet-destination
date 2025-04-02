<?php
require_once '../src/db.php';
require '../vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="public/assets/style.css">
  
</head>
<body class="subscription-page">
    <form method="POST" action="subscription-payment-action.php">
        <div class="subscription-payment">
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