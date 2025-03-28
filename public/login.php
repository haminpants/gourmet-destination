<?php
session_unset();
session_destroy();
session_start();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Login Page</title>
</head>
<body>
    
    <!-- Login Form -->
    <div id="loginForm">
        <p><?php echo $error ?></p>
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