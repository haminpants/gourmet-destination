<?php
require "../../src/db.php";
session_start();
$_SESSION["signUpMessages"] = [];

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../sign-up.php");
    die();
}

// Get and format form fields
$firstName = trim($_POST["firstName"]);
$lastName = trim($_POST["lastName"]);
$email = trim($_POST["email"]);
$hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Validate form fields
if (empty($firstName)) $_SESSION["signUpMessages"]["firstName"] = ["First name cannot be blank"];
if (empty($lastName)) $_SESSION["signUpMessages"]["lastName"] = ["Last name cannot be blank"];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION["signUpMessages"]["email"] = ["Invalid email provided"];
else if (!emailIsUnique($pdo, $email)) $_SESSION["signUpMessages"]["email"] = ["Email is already in use"];
if (empty($_POST["password"])) $_SESSION["signUpMessages"]["password"] = ["Password cannot be blank"];
else if (strlen($_POST["password"]) < 10) $_SESSION["signUpMessages"]["password"] = ["Password must be at least 10 characters"];
else if ($_POST["password"] !== $_POST["confirmPassword"]) $_SESSION["signUpMessages"]["confirmPassword"] = ["Passwords do not match"];

// If there are no sign up messages, allow the user to sign up
if (empty($_SESSION["signUpMessages"])) {
    $redirect = "index.php";
    $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)");
    $stmt->execute([":email" => $email, ":password" => $hashedPassword, ":first_name" => $firstName, ":last_name" => $lastName]);
} else {
    $redirect = "sign-up.php";
}

header("Location: ../{$redirect}");
$pdo = null;
die();
