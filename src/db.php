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
    $stmt = $pdo->prepare("SELECT user.id, user.email, user.password, user.first_name, user.last_name, user.bio, 
        user.country_id, country.name AS country_name, user.subdivision_id, subdivision.name AS subdivision_name, 
        user.role_id, role.name AS role_name, user.signup_date
        FROM users AS user
        JOIN roles AS role ON user.role_id=role.id
        JOIN countries AS country ON user.country_id=country.id
        JOIN subdivisions AS subdivision ON user.subdivision_id=subdivision.id AND subdivision.country_id=country.id
        WHERE user.id=:id");

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

function getExperiencesByUserId(PDO $pdo, $id)
{
    if (empty(getUserById($pdo, $id))) return [];
    $stmt = $pdo->prepare("SELECT e.id, e.title, e.description, e.min_participants, e.max_participants, e.bookable_days, e.bookings_open_start, e.bookings_open_end, e.duration, e.price, e.pricing_method_id, p.name AS pricing_method_name, p.description AS pricing_method_description
    FROM experiences AS e, pricing_methods AS p WHERE e.host_id=:id AND e.pricing_method_id=p.id");
    $stmt->execute([":id" => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getExperienceById(PDO $pdo, $id)
{
    $stmt = $pdo->prepare("SELECT e.id, e.title, e.description, e.host_id, e.min_participants, e.max_participants, e.bookable_days, e.bookings_open_start, e.bookings_open_end, e.duration, e.price, e.pricing_method_id, p.name AS pricing_method_name, p.description AS pricing_method_desc
    FROM experiences AS e, pricing_methods AS p WHERE e.id=:id AND e.pricing_method_id=p.id");
    $stmt->execute([":id" => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getBookingById(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("SELECT booking.id, booking.created_at, booking.user_id, booking.experience_id, booking.status_id, bs.status AS status_name, 
        booking.participants, booking.booking_time FROM bookings AS booking JOIN booking_status AS bs ON booking.status_id=bs.id WHERE booking.id=:id");
    $stmt->execute([":id" => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getBookingsByUserId(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("SELECT booking.id, booking.created_at, booking.user_id, booking.experience_id, booking.status_id, bs.status AS status_name, 
        booking.participants, booking.booking_time FROM bookings AS booking JOIN booking_status AS bs ON booking.status_id=bs.id WHERE booking.user_id=:id 
        ORDER BY booking.created_at DESC");
    $stmt->execute([":id" => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isTimeAvailableToBook (PDO $pdo, int $experienceId, DateTime $time) {
    $stmt = $pdo->prepare("SELECT b.booking_time FROM bookings AS b JOIN experiences AS e ON b.experience_id=e.id
        WHERE b.experience_id=:experience_id AND b.status_id=3 AND ABS(TIMESTAMPDIFF(MINUTE, b.booking_time, :test)) <= 240");
    $stmt->execute([":experience_id" => $experienceId, ":test" => $time->format("Y-m-d H:i:s")]);
    return empty($stmt->fetch());
}

// Bookable days encoding and decoding
$daysBitMask = [
    "Monday" => 1,
    "Tuesday" => 2,
    "Wednesday" => 4,
    "Thursday" => 8,
    "Friday" => 16,
    "Saturday" => 32,
    "Sunday" => 64
];
