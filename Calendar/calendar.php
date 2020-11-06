<?php
/*
 * FileName: calendar.php
 * Version Number: 1.2
 * Author: Ahmad Syed
 * Purpose:
 * shows calendar for the user to navigate
 * populates events when added to
 */

include '../Database/connect.php';
// Setting the timezone of location
date_default_timezone_set('America/Toronto');
error_reporting(0);
$BASE_URL = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/Nylene_Intranet/';
define('BASE_URL', $BASE_URL);

// this gets the previous and next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // this gets the current month
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01'); // the first day of the month
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today Tab: (Format:yyyy-mm-dd)
$today = date('Y-m-j', time());

// Title (Format: MM, YYYY)
$title = date('F, Y', $timestamp);

// this gets the link of the previous and next month respectivly
$previous_month = date('Y-m', strtotime('-1 month', $timestamp));
$next_month = date('Y-m', strtotime('+1 month', $timestamp));

// gets the count of days
$day_count = date('t', $timestamp);

// Sets the order (Sunday = 0)
// $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// sets order in calendar (Monday = 0)
$str = date('N', $timestamp);

// create blank days for calendar
$weeks = array();
$week = '';

$week .= str_repeat('<td></td>', $str - 1);
$_SESSION['userid'] =1;
for ($day = 1; $day <= $day_count; $day ++, $str ++) {
    
    $date = $ym . '-' . $day;
    
    //Adding calendar event into 
    $event_nameStr ='';
    $eventResultStr = '"No"';
    $dateStr =  "'".$date."'";
    $eventInformation = "SELECT * FROM calendar WHERE event_date = " . $dateStr." AND employee_id = " . $_SESSION['userid'];
    $result = $conn->query($eventInformation);
    $eventResult = array();
    while($row = mysqli_fetch_assoc($result))
    {
        $eventResult[] = $row;
    }
    // echo "<pre>";print_r($eventResult);
    if (!empty($eventResult)) {
        $eventResultStr = json_encode($eventResult);
        //$eventResultStr =  "'".$eventResultStr1."'";
        $event_namesArr = array_column($eventResult, 'event_name');
        $event_nameStr = implode("<br>",$event_namesArr);
    }
   
    
    if ($today == $date) {
        $week .= "<td class='today' onclick='openPopup(".$eventResultStr.")'>";
    } else {
        $week .= "<td onclick='openPopup(".$eventResultStr.")'>";
    }
    $week .= $day."<br><span style='display:block;font-size:14px;'>".$event_nameStr. '</span></td>';
    
    // End of the week OR End of the month
    if ($str % 7 == 0 || $day == $day_count) {
        
        // last day of the month set to Sunday
        if ($day == $day_count && $str % 7 != 0) {
            
            // Add empty cell for formatting purposes
            $week .= str_repeat('<td></td>', 7 - $str % 7);
        }
        
        $weeks[] = '<tr>' . $week . '</tr>';
        
        $week = '';
    }
}
?>

<html lang="en">

<head>
<title>NyleneCalendar</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.list-inline {
	text-align: center;
	margin-top: 25px;
	margin-bottom: 0px;
}

.title {
	font-weight: bold;
	font-size: 25px;
}

th {
	text-align: center;
}

td {
	height: 100px;
	width: 170px;
}

.today {
	background-color: aliceblue;
}

.table table-bordered {
	max-width: 100%;
	max-heigth: 100%;
}

.table notification{
max-width: 100%;
max-heigth: 100%;
	}
.btn btn-link{

}	
button{
	background: #f8a88d;
	border: medium none;
	color: #fff;
	font-size: 16px;
	margin: 0 0 20px 0;
	padding: 8px 38px;
	text-transform: uppercase;
	cursor: pointer;
}
button a{
	color: #fff;
	text-decoration: none;
	}
</style>
</head>
<body>

	<div class="container">
		<ul class="list-inline">
			<li class="list-inline-item"><a href="?ym=<?= $previous_month; ?>"
				class="btn btn-link">&lt; prev</a></li>
			<li class="list-inline-item"><span class="title"><?= $title; ?></span></li>
			<li class="list-inline-item"><a href="?ym=<?= $next_month; ?>"
				class="btn btn-link">next &gt;</a></li>

		</ul>
				
		 <!-- <p class="text-right"> 
			<a href="../Home/Homepage.php" class="btn btn-link">Today</a>
		 </p> -->
		 
		 <div class="btn-group" role="group" aria-label="Events">
		 
		 <div class="text-left">
		<button type="button" class="btn btn-outline-secondary" onclick='location.href="<?php echo BASE_URL; ?>Calendar/addEvent.php"'>Add Event</button>
		</div>
		
		<div class="text-right">
		<a href="<?PHP echo BASE_URL; ?>Home/Homepage.php"> <button type="button" class="btn btn-link">Today</button></a>
		</div>
		
		</div>
		<div class="row">
			<div class="col-md-8">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Mon</th>
							<th>Tue</th>
							<th>Wed</th>
							<th>Thu</th>
							<th>Fri</th>
							<th>Sat</th>
							<th>Sun</th>

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
				<table class ="notification">
					<thead>	
					<tr>
					
					</tr>
					</thead>
				</table>
			</div>
			<div class="col-md-4" id="eventDiv">
				<div class="" id="event_Modal" style="">
					<!-- Modal body -->
					<div class="modal-body">
						<div class="mb-2">
							<h3>Events</h3>
							<h4 id="result"></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--checks to see if event exists in calendar, and shows if it does  -->	
	
	<script type="text/javascript">
		function openPopup(date) {
			$("#result").text('');
	        if (date=='No'){
	    		$("#result").text(" ");
	    	}else{
				for(var i=0; i<date.length; i++){
		        //console.log(date[i]);
				$("#result").append("<p style='margin-left:20px;'>Event Name : "+date[i].event_name+"<br>Event Time : "+date[i].start_time+"<br>Description : "+date[i].description+"<br>Mandatory Attendance : "+date[i].mandatory_attendance+"</p><a class='' href='<?php echo BASE_URL; ?>/Calendar/editEvent.php?e="+date[i].calendar_id+"'><button class='' type='button'>Edit</button></a>");
		    	}
	    	}
			//$("#Contact_Modal").modal('show');
			//console.log(date);
		}
	</script>
</body>
</html>