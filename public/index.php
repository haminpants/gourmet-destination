<?php
require_once '../src/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination</title>

    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include "../includes/nav-bar.php" ?>
    <h1>Gourmet Destination</h1>
    <div id="search">
    <?php if (!empty($_GET['error'])) echo "<p>Sorry, there's no search results. Please try again.</p>"; ?>
        <form method="POST" action="search-action.php">
        <input list="searchItem" name="searchBar" placeholder="Search by: Pronvinces and States">
            <datalist id="searchItem">
                <option value="AB">Alberta</option>
                <option value="BC">British Columbia</option>
                <option value="MB">Manitoba</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="NS">Nova Scotia</option>
                <option value="ON">Ontario</option>
                <option value="PE">Prince Edward Island</option>
                <option value="QC">Quebec</option>
                <option value="SK">Saskatchewan</option>
                <option value="NT">Northwest Territories</option>
                <option value="NU">Nunavut</option>
                <option value="YT">Yukon</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>

                <?php
                
                //diplays existing users and their roles in the search bar
                    // $stmt = $pdo->prepare("SELECT users.first_name, users.last_name, roles.name
                    //                        FROM users
                    //                        JOIN roles ON users.role_id = roles.id
                    //                        ");
                    // $stmt->execute();

                    // while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //     echo "<option value='" . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "'>"
                    //                 . htmlspecialchars($user['name']) . "</option>";
                                    
                    // }

                    //displays existing experiences
                    $stmt2 = $pdo->prepare("SELECT name, description FROM experiences");
                    $stmt2->execute();

                    while ($experience = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($experience['name']) . "'>"
                                . htmlspecialchars($experience['description']) . "</option>";
                    }
                    
                ?>
            </datalist>
       </form>
    </div>
</body>

</html>