<?php
require "../../src/db.php";
session_start();
$_SESSION["signupErrorMsgs"] = [];
$_SESSION["signupFormData"] = [];

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
if (empty($firstName)) $_SESSION["signupErrorMsgs"]["firstName"] = "First name cannot be blank";
else $_SESSION["signupFormData"]["firstName"] = $firstName;

if (empty($lastName)) $_SESSION["signupErrorMsgs"]["lastName"] = "Last name cannot be blank";
else $_SESSION["signupFormData"]["lastName"] = $lastName;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION["signupErrorMsgs"]["email"] = "Invalid email provided";
else if (!emailIsUnique($pdo, $email)) $_SESSION["signupErrorMsgs"]["email"] = "Email is already in use";
else $_SESSION["signupFormData"]["email"] = $email;

if (empty($password)) $_SESSION["signupErrorMsgs"]["password"] = "Password cannot be blank";
else if (strlen($password) < 10) $_SESSION["signupErrorMsgs"]["password"] = "Password must be at least 10 characters";
else if ($password !== $confirmPassword) $_SESSION["signupErrorMsgs"]["confirmPassword"] = "Passwords do not match";

if (empty($_SESSION["signupErrorMsgs"])) {
    require_once(__DIR__ . "/../../src/stripe-api.php");
    try {
        $customer = $stripe->customers->create(["name" => "{$firstName} {$lastName}", "email" => $email]);
    } catch (Exception $e) {
        $_SESSION["signupErrorMsgs"]["stripe"] = "Failed to create customer in Stripe API";
    }
}

// If there are no sign up messages, allow the user to sign up
if (empty($_SESSION["signupErrorMsgs"])) {
    $redirect = "index.php";
    unset($_SESSION["signupFormData"]);

    $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, stripe_customer_id) VALUES (:email, :password, :first_name, :last_name, :stripe_customer_id)");
    $stmt->execute([":email" => $email, ":password" => password_hash($password, PASSWORD_DEFAULT), ":first_name" => $firstName, ":last_name" => $lastName, 
        ":stripe_customer_id" => $customer["id"]]);

    $userData = getUserByEmail($pdo, $email);
    commitUserDataToSession($userData);
} else {
    $redirect = "sign-up.php";
}

header("Location: ../{$redirect}");
$pdo = null;
die();
