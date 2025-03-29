<?php
require_once '../src/db.php';
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $searchItem = trim($_POST['searchBar']);
    echo $searchItem;
    if (str_contains($searchItem, " ")) {
        $word1 = explode(" ", $searchItem);
        echo $word1[0];
    }

    $stmt = $pdo->prepare("SELECT users.first_name, users.last_name, users.country_id, users.subdivision_id,
                                  experiences.name, experiences.description, experiences.min_participants, 
                                  experience.max_participants, roles.name
                            FROM users
                            JOIN experiences ON users.id = experiences.host_id
                            JOIN roles on users.role_id = roles.id
                        ");
    $_SESSION['searchData'] = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($_SESSION['searchData'])) {
        $_SESSION['searchError'] = "Sorry, we couldn't find any results. Please try Again.";
        header("Location: index.php");
    } else {
        header("Location: search.php");
    }

} else {
    $_SESSION['searchError'] = "Please try Again.";
    header("Location: index.php");
}

?>