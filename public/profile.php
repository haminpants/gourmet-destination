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

// Validate that this page was navigated to by a GET request
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("index.php");
    die();
}

if (isset($_GET["id"]) && is_numeric($_GET["id"])) $profileData = getUserById($pdo, intval($_GET["id"]));
else if (isset($_SESSION["userData"])) $profileData = getUserById($pdo, $_SESSION["userData"]["id"]);

if (isset($profileData)) {
    include "../includes/nav-bar.php";

    if ($profileData["role_id"] === 1) include "../includes/profiles/tourist.php";
    else if ($profileData["role_id"] === 2) include "../includes/profiles/host.php";
} else include "../includes/profiles/no-profile-found.php";
?>

</html>