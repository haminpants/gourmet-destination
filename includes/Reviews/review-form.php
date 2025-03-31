

<link rel="stylesheet" href="assets/style.css">

<section class="review-form-section">
  <h2>Leave a Review</h2>
  <form class="review-form" method="POST" action="#">
    <label for="review-text">Your Experience</label>
    <textarea name="review_text" id="review-text" placeholder="Share your thoughts..."></textarea>

    <label for="rating">Your Rating (1-5)</label>
    <div class="star-rating">
  <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
  <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
  <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
  <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
  <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
</div>

    <label for="tip">Tip (optional)</label>
    <input type="number" name="tip" id="tip" min="0" step="0.01" placeholder="Enter tip amount">

    <button type="submit">Submit Review</button>
  </form>
</section>
