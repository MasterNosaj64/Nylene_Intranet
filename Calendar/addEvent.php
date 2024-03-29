<?php
/* Name: addEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: November 30th, 2020
 * Purpose: Input for adding an event to the database.
 */
session_start();
include '../NavPanel/navigation.php';
include '../Database/connect.php';

$conn = getDBConnection();

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {
    
    /*Select users name from database as readonly field in form. This information is
     * just for appearances on this page*/
    $userInformation = "SELECT first_name, last_name FROM employee
								WHERE employee_id = " . $_SESSION['userid'];
    $result = $conn->query($userInformation);
    $row = mysqli_fetch_array($result);
    
    /*Assign date created*/
    $todaysDate = date("Y-m-d");
    $currentDate = date_create($todaysDate);
    date_modify($currentDate, "-0 days");
    
    $conn->close();
}

?>

<html>
	<head>
		<title>Add Event to Calendar</title>
		<link rel="stylesheet" href="../CSS/form.css">
	</head>
	
	<body>
    	<form name="addEvent" action="newAddEvent.php" method="post" autocomplete="off">
    		<table class = "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">- Event Information -</th>
        		</tr></thead>
        		<tr>
            		<!--Date Event Scheduled-->
        			<td ><label for="event_date"> Event Date* </label></td>
        			<td ><input type="date" id="event_date" name="event_date" required></td>
        		</tr>
    			<tr>
        			<!--Event Name-->
        			<td><label for="event_name"> Event Name* </label></td>
        			<td><input type="text" id="event_name" name="event_name" required></td>
    			</tr>
    			<tr>
        			<!--Description-->
        			<td><label for="description"> Description </label></td>
        			<td><input type="text" id="description" name="description"></td>
    			</tr>
    			<tr>
        			<!--Event Start Time-->
        			<td ><label for="start_time"> Event Start-Time </label></td>
        			<td ><input type="text" id="start_time" name="start_time"></td>
    			</tr>
    			<tr>
        			<!--Mandatory Attendance-->
        			<td> Mandatory Attendance </td>
        			<td>
    					<input type="radio"  name="mandatory_attendance" value="Yes">
        				<label for="Yes"> Yes </label>
        				<input type="radio"  name="mandatory_attendance" value="No" checked>
        				<label for="No"> No </label>
        			</td>	
        			</tr>
        			<tr>
        			
        					<!-- Event Visibility-->
        					<td> Event Visibility </td>
        					
        			<!-- If the user is admin, they will have access to the option: "for all" and those stated below.
        			     Other users ie: employee/independent have access to their team, and individual only -->
        			     
        					 <?php if ((strcmp($_SESSION['role'], "admin") == 0) || (strcmp($_SESSION['role'], "supervisor") == 0)){ ?>
        					<td>
        						<input type="radio" name="event_visibility" value="for_all">
        						<label for="for_all">For All </label>
        						
        						<input type="radio"  name="event_visibility" value="for_team">
        						<label for="for_team"> For Team </label>
        						
        						<input type="radio"  name="event_visibility" value="for_individual" checked>
        						<label for="for_individual"> For Individual </label>
        					</td>
        					
        					<?php } else { ?>
        						
        					<td>
        						<input type="radio" name="event_visibility" value="for_all" disabled>
        						<label for="for_all">For All </label>
        						
        						<input type="radio"  name="event_visibility" value="for_team" disabled>
        						<label for="for_team"> For Team </label>
        						
        						<input type="radio"  name="event_visibility" value="for_individual" checked>
        						<label for="for_individual"> For Individual </label>
        					</td>	
        					
        					<?php } ?>
        							
    			</tr>
    			
    		<thead><tr>
    			<th colspan="2">- Administration Information -</th>
    		</tr></thead>
    		<tr>		
    			<!--Employee name-->
    			<td><label for="name"> Event Created By </label></td>
    			<td><input type="text" id="name" name="name" readonly value="<?php echo $row['first_name'].' '.$row['last_name'];?>"></td>
    		</tr>
    		<tr>
    			<!--Date Created-->		
    			<td><label for="date_created"> Date Created </label></td>
    			<td><input type="text" id="date_created" name="date_created" readonly value="<?php echo date_format($currentDate, "Y/m/d"); ?>"></td>
    		</tr>
    		
			<tr>
    			<td colspan="1"> <input type="submit" value="submit" style="width:100%"> </td>
    			<td colspan="1"> <input type="reset" value= "reset" style="width:100%"> </td>
    		</tr>
    		</table>
    	</form>
	</body>
</html>