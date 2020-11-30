<?php
/* Name: updateEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: November 5th, 2020
 * Purpose: File called when user clicks submit on the edit event form form. Inserts form information into
 *          the calendar table of the database.
 */

session_start();
include '../Database/connect.php';

$conn = getDBConnection();

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {
    
    $userID = $_SESSION['userid'];
    
    /*Prepare update statement into the calendar table*/
    $stmt = $conn->prepare("UPDATE calendar SET
					event_date = ?,
					start_time = ?,
					event_name = ?,
					description = ?,
                    date_modified = ?,
                    modified_by = ?,
					mandatory_attendance = ?,
                    event_visibility = ?
                WHERE calendar_id = ?");
    
    /*Assign values to variables and execute*/
    $eventDate = htmlspecialchars(strip_tags($_POST["event_date"]));
    $startTime = htmlspecialchars(strip_tags($_POST["start_time"]));
    $eventName = htmlspecialchars(strip_tags($_POST["event_name"]));
    $description = htmlspecialchars(strip_tags($_POST["description"]));
    $dateModified = htmlspecialchars(strip_tags($_POST["date_modified"]));
    $modifiedBy =  $userID;
    $mandatoryAttendance = htmlspecialchars(strip_tags($_POST["mandatory_attendance"]));
    $eventVisibility =     htmlspecialchars(strip_tags($_POST["event_visibility"]));
    $calendarID = htmlspecialchars(strip_tags($_POST["calendar_id"]));
    
    /*Bind statement parameters to statement*/
    $stmt->bind_param("sssssisi", $eventDate, $startTime, $eventName, $description, 
        $dateModified, $modifiedBy, $mandatoryAttendance,$eventVisibility, $calendarID);
    
    
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
    exit();
}
?>