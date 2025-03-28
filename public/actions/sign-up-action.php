<?php
require "../../src/db.php";
session_start();
$_SESSION["errorMsgs"] = [];
$_SESSION["validFormData"] = [];

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../sign-up.php");
    die();
}

// Get and format form fields
$firstName = trim($_POST["firstName"]);
$lastName = trim($_POST["lastName"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

// Validate form fields
if (empty($firstName)) $_SESSION["errorMsgs"]["firstName"] = "First name cannot be blank";
else $_SESSION["validFormData"]["firstName"] = $firstName;

if (empty($lastName)) $_SESSION["errorMsgs"]["lastName"] = "Last name cannot be blank";
else $_SESSION["validFormData"]["lastName"] = $lastName;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION["errorMsgs"]["email"] = "Invalid email provided";
else if (!emailIsUnique($pdo, $email)) $_SESSION["errorMsgs"]["email"] = "Email is already in use";
else $_SESSION["validFormData"]["email"] = $email;

if (empty($password)) $_SESSION["errorMsgs"]["password"] = "Password cannot be blank";
else if (strlen($password) < 10) $_SESSION["errorMsgs"]["password"] = "Password must be at least 10 characters";
else if ($password !== $confirmPassword) $_SESSION["errorMsgs"]["confirmPassword"] = "Passwords do not match";

// If there are no sign up messages, allow the user to sign up
if (empty($_SESSION["errorMsgs"])) {
    $redirect = "index.php";
    unset($_SESSION["validFormData"]);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)");
    $stmt->execute([":email" => $email, ":password" => password_hash($password, PASSWORD_DEFAULT), ":first_name" => $firstName, ":last_name" => $lastName]);
} else {
    $redirect = "sign-up.php";
}

header("Location: ../{$redirect}");
$pdo = null;
die();
