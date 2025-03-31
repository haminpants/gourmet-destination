<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Reviews & Rating</title>
    <link rel="stylesheet" href="assets/style.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
</head>
<body>
    <div class="review" id="review">

    <form method= "POST" action="actions/review-submission-action.php">
    <div class="reviewError">
             <?php
            if (isset($_SESSION['error'])) {
                echo "<label>{$_SESSION['error']}. <br> Current word count: {$_SESSION['word_count']}</label>";
            }
            ?> 
        </div>
        <p>Thank you for booking through our platform!</p>
        <p>Leave a rating for your host!</p>

        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5"/><label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">&#9733;</label>
        </div><br>
            <label>How was your experience? Leave a comment: </label><br>
            <textarea id="comment" name="comment" placeholder="Character Limit: 255 Characters" value="<?php echo htmlspecialchars($_SESSION['comment'])?>"></textarea><br>

            <button type="submit">Submit Reviews</button>
            <button type="button" id="btnCancel" onclick="toggleVisibility()">No Thanks</button>
    </form>
    </div>
    <script>
        function toggleVisibility(){
            var div = document.getElementById('reviews');
            if (div.style.visibility === "visble") {
                div.style.visibility = 'hidden';
            } else {
                div.style.visibility = 'visible';
            }
        }
    </script>
</body>
</html>