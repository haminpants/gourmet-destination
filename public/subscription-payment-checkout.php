<?php

use Stripe\PaymentMethod;

require_once '../vendor/autoload.php';
require_once 'config.php';
require_once '../vendor/stripe/stripe-php/lib';

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242';

$checkout_session = $stripe->checkout->sessions->create([
    'line_items' => [
      [
        'price_data' => [
          'currency' => 'cad',
          'product_data' => ['name' => 'Local Guide & Home Chef Subscription'],
          'unit_amount' => 1999,
        ],
        'quantity' => 1,
      ],
    ],
    'mode' => 'subscription',
    'ui_mode' => 'custom',
    'success_url' => 'https:localhost/GourmetGuide/public/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'https:localhost/GourmetGuide/public/cancel.php',
  ]);
  echo json_encode(array('clientSecret' => $checkout_session->client_secret));