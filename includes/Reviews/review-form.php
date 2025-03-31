


<section class="review-form-section">
  <h2>Leave a Review</h2>
  <form class="review-form" method="POST" action="#">
    <label for="review-text">Your Experience</label>
    <textarea name="review_text" id="review-text" placeholder="Share your thoughts..."></textarea>

    <label for="rating">Your Rating (1-5)</label>
    <div class="star-rating">
      ★ ★ ★ ★ ★
    </div>

    <label for="tip">Tip (optional)</label>
    <input type="number" name="tip" id="tip" min="0" step="0.01" placeholder="Enter tip amount">

    <button type="submit">Submit Review</button>
  </form>
</section>
