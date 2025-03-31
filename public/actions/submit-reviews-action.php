<?php

if ($_SERVER['REQUSET_METHOD'] === "POST") {
    // Get the rating values from the form
    $rating = isset($_POST['rating']) ? $_POST['rating'] : null;

    if ($rating) {
        $stmt = $pdo->prepare("INSERT INTO ratings")
    }

}


?>