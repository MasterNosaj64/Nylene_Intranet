<?php
/* Name: editEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: November 6th, 2020
 * Purpose: Form to edit the event and insert into the database.
 */

session_start();
include '../NavPanel/navigation.php';
include '../Database/connect.php';

$conn = getDBConnection();

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {
    /*Get eventID from edit button on calendar.php*/
    $eventID = $_GET['e'];
    
    /*Select users name from database as readonly field in form. This information is
     * just for appearances on this page*/
    $userInformation = "SELECT first_name, last_name FROM employee
								WHERE employee_id = " . $_SESSION['userid'];
    $result = $conn->query($userInformation);
    $row = mysqli_fetch_array($result);

    /*Search calendar info using calendar id posted from edit button*/
    $calendarQuery = "SELECT * FROM calendar
								WHERE calendar_id = ". $eventID;
    $calendarResults = $conn->query($calendarQuery);
    $calendarRow = mysqli_fetch_array($calendarResults);
    
    /*Code for if radio button is checked for mandatory attendance*/
    if ($calendarRow['mandatory_attendance'] == 'Yes'){
        $checked = 1;
    } else {
        $checked = 0;
    }
    
    /*Code if the radio button is checked for event visability*/

    if($calendarRow['event_visibility'] == 'for_all'){
       $option = 1;
    } elseif($calendarRow['event_visibility'] == 'for_team'){
        $option = 2;
    }
    elseif($calendarRow['event_visibility'] == 'for_individual'){
        $option = 3;
    } else{
        $option = 0;
    }
    
    
    /*Search user id in table to find employee name for created by field*/
    $employeeCreated = "SELECT first_name, last_name FROM employee
								WHERE employee_id = " . $calendarRow['employee_id'];
    $employeeResult = $conn->query($employeeCreated);
    $employeeCreatedRow = mysqli_fetch_array($employeeResult);
    
    /*Assign date modified*/
    $todaysDate = date("Y/m/d");
    $currentDate = date_create($todaysDate);
    date_modify($currentDate, "-0 days");
    
    $conn->close();
}

?>

