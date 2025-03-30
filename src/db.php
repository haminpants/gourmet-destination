<?php
$dbConfig = parse_ini_file(__DIR__ . "/../config/db_info.ini");
if (!$dbConfig) die("Database config has not been set up :(");

$host = $dbConfig["host"];
$dbName = $dbConfig["db_name"];
$username = $dbConfig["username"];
$password = $dbConfig["password"];

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbName};", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Oops! The database connection failed :(");
}

/** @return bool Returns `true` if an email is not registered in the database, otherwise returns `false` */
function emailIsUnique(PDO $pdo, string $email)
{
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email=:email");
    $stmt->execute([":email" => $email]);
    return empty($stmt->fetch(PDO::FETCH_ASSOC));
}

/** @return mixed Returns an associative array containing all of a user's data for a given email, otherwise returns `false` on failure  */
function getUserByEmail(PDO $pdo, string $email)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute([":email" => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/** @return mixed Returns an associative array containing all of a user's data for a given email, otherwise returns `false` on failure  */
function getUserById(PDO $pdo, int $userId)
{
    $stmt = $pdo->prepare("SELECT user.id, user.email, user.password, user.first_name, user.last_name, user.bio, user.signup_date, 
    user.country_id, country.name AS country_name, user.subdivision_id, subdivision.name AS subdivision_name, user.role_id, role.name AS role_name
    FROM users AS user, roles AS role, countries AS country, subdivisions AS subdivision 
    WHERE user.id=:id AND user.role_id=role.id AND user.country_id=country.id AND user.subdivision_id=subdivision.id");

    $stmt->execute([":id" => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function commitUserDataToSession(array $userData)
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    $err = "Failed to commit user data to session. Missing value: ";
    if (!isset($userData["id"])) die("{$err} id");
    if (!isset($userData["first_name"])) die("{$err} first_name");
    if (!isset($userData["last_name"])) die("{$err} last_name");

    $_SESSION["userData"] = [];
    $_SESSION["userData"]["id"] = $userData["id"];
    $_SESSION["userData"]["firstName"] = $userData["first_name"];
    $_SESSION["userData"]["lastName"] = $userData["last_name"];
    $_SESSION["userData"]["profilePicture"] = $userData["profile_picture"];
}

function getPricingMethods(PDO $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM pricing_methods");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Bookable days encoding and decoding
$bookableDays = [
    "Monday" => 1,
    "Tuesday" => 2,
    "Wednesday" => 4,
    "Thursday" => 8,
    "Friday" => 16,
    "Saturday" => 32,
    "Sunday" => 64
];
