<?php
/* Name: addEvent.php
 * Author: Kaitlyn Breker
 * Last Modified: October 31st, 2020
 * Purpose: Input for adding an event to the database.
 */
    session_start();
    include '../NavPanel/navigation.php';
    include '../Database/connect.php';

    
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
        
        
        $conn->close();
    }
    
?>

<html>
	<head>
		<title>Add Event to Calendar</title>
		<link rel="stylesheet" href="../CSS/form.css">
	</head>
	
	<body>
    	<form name="addEvent" action="newAddEvent.php" method="post" >
    		<table class = "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">Add Event to Calendar</th>
        		</tr></thead>
        		
    		</table>
    	</form>
	</body>
</html>