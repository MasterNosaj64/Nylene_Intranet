<?php
/* Name: updateEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: November 2nd, 2020
 * Purpose: File called when user clicks submit on the edit event form form. Inserts form information into
 *          the calendar table of the database.
 */

session_start();
include '../Database/connect.php';

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {
    
    $userID = $_SESSION['userid'];
    
    /*Prepare update statement into the calendar table*/
  
    
    /*Assign values to variables and execute*/
    $eventDate = htmlspecialchars(strip_tags($_POST["event_date"]));
    $startTime = htmlspecialchars(strip_tags($_POST["start_time"]));
    $eventName = htmlspecialchars(strip_tags($_POST["event_name"]));
    $description = htmlspecialchars(strip_tags($_POST["description"]));
    $dateModified = htmlspecialchars(strip_tags($_POST["date_modified"]));
    $modifiedBy =  $userID;
    $mandatoryAttendance = htmlspecialchars(strip_tags($_POST["mandatory_attendance"]));
    
    /*Bind statement parameters to statement*/
    $stmt->bind_param("ssssssiis", $eventDate, $startTime, $eventName, $description, 
        $dateModified, $modifiedBy, $mandatoryAttendance);
    
    
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
    exit();
}
?>