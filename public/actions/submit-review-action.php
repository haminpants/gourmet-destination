<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") redirectWithError("This action only supports POST requests");
if (empty($_POST["action"])) redirectWithError("action is required");
if (empty($_POST["author_id"]) || !is_numeric($_POST["author_id"])) redirectWithError("author_id must be an integer");
if (empty($_POST["target_id"]) || !is_numeric($_POST["target_id"])) redirectWithError("target_id must be an integer");
if (empty($_POST["success_redirect"])) redirectWithError("success_redirect is required");
if (empty($_POST["fail_redirect"])) redirectWithError("fail_redirect is required");
if (empty($_POST["rating"]) || !is_numeric($_POST["rating"])) redirectWithError("rating must be an integer");

$action = $_POST["action"];
$authorId = intval($_POST["author_id"]);
$targetId = intval($_POST["target_id"]);
$successRedirect = $_POST["success_redirect"];
$failRedirect = $_POST["fail_redirect"];
$rating = intval($_POST["rating"]);
$description = $_POST["description"] ?? "";

require_once(__DIR__ . "/../../src/db.php");
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION["reviewErrorMsgs"] = [];

if ($action === "review_host") {
    if (userHasHostReview($pdo, $authorId, $targetId)) {
        $_SESSION["reviewErrorMsgs"][] = "You have already left a review on this profile";
        header("Location: ../{$failRedirect}");
        $pdo = null;
        die();
    }

    addHostReview($pdo, $authorId, $targetId, $rating, $description);
} else if ($action === "review_experience") {
} else redirectWithError("unrecognized action");

header("Location: ../{$successRedirect}");
$pdo = null;
die();

function redirectWithError(string $err, string $url = "../index.php")
{
    echo "{$err}<br>Redirecting in 5 seconds...<br><a href=\"{$url}\">Click here if not redirected</a>";
    header("Refresh: 5; URL={$url}");
    die();
}