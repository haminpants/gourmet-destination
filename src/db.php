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

/** Returns `true` if an email is not registered in the database, otherwise returns `false` */
function emailIsUnique(PDO $pdo, string $email)
{
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email=:email");
    $stmt->execute([":email" => $email]);
    return empty($stmt->fetch(PDO::FETCH_ASSOC));
}

function getUserByEmail(PDO $pdo, string $email)
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute([":email" => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
