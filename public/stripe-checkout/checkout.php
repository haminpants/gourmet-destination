
<?php
use Stripe\PaymentMethod;
require_once '../../vendor/autoload.php';
require_once 'secrets.php';
session_start();
// $stripe = new \Stripe\StripeClient([
//     "api_key" => "sk_test_51QrrB5GD9MOU8zP2kVhQOpa2GkB7z1pDTqgKFC7qeXorAbptHQ1JcKnf1eLQ53zKlDqV1GjhPX0Q7KsSsyhBYKAp00zLVoYeJZ""sk_test_51QrrB5GD9MOU8zP2kV...SsyhBYKAp00zLVoYeJZ",
//     "stripe_version" => "2025-01-27.acacia; custom_checkout_beta=v1;"
//   ]);
$stripe = new \Stripe\StripeClient([
  $stripeSecretKey,
  "stripe_version" => "2025-01-27.acacia; custom_checkout_beta=v1;"
  ]);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost';

$session = $stripe->checkout->sessions->create([
  
  'line_items' => [[
    'price' => 1999,
    'quantity' => 1,
  ]],
  'mode' => 'subscription',
  'return_url' => $YOUR_DOMAIN . '/return.html?session_id={CHECKOUT_SESSION_ID}',
  'automatic_tax' => [
    'enabled' => true,
  ],
]);
  $_SESSION['checkout_session_url'] = $session->url;
  echo json_encode(array('clientSecret' => $session->client_secret));

  ?>