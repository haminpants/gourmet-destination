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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="searchFilter">
        <button type="button" onclick="toggleVisibility()" style="border-style: none;">X</button><br><br>
        <h4>Filter Options</h4>
        <form>
            <!-- Host Roles -->
            <hr>
            <h4>Hosting Offered</h4><br>
            <input type="checkbox" name="role" value="Local Guide">
            <label>Local Guide</label>
            <input type="checkbox" name="role" value="Local Guide">
            <label>Local Home Chef</label>
            
            <!-- Availability Filter -->
            <hr>
            <h4>Availability</h4><br>
            <div>
                <label>Start Date:</label>
                <input type="date" name="startDate" placeholder="YYYY-MM-DD">
                <label>End Date:</label>
                <input type="date" name="endDate" placeholder="YYYY-MM-DD">
                <br><br>
                <?php
                // require '../includes/calendar.php'
                ?>
            </div>
            <br>            
            
            <!-- Ratings Filter -->
            <hr>
            <div>
                <label>Ratings</label> <br>
                <input type="radio" id="4.5+" name="filterRating" value="4.5+">
                <label for="4.5+"><span class="stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i></span>4.5+</label><br>
                <input type="radio" id="4" name="filterRating" value="4+">
                <label for="4+"><span class="stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></span>4</label><br>
                <input type="radio" id="3+" name="filterRating" value="3+">
                <label for="3+"><span class="stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></span>3+</label><br>
                <br>
                <button>Filter Results</button>
            </div>
        </form>
        
    </div>
    <div id="searchPage">
        <!-- <button type="button" style="background-color: none; border-style: none;"><a href='index.php'>Back</a></button><br> -->
        <a href='index.php'> > Back</a><br><br>
        <button type="button" onclick="toggleVisibility()">Filters</button><br>
        <?php
        //fetches data from query that's stored in a session
            if (isset($_SESSION['searchData']) && (!empty($_SESSION['searchData']))) {
                foreach ($_SESSION['searchData'] as $user) {
                    echo '<div id="searchUsers">';
                    echo "<div id='profilePic'>IMAGE</div>";
                    // echo !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : '';
                    echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "<br>";
                    echo htmlspecialchars($user['country_id']) . ", " . htmlspecialchars($user['subdivision_id']) . "<br>";
                    echo htmlspecialchars($user['name']) . "<br>";
                    echo "<button><a href='profile.php?id=" . htmlspecialchars($user['id']) . "'>View</button>";
                    echo "</div>";
                }
                
            }
        ?>
    </div>
    <script>
        function toggleVisibility(){
            var filterWindow = document.getElementById('searchFilter');
            if (filterWindow.style.visibility === 'hidden') {
                filterWindow.style.visibility = 'visible';
            } else {
            filterWindow.style.visibility = 'hidden';
            }
        }

    </script>
</body>
</html>
