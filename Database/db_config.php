<?php 
    /*Use connect.php for database connection*/


	//$_SESSION["userid"] = 7; //this is the userid I created in database
	$host = "localhost";  
    $username = "root";  
    $password = "";  
	$dbname = "nylene";
	
	$dbConnection = new mysqli($host, $username, $password, $dbname);
?>