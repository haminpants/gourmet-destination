<?php
require "../../src/db.php";
require "../../src/upload-checker.php";

session_start();
$_SESSION["experienceErrorMsgs"] = [];
$_SESSION["experienceFormData"] = [];

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["action"]) || $_POST["action"] === "cancel") {
    header("Location: ../profile.php");
    die();
}

if ($_POST["action"] === "delete" && isset($_POST["experience_id"])) {
    $stmt = $pdo->prepare("DELETE FROM experiences WHERE id=:id");
    $stmt->execute([":id" => $_POST["experience_id"]]);
}

// Get and format form fields
$title = trim($_POST["title"]);
$description = trim($_POST["description"]);
$minParticipants = intval($_POST["min_participants"]);
$maxParticipants = intval($_POST["max_participants"]);
$price = doubleval($_POST["price"]);
$pricingMethod = intval($_POST["pricing_method"]);
$bookableDays = !empty($_POST["bookable_days"]) ? array_reduce($_POST["bookable_days"], fn($c, $i) => $c | intval($i), 0) : 0;
$duration = intval($_POST["duration"]);
$bookingsOpenStart = formatTime($_POST["bookings_open_start"]);
$bookingsOpenEnd = formatTime($_POST["bookings_open_end"]);
$cuisineTagId = $_POST["cuisine_tag_id"] === "null" ? null : intval($_POST["cuisine_tag_id"]);

// Save form fields that don't require validating
$_SESSION["experienceFormData"]["description"] = $description;
$_SESSION["experienceFormData"]["pricing_method"] = $pricingMethod;
$_SESSION["experienceFormData"]["bookable_days"] = $bookableDays;
$_SESSION["experienceFormData"]["cuisine_tag_id"] = $cuisineTagId;

// Validate form data
if (empty($title)) $_SESSION["experienceErrorMsgs"]["title"] = "Title cannot be blank";
else $_SESSION["experienceFormData"]["title"] = $title;

if (empty($minParticipants) || empty($maxParticipants)) $_SESSION["experienceErrorMsgs"]["participants"] = "Minimum and maximum participants cannot be blank";
else if ($minParticipants > $maxParticipants) $_SESSION["experienceErrorMsgs"]["participants"] = "Max participants must be greater than or equal to min. participants";
else {
    $_SESSION["experienceFormData"]["min_participants"] = $minParticipants;
    $_SESSION["experienceFormData"]["max_participants"] = $maxParticipants;
}

if (empty($price)) $_SESSION["experienceErrorMsgs"]["price"] = "Price cannot be blank";
else $_SESSION["experienceFormData"]["price"] = $price;

if (empty($duration)) $_SESSION["experienceErrorMsgs"]["duration"] = "Duration cannot be blank";
else $_SESSION["experienceFormData"]["duration"] = $duration;


if (!$bookingsOpenStart || !$bookingsOpenEnd) $_SESSION["experienceErrorMsgs"]["bookings_open_start"] = "Booking opening and closing times cannot be blank";
else if (strtotime($bookingsOpenStart) >= strtotime($bookingsOpenEnd)) $_SESSION["experienceErrorMsgs"]["bookings_open_start"] = "Booking opening and closing times are not valid";
else {
    $_SESSION["experienceFormData"]["bookings_open_start"] = $bookingsOpenStart;
    $_SESSION["experienceFormData"]["bookings_open_end"] = $bookingsOpenEnd;
}


$fileIsUploaded = $_FILES["banner_img"]["error"] !== UPLOAD_ERR_NO_FILE;
if ($fileIsUploaded) {
    $uploadedImage = uploadIsImage($_FILES["banner_img"]);
    if (empty($uploadedImage)) $_SESSION["experienceErrorMsgs"]["banner_img"] = "Banner image upload failed (Max 2mb)";
}

if (empty($_SESSION["experienceErrorMsgs"])) {
    unset($_SESSION["experienceFormData"]);
    unset($_SESSION["profileAction"]);
    unset($_SESSION["experienceId"]);

    if ($_POST["action"] === "create_experience") {
        $stmt = $pdo->prepare("INSERT INTO experiences 
            (host_id, title, description, min_participants, max_participants, bookable_days, bookings_open_start, bookings_open_end, duration, price, pricing_method_id, cuisine_tag_id)
            VALUES (:host_id, :title, :description, :min_participants, :max_participants, :bookable_days, :bookings_open_start, :bookings_open_end, :duration, :price, :pricing_method_id, :cuisine_tag_id)");
        $stmt->execute(
            [
                ":host_id" => $_POST["id"],
                ":title" => $title,
                ":description" => $description,
                ":min_participants" => $minParticipants,
                ":max_participants" => $maxParticipants,
                ":bookable_days" => $bookableDays,
                ":bookings_open_start" => $bookingsOpenStart,
                ":bookings_open_end" => $bookingsOpenEnd,
                ":duration" => $duration,
                ":price" => $price,
                ":pricing_method_id" => $pricingMethod,
                ":cuisine_tag_id" => $cuisineTagId
            ]
        );
        $experienceId = $pdo->lastInsertId();
    } else if ($_POST["action"] === "edit_experience") {
        $stmt = $pdo->prepare("UPDATE experiences SET title=:title, description=:description, min_participants=:min_participants, max_participants=:max_participants, 
            bookable_days=:bookable_days, bookings_open_start=:bookings_open_start, bookings_open_end=:bookings_open_end, duration=:duration, price=:price, 
            pricing_method_id=:pricing_method_id, cuisine_tag_id=:cuisine_tag_id WHERE id=:id");
        $stmt->execute([
            ":title" => $title,
            ":description" => $description,
            ":min_participants" => $minParticipants,
            ":max_participants" => $maxParticipants,
            ":bookable_days" => $bookableDays,
            ":bookings_open_start" => $bookingsOpenStart,
            ":bookings_open_end" => $bookingsOpenEnd,
            ":duration" => $duration,
            ":price" => $price,
            ":pricing_method_id" => $pricingMethod,
            ":id" => $_POST["experience_id"],
            "cuisine_tag_id" => $cuisineTagId
        ]);
        $experienceId = $_POST["experience_id"];
    }

    if ($fileIsUploaded) {
        $uploadDir = __DIR__ . "/../../public/uploads/experience/{$experienceId}/";
        if (!file_exists($uploadDir)) mkdir($uploadDir, 077, true);
        if (!imagepng($uploadedImage, "{$uploadDir}banner.png")) $_SESSION["experienceErrorMsgs"]["banner_img"] = "Failed to save banner image. Please try again!";
    }
} else {
    $_SESSION["profileAction"] = "manage_experience";
    if (isset($_POST["experience_id"])) $_SESSION["experienceId"] = $_POST["experience_id"];
}

$targetSelector = isset($_SESSION["experienceErrorMsgs"]) ? "#focus-form" : "";
header("Location: ../profile.php{$targetSelector}");
$pdo = null;
die();

function formatTime($time)
{
    if (empty($time)) return false;
    $tempTime = new DateTime($time);
    return $tempTime->format("H:i:s");
}