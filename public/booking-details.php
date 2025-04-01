<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Experience</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdfaf6;
      color: #333;
    }

    .header {
      background-color: #f0dfb2;
      padding: 30px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header .info {
      display: flex;
      flex-direction: column;
    }

    .header .info span {
      font-size: 13px;
      color: #666;
    }

    .header h1 {
      margin: 0;
      font-size: 22px;
    }

    .header button {
      background-color: black;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .section {
      padding: 40px 60px;
    }

    .section h2 {
      margin-bottom: 10px;
      font-size: 22px;
    }

    .booking-form input, .booking-form select {
      width: 100%;
      padding: 10px;
      margin-top: 8px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .booking-form label {
      font-weight: 500;
    }

    .booking-form button {
      background-color: black;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .booking-layout {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 40px;
    }

    .review-box {
      background-color: #f6f6f6;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 15px;
    }

    .cancel-section {
      background-color: #fff8f6;
      border: 1px solid #f5c0c0;
      padding: 20px;
      border-radius: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 30px;
    }

    .cancel-section button {
      background-color: #c92222;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .footer {
      margin-top: 60px;
      padding: 40px;
      background-color: #eee;
      text-align: center;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

  <div class="header">
    <div class="info">
      <h1>Book Your Experience</h1>
      <span>Local Guide · Home Chef</span>
      <span>Select a date and book your guide or chef</span>
    </div>
    <button>Book Now</button>
  </div>

  <div class="section">
    <h2>Booking Details</h2>
    <p>Please fill in the required information</p>
    <div class="booking-layout">
      <form class="booking-form">
        <label for="name">Name</label>
        <input type="text" id="name" placeholder="Enter your name">

        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email">

        <label for="date">Date</label>
        <input type="date" id="date">

        <label for="time">Time</label>
        <input type="time" id="time">

        <button type="button">Confirm Booking</button>
      </form>

      <div class="reviews">
        <h2>Customer Reviews</h2>
        <div class="review-box">
          <strong>Julia</strong>
          <p>Amazing experience, highly recommended!</p>
        </div>
        <div class="review-box">
          <strong>Mike</strong>
          <p>The chef was fantastic; will book again.</p>
        </div>
      </div>
    </div>

    <div class="cancel-section">
      <div>
        <h3>Cancellation Policy</h3>
        <p>Cancellation fee may apply</p>
      </div>
      <button>Cancel Booking</button>
    </div>
  </div>

  <div class="footer">
    Experience local cuisine and culture with our guides and chefs.
  </div>

</body>
</html>
