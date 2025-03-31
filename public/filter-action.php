<?php
session_start();
if ($_SESSION['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['filterRating'])) {
        $stmt = $pdo->prepare("SELECT users.id, users.first_name, users.last_name, users.country_id, users.subdivision_id, 
                                      roles.name, reviews.rating
                               FROM users
                               JOIN roles ON users.role_id = roles.id
                               JOIN reviews ON reviews.user_id = users.id 
                               WHERE reviews.rating <= :rating
    ");
    $stmt->execute([
        ':rating' => $_POST['filterRating']
    ]);

    $_SESSION['filterRating'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        
    }
}
?>