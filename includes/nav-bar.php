<?php
require_once "../src/db.php";

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<nav class="nav-bar">
    <div class="left">
        <a href="index.php">Home</a>
    </div>
    <div class="right">
        <?php if (empty($_SESSION["userData"])) { ?>
            <a href="login.php">Log In</a>
            <a href="sign-up.php">Sign Up</a>
        <?php } else { ?>
            <a href="profile.php">My Profile</a>
        <?php } ?>
    </div>
</nav>
<div class="nav-spacer"></div>