<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
session_start();
unset($_SESSION["loginErrorMsgs"]);
unset($_SESSION["loginFormData"]);
unset($_SESSION["signupErrorMsgs"]);
unset($_SESSION["signupFormData"]);
?>

<body>
    <?php include "../includes/nav-bar.php" ?>
    <h1>Gournmet Destination</h1>
</body>

</html>