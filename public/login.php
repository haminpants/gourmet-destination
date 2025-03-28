<?php
session_start();
echo !empty($_SESSION['errorMessage']) ? htmlspecialchars($_SESSION['errorMessage']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Login Page</title>
    <link rel="stylesheet" href="assets/login.css">
</head>
<body>

    <div id="loginForm">
        <form method="POST" action="login-action.php">
            <label>Email</label><br>
            <input type="email" placeholder="Email" name="email"> <br>
            <label>Password</label><br>
            <input type="password" placeholder="Password" name="password"> <br>
            <button type="submit" placeholder="Password">Login</button>
            <p>Don't have an account? <a href="signup.php">Register</a></p>
        </form>
    </div>
    
</body>
</html>