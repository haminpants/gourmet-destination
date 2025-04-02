<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="financial-report">
        <form method="POST" action="financial-report-action.php">
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
                <td><?php echo $_SESSION['hostCount']?></td>
            </tr>
            <tr>
            <th class="subheading">Tourist</th>
                <td><?php echo $_SESSION['touristCount']?></td>
            </tr>
            <tr></tr>
            <tr>
                <th>SUBSCRIPTION REVENUE</th>
            </tr>
            <tr>
                <th class="subheading">Local Guide & Home Chef Subscription</th>
                <td><?php echo $_SESSION['hostTotalRevenue']?></td>
            </tr>
            <tr>
                <th class="subheading">Tourist Subscription</th>
                <td><?php echo $_SESSION['touristTotalRevenue']?></td>
            </tr> 
            <tr></tr>
            <tr>
                <th>BOOKING & COMISSION REVENUE</th>
            </tr>
            <tr>
                <th class="subheading">Total Number of Bookings</th>
                <td><?php echo $_SESSION['bookingCount']?></td>
            </tr>
            <tr>
                <th class="subheading">Total Accumulative Value of Booking</th>
                <td><?php echo $_SESSION['bookingAmount']?></td>
            </tr>
            <tr>
                <th class="subheading">Commission Rate</th>
                <td>15%</td>
            </tr>
            <tr>
                <th class="subheading">Total Commission Revenue</th>
                <td><?php echo $_SESSION['bookingCommission']?></td>
            </tr>
            <tr></tr>
            <tr>
                <th>TOTAL REVENUE</th>
                <td><?php echo $_SESSION['totalRevenue']?></td>
            </tr>
        </table>
    </div>
</body>
</html>