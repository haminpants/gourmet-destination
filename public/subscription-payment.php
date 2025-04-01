<!-- <?php
require_once '../src/db.php';

//fetch roles and pricing for subscription from DB
// $stmt = $pdo->prepare("SELECT user.role_id, ")

require '../vendor/autoload.php';
// Stripe\Stripe::setApiKey('sk_test_51QrrBG4MkqdKTMhEtiDrqFfBXfBt3EMKqN34r5dopIPrgXzNq2QrM0FppS9dKZuPAYYjs7zP5nbVovF7gWcrs5rn00lUYOWFY5');
// // echo "stripe sucess";
// $session = \Stripe\Checkout\Session::create([
//     'payment_method_types' => ['card'],
//     'line_items' => array_map(function())
// ]);


?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Subscription Page</title>
</head>
<body>
    <form method="POST" action="subscription-payment-action.php">
        <div class="subscription-paymemt">
            <label for="email">Email</label>
            <input  id="email" name="email" type="email" placeholder="Email Address" required>
        </div>
            <!-- <script async
                src="https://js.stripe.com/v3/buy-button.js">
            </script>

            <stripe-buy-button
                buy-button-id="buy_btn_1R90564MkqdKTMhEX3za696r"
                publishable-key="pk_test_51QrrBG4MkqdKTMhEyW1yGDUdNCcvNjoijFgK23X164oPHHdEVNYwpXbDtHoAZV0SZJrJ19vQGypkfnFsL0s2xCkX00bD2g4UYl"
                
            >
            </stripe-buy-button> -->

        <?php



            $checkout_session = $stripe->checkout->sessions->create([
            'ui_mode' => 'embedded',
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => 'price_1R8zWo4MkqdKTMhEuCaif2iR',
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'return_url' =>  'success.php/return.html?session_id={CHECKOUT_SESSION_ID}',
            'automatic_tax' => [
                'enabled' => true,
            ],
            ]);

        ?>

        </div>
    </form>

</body>
</html>