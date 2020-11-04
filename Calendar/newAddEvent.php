<?php
/* Name: newAddEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: October 31st, 2020
 * Purpose: File called when user clicks submit on the add calendarevent form. Inserts form information into
 *          the calendar table of the database.
 */

session_start();
include '../Database/connect.php';

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {
    
    $userID = $_SESSION['userid'];
    
    /*Prepare insert statement into the calendar table*/
    $stmt = $conn->prepare("INSERT INTO calendar (
					event_date,
					start_time,
					event_name,
					description,
					date_created,
                    date_modified,
					employee_id,
                    modified_by,
					mandatory_attendance)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    /*Assign values to variables and execute*/
    $eventDate = htmlspecialchars(strip_tags($_POST["event_date"]));
    $startTime = htmlspecialchars(strip_tags($_POST["start_time"]));
    $eventName = htmlspecialchars(strip_tags($_POST["event_name"]));
    $description = htmlspecialchars(strip_tags($_POST["description"]));
    $dateCreated  = htmlspecialchars(strip_tags($_POST["date_created"]));
    $dateModified = NULL;
    $employeeID = $userID; 
    $modifiedBy =  NULL; 
    $mandatoryAttendance = htmlspecialchars(strip_tags($_POST["mandatory_attendance"]));
   
    /*Bind statement parameters to statement*/
   $stmt->bind_param("ssssssiis", $eventDate, $startTime, $eventName, $description, $dateCreated,
        $dateModified, $employeeID, $modifiedBy, $mandatoryAttendance);
  
    
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
    exit();
}
?>