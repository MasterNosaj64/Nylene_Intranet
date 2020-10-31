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

}
?>