<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <th>VALUES</th>
            </tr>
            <tr>
                <td>Local Guide & Home Chef</td>
                <td><?php echo $_SESSION['hostCount'];?></td>
            </tr>
            <tr>
                <td>Tourist</td>
                <td><?php echo $_SESSION['touristCount'];?></td>
            </tr>
            <tr></tr>
            <tr>
                <th>REVENUE</th>
                <th></th>
            </tr>

        </table>
    </div>
</body>
</html>