<?php
require '../src/db_connect.php';
session_start();

//checks if the account exists
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    echo "testing";
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, password, email, role FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Validate the password with the hashed password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loginSucess'] = true;
        $_SESSION['role'] = $user['role'];
        $_SESSION['userID'] = $user['id'];
        header("Location: index.php");
        exit;
        } else {
            $_SESSION['loginErrorMsg'] = "Invalid username or password. Please try again.";
            header("Location: login.php");
            exit;
        }
    } 




?>