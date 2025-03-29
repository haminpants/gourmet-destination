<?php
require "../../src/db.php";

session_start();

// Validate that the script is called from a POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["action"]) || $_POST["action"] === "cancel") {
    header("Location: ../profile.php");
    die();
}

