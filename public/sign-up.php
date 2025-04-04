<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destiation | Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
session_start();
if (!isset($_SESSION["signupErrorMsgs"])) $_SESSION["signupErrorMsgs"] = [];
if (!isset($_SESSION["signupFormData"])) $_SESSION["signupFormData"] = [];
?>

<body class="signup-page">
    <div class="centered-container">
        <form action="actions/sign-up-action.php" method="POST" class="sign-up-form">
            <div class="form-title">
                <h2 class="text-align-center">Sign Up</h2>
            </div>
            <div class="form-error-msgs">
                <?php foreach ($_SESSION["signupErrorMsgs"] as $msg) { ?>
                    <p class="error-msg"><?php echo $msg ?></p>
                <?php } ?>
            </div>
            <div class="first-name">
                <input type="text" name="firstName" placeholder="First Name" maxlength="255" required value="<?php if (isset($_SESSION["signupFormData"]["firstName"])) echo htmlspecialchars($_SESSION["signupFormData"]["firstName"]); ?>">
            </div>
            <div class="last-name">
                <input type="text" name="lastName" placeholder="Last Name" maxlength="255" required value="<?php if (isset($_SESSION["signupFormData"]["lastName"])) echo htmlspecialchars($_SESSION["signupFormData"]["lastName"]); ?>">
            </div>
            <div class="email">
                <input type="email" name="email" placeholder="Email" maxlength="255" required value="<?php if (isset($_SESSION["signupFormData"]["email"])) echo htmlspecialchars($_SESSION["signupFormData"]["email"]); ?>">
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
                <button>Sign Up</button>
            </div>
        </form>
    </div>
</body>

</html>