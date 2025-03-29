<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Login Page</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
session_start();
if (!isset($_SESSION["loginErrorMsgs"])) $_SESSION["loginErrorMsgs"] = [];
if (!isset($_SESSION["loginFormData"])) $_SESSION["loginFormData"] = [];
?>

<body class="login-page">
    <div class="login-form">
        <?php foreach ($_SESSION["loginErrorMsgs"] as $msg) { ?>
            <p class="error-msg"><?php echo $msg ?></p>
        <?php } ?>
        <form action="actions/login-action.php" method="POST">
            <label>Email</label><br>
            <input type="email" placeholder="Email" name="email"> <br>
            <label>Password</label><br>
            <input type="password" placeholder="Password" name="password"> <br>
            <button type="submit" placeholder="Password">Login</button>
            <p>Don't have an account? <a href="sign-up.php">Sign Up</a></p>
        </form>
    </div>
</body>

</html>