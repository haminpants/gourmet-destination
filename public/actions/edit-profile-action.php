<?php
require "../../src/db.php";
include "../../src/subdivision-data.php";

session_start();
$_SESSION["editProfileErrorMsgs"] = [];
$_SESSION["editProfileFormData"] = [];

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["action"]) || $_POST["action"] === "cancel") {
    header("Location: ../profile.php");
    die();
}

// Get and format form fields
$firstName = trim($_POST["firstName"]);
$lastName = trim(($_POST["lastName"]));
$countryId = $_POST["country"];
$subdivisionId = $_POST["subdivision"];

// Save form fields that don't need to be validated
$_SESSION["editProfileFormData"]["bio"] = $_POST["bio"];
$_SESSION["editProfileFormData"]["countryId"] = $countryId;

// Validate form fields
if (empty($firstName)) $_SESSION["editProfileErrorMsgs"]["firstName"] = "First name cannot be blank";
else $_SESSION["editProfileFormData"]["firstName"] = $firstName;

if (empty($lastName)) $_SESSION["editProfileErrorMsgs"]["lastName"] = "Last name cannot be blank";
else $_SESSION["editProfileFormData"]["lastName"] = $lastName;

if (!array_key_exists($subdivisionId, $subdivisionData[$countryId])) {
    if ($countryId === "CAN") $_SESSION["editProfileErrorMsgs"]["subdivision"] = "Selected option is not a province";
    else if ($countryId === "USA") $_SESSION["editProfileErrorMsgs"]["subdivision"] = "Selected option is not a state";
} else {
    $_SESSION["editProfileFormData"]["country"] = $countryId;
    $_SESSION["editProfileFormData"]["subdivision"] = $subdivisionId;
}

// TODO: continue working on validating profile picture, if bad picture log error message
// then if no error messages, do the stuff
// if error messages, set session variable