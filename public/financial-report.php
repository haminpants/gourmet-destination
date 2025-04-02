<?php
session_start();
if (empty($_SESSION["userData"]["roleId"]) || $_SESSION["userData"]["roleId"] !== 0) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="financial-report">
        <form method="POST" action="actions/financial-report-action.php">
            <button type="submit">Retrieve Report</button>
        </form>
        <br>
        <table>
            <tr>
                <th>TOTAL USERS SUBSCRIBED</th>
                <td><strong>VALUES</strong></td>
            </tr>
            <tr>
                <th class="subheading">Local Guide & Home Chef</th>
                <td><?php echo isset($_SESSION['hostCount']) ? $_SESSION['hostCount'] : 0; ?></td>
            </tr>
            <tr>
                <th class="subheading">Tourist</th>
                <td><?php echo isset($_SESSION['touristCount']) ? $_SESSION['touristCount'] : 0; ?></td>
            </tr>
            <tr>
                <th>SUBSCRIPTION REVENUE</th>
            </tr>
            <tr>
                <th class="subheading">Local Guide & Home Chef Subscription</th>
                <td><?php echo isset($_SESSION['hostTotalRevenue']) ? $_SESSION['hostTotalRevenue'] : 0; ?></td>
            </tr>
            <tr>
                <th class="subheading">Tourist Subscription</th>
                <td><?php echo isset($_SESSION['touristAmount']) ? $_SESSION['touristAmount'] : 0; ?></td>
            </tr>
            <tr>
                <th>BOOKING & COMISSION REVENUE</th>
            </tr>
            <tr>
                <th class="subheading">Total Number of Bookings</th>
                <td><?php echo isset($_SESSION['bookingCount']) ? $_SESSION['bookingCount'] : 0; ?></td>
            </tr>
            <tr>
                <th class="subheading">Total Accumulative Value of Booking</th>
                <td><?php echo isset($_SESSION['bookingAmount']) ? $_SESSION['bookingAmount'] : 0; ?></td>
            </tr>
            <tr>
                <th class="subheading">Commission Rate</th>
                <td>15%</td>
            </tr>
            <tr>
                <th class="subheading">Total Commission Revenue</th>
                <td><?php echo isset($_SESSION['bookingCommission']) ? $_SESSION['bookingCommission'] : 0; ?></td>
            </tr>
            <tr>
                <th>TOTAL REVENUE</th>
                <td><?php echo isset($_SESSION['totalRevenue']) ? $_SESSION['totalRevenue'] : 0; ?></td>
            </tr>
        </table>
    </div>
    <a href="index.php">Back to Home</a>
</body>

</html>