<html>
	<head>
		<title>Edit Event in Calendar</title>
		<link rel="stylesheet" href="../CSS/form.css">
	</head>
	
	<body>
    	<form name="editEvent" action="updateEvent.php" method="post" >
    		<table class = "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">- Event Information -</th>
        		</tr></thead>
        		<tr>
            		<!--Date Event Scheduled-->
        			<td ><label for="event_date"> Event Date* </label></td>
        			<td ><input type="date" id="event_date" name="event_date" required value="<?php echo $calendarRow['event_date'];?>"></td>
        		</tr>
    			<tr>
        			<!--Event Name-->
        			<td><label for="event_name"> Event Name* </label></td>
        			<td><input type="text" id="event_name" name="event_name" required value="<?php echo $calendarRow['event_name'];?>"></td>
    			</tr>
    			<tr>
        			<!--Description-->
        			<td><label for="description"> Description </label></td>
        			<td><input type="text" id="description" name="description" value="<?php echo $calendarRow['description'];?>"></td>
    			</tr>
    			<tr>
        			<!--Event Start Time-->
        			<td ><label for="start_time"> Event Start-Time </label></td>
        			<td ><input type="text" id="start_time" name="start_time" value="<?php echo $calendarRow['start_time'];?>"></td>
    			</tr>
    			<tr>
        			<!--Mandatory Attendance-->
        			<td> Mandatory Attendance </td>
        			<td>
        			<?php if ($checked){ ?>
        				<input type="radio"  name="mandatory_attendance" value="Yes" checked>
        				<label for="Yes"> Yes </label>
        				<input type="radio"  name="mandatory_attendance" value="No">
        				<label for="No"> No </label>
        			<?php } else { ?>
        				<input type="radio"  name="mandatory_attendance" value="Yes" >
        				<label for="Yes"> Yes </label>
        				<input type="radio"  name="mandatory_attendance" value="No" checked>
        				<label for="No"> No </label>
        			<?php } ?>
        			</tr>
        			<tr>
        			<!-- Event Visability -->
        			<td> Event Visability </td>	
        			 <?php if ($_SESSION['role'] == "admin") { ?>
        					<td>
        					<?php if ($option == 1){ ?>
        						<input type="radio" name="event_visibility" value="for_all" checked>
        						<label for="for_all">For All </label>
        						<input type="radio"  name="event_visibility" value="for_team">
        						<label for="for_team"> For Team </label>
        						<input type="radio"  name="event_visibility" value="for_individual">
        						<label for="for_individual"> For Individual </label>
        					<?php } elseif ($option == 2) { ?>
        						<input type="radio" name="event_visibility" value="for_all">
        						<label for="for_all">For All </label>
        						<input type="radio"  name="event_visibility" value="for_team" checked>
        						<label for="for_team"> For Team </label>
        						<input type="radio"  name="event_visibility" value="for_individual">
        						<label for="for_individual"> For Individual </label>
        					<?php } elseif($option == 3){ ?>
        						<input type="radio" name="event_visibility" value="for_all">
        						<label for="for_all">For All </label>
        						<input type="radio"  name="event_visibility" value="for_team">
        						<label for="for_team"> For Team </label>
        						<input type="radio"  name="event_visibility" value="for_individual" checked>
        						<label for="for_individual"> For Individual </label>       						
        					<?php } else { ?>		<?php } ?>	
        					
        						<?php } else { ?>    						
        						<td>
        						
        					<?php if ($option == 2){ ?>
        					    <input type="radio"  name="event_visibility" value="for_team" checked>
        						<label for="for_team"> For Team </label>
        						
        						<input type="radio"  name="event_visibility" value="for_individual">
        						<label for="for_individual"> For Individual </label>
        						
        					<?php }elseif($option == 3){ ?>
        						<input type="radio"  name="event_visibility" value="for_team">
        						<label for="for_team"> For Team </label>
        						
        						<input type="radio"  name="event_visibility" value="for_individual" checked>
        						<label for="for_individual"> For Individual </label>
        					
        					<?php } else { ?>		<?php } ?>	
        					
        					<?php } ?>		
        					</td>	
    			</tr>
    			
    		<thead><tr>
    			<th colspan="2">- Administration Information -</th>
    		</tr></thead>
    		<tr>		
    			<!--Employee name-->
    			<td><label for="name"> Event Created By </label></td>
    			<td><input type="text" id="name" name="name" readonly value="<?php echo $employeeCreatedRow['first_name'].' '.$employeeCreatedRow['last_name'];?>"></td>
    		</tr>
    		<tr>
    			<!--Date Created-->		
    			<td><label for="date_created"> Date Created </label></td>
    			<td><input type="text" id="date_created" name="date_created" readonly value="<?php echo $calendarRow['date_created'];?>"></td>
    		</tr>
    		<tr>		
    			<!--Modified By name-->
    			<td><label for="modified_by"> Modified By </label></td>
    			<td><input type="text" id="modified_by" name="modified_by" readonly value="<?php echo $row['first_name'].' '.$row['last_name'];?>"></td>
    		</tr>
    		<tr>
    			<!--Date Created-->		
    			<td><label for="date_modified"> Date Modified </label></td>
    			<td><input type="text" id="date_modified" name="date_modified" readonly value="<?php echo date_format($currentDate, "Y/m/d"); ?>"></td>
    		</tr>
    		
			<tr>
    			<td colspan="1"> <input type="submit" value="submit" style="width:100%"> </td>
    			<td colspan="1"> <input type="reset" value= "reset" style="width:100%"><input hidden type="number" id="calendar_id" name="calendar_id" value="<?php echo $calendarRow['calendar_id'];?>"/></td>
    			
    		</tr>
    		</table>
    	</form>
	</body>
</html>