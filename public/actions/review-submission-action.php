<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get the rating values from the form
    $rating = isset($_POST['rating']) ? $_POST['rating'] : null;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : null;

    $charCount = strlen($comment);
    if ($charCount > 255) {
        $_SESSION['error'] = "Your comment has exceed the character limit";
        $_SESSION['word_count'] = $charCount;
        $_SESSION['comment'] = $comment;
        header("Location: ../review-submission.php");
        exit;
    } else {
        session_unset();
    }

    if ($rating || $comment) {
        // Checks if the comment exceeds the character limit
        if (empty($_SESSION['error'])) {
           
            // Insert into reviews table
            $stmt = $pdo->prepare("INSERT INTO reviews (user_id. rating, description, created_at) 
                                    VALUES (:user_id, :rating, :description, NOW());
                                    ");
            $stmt->execute([':user_id' => $_GET('user_id'), ':rating' => $rating, ':description' => $comment]);
            

            header("Location: ../review-submission.php");
            exit;
        }

    }

}


?>