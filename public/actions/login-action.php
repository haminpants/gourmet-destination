<?php
require "../../src/db.php";
session_start();
$_SESSION["loginErrorMsgs"] = [];
$_SESSION["loginFormData"] = [];

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../sign-up.php");
    die();
}

// Get and format form fields
$email = trim($_POST["email"]);
$password = $_POST["password"];

// Validate form fields
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION["loginErrorMsgs"]["email"] = "Invalid email provided";
else $_SESSION["loginFormData"]["email"] = $email;

if (empty($_SESSION["loginErrorMsgs"])) {
    $userData = getUserByEmail($pdo, $email);
    // Validate the password with the hashed password
    if ($userData && password_verify($password, $userData["password"])) {
        $redirect = "index.php";
        unset($_SESSION["loginErrorMsgs"]);
        commitUserDataToSession($userData);
    } else {
        $redirect = "login.php";
        $_SESSION["loginErrorMsgs"]["form"] = "Invalid email or password";
    }
}

header("Location: ../{$redirect}");
$pdo = null;
die();
