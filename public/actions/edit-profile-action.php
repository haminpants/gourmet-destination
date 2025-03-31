<?php
require "../../src/db.php";
require "../../src/upload-checker.php";
require "../../src/subdivision-data.php";

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
$selectedTags = array_map(fn($tag) => intval($tag), $_POST["tag"] ?? []);

// Save form fields that don't need to be validated
$_SESSION["editProfileFormData"]["bio"] = $_POST["bio"];
$_SESSION["editProfileFormData"]["countryId"] = $countryId;
$_SESSION["editProfileFormData"]["tags"] = $selectedTags;

// Validate form fields
if (empty($firstName)) $_SESSION["editProfileErrorMsgs"]["firstName"] = "First name cannot be blank";
else $_SESSION["editProfileFormData"]["firstName"] = $firstName;

if (empty($lastName)) $_SESSION["editProfileErrorMsgs"]["lastName"] = "Last name cannot be blank";
else $_SESSION["editProfileFormData"]["lastName"] = $lastName;

if ($countryId == 0) $subdivisionId = 0;
if ($countryId != 0 && $subdivisionId != 0 && !array_key_exists($subdivisionId, $subdivisionData[$countryId]["subdivisions"])) {
    if ($countryId === "CAN") $_SESSION["editProfileErrorMsgs"]["subdivision"] = "Selected option is not a province";
    else if ($countryId === "USA") $_SESSION["editProfileErrorMsgs"]["subdivision"] = "Selected option is not a state";
} else {
    $_SESSION["editProfileFormData"]["country_id"] = $countryId;
    $_SESSION["editProfileFormData"]["subdivision_id"] = $subdivisionId;
}

if ($_FILES["profilePicture"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $uploadedImage = uploadIsImage($_FILES["profilePicture"]);
    if (empty($uploadedImage)) $_SESSION["editProfileErrorMsgs"]["profilePicture"] = "Profile picture upload failed (Max 0.5MB)";
    if (empty($_SESSION["editProfileErrorMsgs"])) {
        $uploadDir = __DIR__ . "/../../public/uploads/pfp/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 077, true);
        if (!imagepng($uploadedImage, $uploadDir . "{$_POST["id"]}.png")) $_SESSION["editProfileErrorMsgs"]["profilePicture"] = "Failed to save profile picture. Please try again!";
    }
}

if ($_FILES["backgroundPicture"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $uploadedImage = uploadIsImage($_FILES["backgroundPicture"]);
    if (empty($uploadedImage)) $_SESSION["editProfileErrorMsgs"]["backgroundPicture"] = "Profile picture upload failed (Max 1MB)";
    if (empty($_SESSION["editProfileErrorMsgs"])) {
        $uploadDir = __DIR__ . "/../../public/uploads/profileBackground/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 077, true);
        if (!imagepng($uploadedImage, $uploadDir . "{$_POST["id"]}.png")) $_SESSION["editProfileErrorMsgs"]["backgroundPicture"] = "Failed to save background picture. Please try again!";
    }
}

if (empty($_SESSION["editProfileErrorMsgs"])) {
    unset($_SESSION["editProfileFormData"]);
    unset($_SESSION["profileAction"]);

    $stmt = $pdo->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name, country_id=:country_id, subdivision_id=:subdivision_id, bio=:bio WHERE id=:id");
    $stmt->execute([":first_name" => $firstName, ":last_name" => $lastName, ":country_id" => $countryId, ":subdivision_id" => $subdivisionId, ":bio" => $_POST["bio"], ":id" => $_POST["id"]]);

    // Tags to add are tags that have been selected and are not in the user's profile already
    $existingTags = array_map(fn($tag) => intval($tag["tag_id"]), getUserTags($pdo, $_POST["id"]));

    $tagsToAdd = array_diff($selectedTags, $existingTags);
    $stmt = $pdo->prepare("INSERT INTO user_tags (user_id, tag_id) VALUES (:user_id, :tag_id)");
    foreach ($tagsToAdd as $tag) $stmt->execute([":user_id" => $_POST["id"], ":tag_id" => $tag]);

    $tagsToRemove = array_diff($existingTags, $selectedTags);
    $stmt = $pdo->prepare("DELETE FROM user_tags WHERE user_id=:user_id AND tag_id=:tag_id");
    foreach ($tagsToRemove as $tag) $stmt->execute([":user_id" => $_POST["id"], ":tag_id" => $tag]);
} else $_SESSION["profileAction"] = "editProfile";

header("Location: ../profile.php");
$pdo = null;
die();
