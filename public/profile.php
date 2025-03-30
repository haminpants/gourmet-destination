<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Profile</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<?php
session_start();
require "../src/db.php";

if (isset($_GET["id"]) && is_numeric($_GET["id"])) $profileData = getUserById($pdo, intval($_GET["id"]));
else if (isset($_SESSION["userData"])) $profileData = getUserById($pdo, $_SESSION["userData"]["id"]);
else header("Location: login.php");

if (!empty($profileData)) {
    include "../includes/nav-bar.php";
    include "../includes/profiles/profile-banner.php";
    include "../includes/profiles/profile-edit.php";
    include "../includes/profiles/profile-experience-display.php";
    include "../includes/experiences/experience-info-form.php";
} else include "../includes/profiles/no-profile-found.php";
?>
</html>