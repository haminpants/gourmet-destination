<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Guide</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div id="searchPage">
        <button type="button"><a href='index.php'>Back</a></button><br>
        <?php
        //fetches data from query that's stored in a session
            if (isset($_SESSION['searchData']) && (!empty($_SESSION['searchData']))) {
                foreach ($_SESSION['searchData'] as $user) {
                    echo '<div id="searchUsers">';
                    echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : '';
                    echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "<br>";
                    echo htmlspecialchars($user['country_id']) . ", " . htmlspecialchars($user['subdivision_id']) . "<br>";
                    echo htmlspecialchars($user['name']) . "<br>";
                    echo "</div>";
                }
                
            }
        ?>
    </div>
</body>
</html>
