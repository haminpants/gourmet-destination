<?php
require_once "../src/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheets" href="assets/style.css">
</head>
<body>
    <h3 class="review-display-header">User's Review and Ratings</h3><br>
</body>
</html>
<?php
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE user_id = :userID");
$stmt->execute([':userID' => $_GET['id']]);

$userReviews = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($userReviews)) {
    echo "<div class='review-display'>";
    echo "This users has not recieve a review/rating yet.";
    echo "<div>";
} else {
    echo "Displaying reviews";
    echo "<div class='review-display'>";
    echo "<label>Rating: " . htmlspecialchars($userReviews['rating']) . "<label color:'gold'>&#9733;></lable>";
    echo "<label>Description:</label><br>";
    echo "<p>" . htmlspecialchars($userReviews['description']) . "</p>";

}

?>