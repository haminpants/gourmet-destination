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