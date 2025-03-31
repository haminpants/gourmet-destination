<?php
// Get the current month and year, or use the one provided by the user via URL
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Calculate the first day of the month
$firstDay = mktime(0, 0, 0, $month, 1, $year);

// Get the name of the month and the number of days in the month
$monthName = date('F', $firstDay); // Gets the full name of the month (e.g., "March")
$days_in_month = date('t', $firstDay); // Gets the number of days in the month

// Get the day of the week for the first day of the month (0=Sunday, 1=Monday, etc.)
$first_day_weekday = date('w', $firstDay);

// Prepare the next and previous month links
$prevMonth = ($month == 1) ? 12 : $month - 1;
$prevYear = ($month == 1) ? $year - 1 : $year;

$nextMonth = ($month == 12) ? 1 : $month + 1;
$nextYear = ($month == 12) ? $year + 1 : $year;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        table {
            border: 3px solid black;
            border-color: lightgray;
            border-collapse: collapse;
        }
        #calendarDisplay a {
            color: gray;
            text-decoration: none;
            text-align: center;
        }
        #calendarDisplay span {
            display: flex;
            justify-content: center;
        }
        #calendar {
            display: flex;
            justify-content: center;
        }
        
    </style>

</head>
<body>
    <div>
        <div id="calendarDisplay">
            <!-- Display the Previous link, but only allow going back if the month is not the current month -->
            
            <span>
                <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" 
                <?php if ($year == date('Y') && $month == date('m')) echo 'style="visibility:hidden;"'; ?>><strong><</strong></a>
                
                <span><?= $monthName ?> <?= $year ?></span>
                
                <!-- Display the Next link -->
                
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>"><strong>></strong></a>
        </span>
        </div>

        <div id="calendar">
            <table border="1">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Start the first row of the calendar (based on the day of the week the month starts)
                    $current_day = 1;

                    // Adjust the first day of the month to start the table correctly
                    for ($i = 0; $i < 6; $i++) {
                        echo '<tr>';
                        for ($j = 0; $j < 7; $j++) {
                            // If we're on the first row, fill empty cells before the first day
                            if ($i == 0 && $j < $first_day_weekday) {
                                echo '<td></td>';
                            } else {
                                // If there are still days in the month, print the day number
                                if ($current_day <= $days_in_month) {
                                    echo "<td>$current_day</td>";
                                    $current_day++;
                                } else {
                                    // Otherwise, print empty cells after the last day
                                    echo '<td></td>';
                                }
                            }
                        }
                        echo '</tr>';
                        if ($current_day > $days_in_month) {
                            break;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
