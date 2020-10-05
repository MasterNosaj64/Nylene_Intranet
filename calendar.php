<?php
/*
 * FileName: calendar.php
 * Version Number: 1.1
 * Author: Ahmad Syed
 * Purpose:
 *  shows calendar for the user to navigate
 */


// Setting the timezone of location
date_default_timezone_set('America/Toronto');

// this gets the previous and next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // this gets the current month
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');  // the first day of the month
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today Tab: (Format:yyyy-mm-dd)
$today = date('Y-m-j', time());

// Title (Format: MM, YYYY)
$title = date('F, Y', $timestamp);

//this gets the link of the previous and next month respectivly
$previous_month = date('Y-m', strtotime('-1 month', $timestamp));
$next_month = date('Y-m', strtotime('+1 month', $timestamp));

// gets the count of days 
$day_count = date('t', $timestamp);

//Sets the order (Sunday = 0)
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

//create blank days for calendar
$weeks = array();
$week = '';

$week .= str_repeat('<td></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
    $date = $ym . '-' . $day;
    
    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';
    
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {
        
        if ($day == $day_count) {
            // Add empty cell for formatting purposes
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }
        
        $weeks[] = '<tr>' . $week . '</tr>';
        
        $week = '';
    }
    
}
?>

<html lang="en">

<head>
    <title>NyleneCalendar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      
        .list-inline {
            text-align: center;
        }
        .title {
            font-weight: bold;
            font-size: 26px;
        }
        th {
            text-align: center;
        }
        td {
            height: 100px;
            width: 50px;
        }
      
        .today {
            background-color: lavenderblush;
        }
        
    </style>
</head>
<body>

    <div class="container">
        <ul class="list-inline">
                        <li class="list-inline-item"><a href="?ym=<?= $previous_month; ?>" class="btn btn-link">&lt; prev</a></li>
            <li class="list-inline-item"><span class="title"><?= $title; ?></span></li>
            <li class="list-inline-item"><a href="?ym=<?= $next_month; ?>" class="btn btn-link">next &gt;</a></li>
            <li class="text-right"><a href="../Home/Homepage.php">Today</a> </li>
            
        </ul>
       
        <table class="table table-bordered">
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
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>