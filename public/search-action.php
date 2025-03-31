<?php
require_once '../src/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $searchItem = trim($_POST['searchBar']);
    echo $searchItem;

    $stmt = $pdo->prepare("SELECT users.id, users.first_name, users.last_name, users.country_id, users.subdivision_id, roles.name
                            FROM users
                            JOIN roles ON users.role_id = roles.id
                            WHERE users.subdivision_id = :subdivision
                        ");
    
    $stmt->execute([':subdivision' => $searchItem]);

    $_SESSION['searchData'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($_SESSION['searchData'])) {
        $_SESSION['searchError'] = "Sorry, we couldn't find any results. Please try Again.";
        header("Location: index.php?error=invalid_searach");
    } else {
        header("Location: search.php");
    }

}

?>