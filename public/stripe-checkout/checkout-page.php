<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Gourmet Destination | Subscription</title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="checkout.js" defer></script>
  </head>
  <body>
    <!-- Display a payment form -->
      <div id="checkout">
        <h2>Subscriptions</h2>
        <div class="button-container">
          <label>Local Guide & Home Chef Subscription</label>
          <a href="https://buy.stripe.com/test_dR69C09ud3As2bu7ss" class="pay-button" target="_blank">Subscribe Now</a><br>
          <label>Tourist Subscription</label>
          <a href="https://buy.stripe.com/test_eVa3dC5dX0ogcQ8aEF"class="pay-button" target="_blank">Subscribe Now</a><br>
          

      </div>
  </body>
</html>
