<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gourmet Destination | Reviews & Rating</title>
    <link rel="stylesheet" href="assets/style.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <style>
        body {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="review">
    <form method= "POST" action="actions/submit-reviews-action.php">
        <p>Thank you for booking through our platform!</p>
        <p>Leave a rating for your host!</p>

        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5"/><label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">&#9733;</label>
        </div><br>
            <label>How was your experience?</label><br>
            <textarea id="comment" name="comment" placeholder="Leave a comment:"></textarea><br>

            <button type="submit">Submit Reviews</button>
    </form>
            

    </div>
</body>
</html>