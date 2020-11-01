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

    /*Prepare insert statement into the distributor_quote_form table*/
    $stmt = $conn->prepare("INSERT INTO calendar (
					event_date,
					start_time,
					event_name,
					description,
					date_created,
                    date_modified,
					employee_id,
                    modified_by
					manadtory_attendance)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    /*Bind statement parameters to statement*/
    $stmt->bind_param("ssssssiii", $eventDate, $startTime, $eventName, $description, $dateCreated,
        $dateModified, $employeeID, $modified_by, $mandatoryAttendance);
     
     //still need to implement more code here
}
?>