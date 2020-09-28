<?php
session_start();
    include '../Database/databaseConnection.php';
	//include '../Database/databaseConnection.php';
include '../Database/connect.php';
    $dbConnection = setConnectionInfo();
	$userQuery = "SELECT * FROM nylene.employee WHERE username = '" .$_POST['username']."'";
	$result = $dbConnection->query($userQuery);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$password1 = $_POST['password'];
	$password2 = $row['password'];
	/**/
	
	if(password_verify($password1,$password2)){

	
	  $_SESSION['name'] = $row['first_name']." ".$row['last_name'];
	    $_SESSION['role'] = $row['title'];
	    $_SESSION['userid'] = $row['employee_id'];
	    
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
	    exit();
	    
	    //Added this if so we can still use our admin accounts that were originally created
	} else if(!strcmp($password1, $password2)){
	    $_SESSION['name'] = $row['first_name']." ".$row['last_name'];
	    $_SESSION['role'] = $row['title'];
	    $_SESSION['userid'] = $row['employee_id'];
	    
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
	    exit();
	}else {
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../login.php\" />;";
	    exit();
	}
// if(isset($_SESSION["id"])) {
// header("Location:index.php");
// }

			
?>