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

function getHostReviews(PDO $pdo, int $hostId)
{
    $stmt = $pdo->prepare("SELECT review.rating, review.user_id, user.first_name, user.last_name, review.description, review.created_at 
        FROM host_reviews as hr JOIN reviews AS review ON hr.review_id=review.id JOIN users AS user ON review.user_id=user.id WHERE hr.user_id=:id");
    $stmt->execute([":id" => $hostId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getExperienceReviews(PDO $pdo, int $experienceId) {
    $stmt = $pdo->prepare("SELECT review.rating, review.user_id, user.first_name, user.last_name, review.description, review.created_at 
        FROM experience_reviews as er JOIN reviews AS review ON er.review_id=review.id JOIN users AS user ON review.user_id=user.id WHERE er.experience_id=:id");
    $stmt->execute([":id" => $experienceId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHostReviewStats(PDO $pdo, $hostId)
{
    $stmt = $pdo->prepare("SELECT ROUND(AVG(review.rating), 1) AS average_rating, COUNT(*) AS total_ratings, SUM(IF(review.rating=5, 1, 0)) AS five_star_ratings, 
        SUM(IF(review.rating=4, 1, 0)) AS four_star_ratings, SUM(IF(review.rating=3, 1, 0)) AS three_star_ratings, SUM(IF(review.rating=2, 1, 0)) AS two_star_ratings, 
        SUM(IF(review.rating=1, 1, 0)) AS one_star_ratings 
        FROM host_reviews as hr JOIN reviews AS review ON hr.review_id=review.id WHERE hr.user_id=:id");
    $stmt->execute([":id" => $hostId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getExperienceReviewStats (PDO $pdo, int $experienceId) {
    $stmt = $pdo->prepare("SELECT ROUND(AVG(review.rating), 1) AS average_rating, COUNT(*) AS total_ratings, SUM(IF(review.rating=5, 1, 0)) AS five_star_ratings, 
        SUM(IF(review.rating=4, 1, 0)) AS four_star_ratings, SUM(IF(review.rating=3, 1, 0)) AS three_star_ratings, SUM(IF(review.rating=2, 1, 0)) AS two_star_ratings, 
        SUM(IF(review.rating=1, 1, 0)) AS one_star_ratings 
        FROM experience_reviews as er JOIN reviews AS review ON er.review_id=review.id WHERE er.experience_id=:id");
    $stmt->execute([":id" => $experienceId]);    
}

function getUsersPastCompletedBookings(PDO $pdo, int $userId)
{
    $stmt = $pdo->prepare("SELECT user.id AS user_id, booking.id AS booking_id, booking.experience_id AS experience_id, experience.host_id
        FROM users AS user JOIN bookings AS booking ON user.id=booking.user_id JOIN experiences AS experience ON experience.id=booking.experience_id
        WHERE user.id=:user_id AND booking.status_id=3 AND booking.booking_time < NOW()");
    $stmt->execute([":user_id" => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function canReviewHost(PDO $pdo, int $userId, int $hostId)
{
    $stmt = $pdo->prepare("SELECT experience.host_id FROM users AS user 
        JOIN bookings AS booking ON user.id=booking.user_id JOIN experiences AS experience ON experience.id=booking.experience_id 
        WHERE user.id=:user_id AND booking.status_id=3 AND booking.booking_time < NOW()");
    $stmt->execute(["user_id" => $userId]);
    return in_array($hostId, $stmt->fetchAll(PDO::FETCH_COLUMN, 0));
}

function canReviewExperience(PDO $pdo, $userId, $experienceId)
{
    $stmt = $pdo->prepare("SELECT experience.id FROM users AS user 
        JOIN bookings AS booking ON user.id=booking.user_id  JOIN experiences AS experience ON experience.id=booking.experience_id 
        WHERE user.id=:user_id AND booking.status_id=3 AND booking.booking_time < NOW()");
    $stmt->execute([":user_id" => $userId]);
    return in_array($experienceId, $stmt->fetchAll(PDO::FETCH_COLUMN, 0));
}

function userHasHostReview(PDO $pdo, int $userId, int $hostId)
{
    $stmt = $pdo->prepare("SELECT review.id AS review_id, review.user_id AS author_id, hr.user_id AS host_id
        FROM host_reviews AS hr JOIN reviews AS review ON hr.review_id=review.id WHERE review.user_id=:user_id AND hr.user_id=:host_id");
    $stmt->execute([":user_id" => $userId, ":host_id" => $hostId]);
    return !empty($stmt->fetch());
}

function addHostReview(PDO $pdo, int $userId, int $hostId, int $rating, string $description)
{
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, rating, description) VALUES (:user_id, :rating, :description)");
    if (!$stmt->execute([":user_id" => $userId, ":rating" => $rating, ":description" => $description])) return false;
    $reviewId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO host_reviews (user_id, review_id) VALUES (:user_id, :review_id)");
    return $stmt->execute([":user_id" => $hostId, ":review_id" => $reviewId]);
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
function getAllTagsByType (PDO $pdo, int $typeId) {
    $stmt = $pdo->prepare("SELECT tag.id, tag.name, tag.type_id, tag_type.name AS type_name
        FROM tags AS tag JOIN tag_types AS tag_type ON tag.type_id=tag_type.id WHERE tag_type.id=:id ORDER BY tag.name");
    $stmt->execute([":id" => $typeId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserTags(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("SELECT user_tags.user_id, user_tags.tag_id, tag.name AS tag_name, tag.type_id, tag_type.name AS type_name
        FROM user_tags JOIN tags AS tag ON user_tags.tag_id=tag.id JOIN tag_types AS tag_type ON tag.type_id=tag_type.id
        WHERE user_tags.user_id=:id ORDER BY tag_type.id ASC, tag_name ASC");
    $stmt->execute([":id" => $id]);
    return $stmt->fetchAll();
}

function isTimeAvailableToBook (PDO $pdo, int $experienceId, DateTime $time) {
    $stmt = $pdo->prepare("SELECT b.booking_time FROM bookings AS b JOIN experiences AS e ON b.experience_id=e.id
        WHERE b.experience_id=:experience_id AND b.status_id=3 AND ABS(TIMESTAMPDIFF(MINUTE, b.booking_time, :test)) <= (e.duration * 60)");
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
