<?php
require "../../src/db.php";
session_start();

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../sign-up.php");
    die();
}

// Get and format form fields
$email = trim($_POST["email"]);
$password = $_POST["password"];

$userData = getUserByEmail($pdo, $email);

// Validate the password with the hashed password
if ($userData && password_verify($password, $userData["password"])) {
    $redirect = "index.php";

    $_SESSION["userData"]["id"] = $user["id"];
    $_SESSION["userData"]["firstName"] = $firstName;
    $_SESSION["userData"]["lastName"] = $lastName;
} else {
    $redirect = "login.php";
    $_SESSION["loginErrorMsgs"] = "Invalid username or password. Please try again.";
}

header("Location: ../{$redirect}");
$pdo = null;
die();
