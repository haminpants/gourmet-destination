<?php

if ($_SERVER['REQUSET_METHOD'] === "POST") {
    // Get the rating values from the form
    $rating = isset($_POST['rating']) ? $_POST['rating'] : null;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : null;

    if ($rating || $comment) {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id. rating, description, created_at) 
                                VALUES (:user_id, :rating, :description, NOW());
                                ");
        $stmt->execue([':user_id' => $_GET('user_id'), ':rating' => $rating, ':description' => $comment]);
    }

}


?>