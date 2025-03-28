<!DOCTYPE html>
<html lang="en" class="full-wdith full-height">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Guide - Sign Up</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
session_start();
?>

<body class="full-wdith full-height">
    <div class="centered-container sign-up-form-outer full-wdith full-height">
        <form action="actions/sign-up-action.php" method="POST">
            <div class="sign-up-form-inner">
                <div class="form-title">
                    <h2 class="text-align-center">Sign Up</h2>
                </div>
                <div class="form-msgs">
                    <?php if (!empty($_SESSION["signUpMessages"])) print_r($_SESSION["signUpMessages"]) ?>
                </div>
                <div class="first-name">
                    <input type="text" name="firstName" placeholder="First Name" maxlength="255" required>
                </div>
                <div class="last-name">
                    <input type="text" name="lastName" placeholder="Last Name" maxlength="255" required>
                </div>
                <div class="email">
                    <input type="email" name="email" placeholder="Email" maxlength="255" required>
                </div>
                <div class="password">
                    <input type="password" name="password" placeholder="Password" maxlength="255" required>
                </div>
                <div class="confirm-password">
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" maxlength="255" required>
                </div>
                <div class="policies">
                    <input type="checkbox" name="tac" id="tac" required>
                    <label for="tac">I accept the <a href="">Terms of Service</a> and <a href="">Privacy Policy</a></label>
                </div>
                <div class="submit">
                    <button>Sign Up </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>