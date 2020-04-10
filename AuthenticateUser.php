<?php
session_start();
    include 'databaseConnection.php';
    $dbConnection = setConnectionInfo();

	$userQuery = "SELECT * FROM nylene.employee WHERE username = '" .$_POST['username']."'";
    
	$result = $dbConnection->query($userQuery);

	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$password1 = $_POST['password'];
	$password1=password_hash($password1,PASSWORD_DEFAULT);
	
	$password2 = $row['password'];
	
	if(password_verify($password2, $password1)){
	    $_SESSION['name'] = $row['first_name']." ".$row['last_name'];
	    $_SESSION['role'] = $row['title'];
	    $_SESSION['userid'] = $row['employee_id'];
	    
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./Homepage.php\" />;";
	    exit();
	} else {
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./login.php\" />;";
	    exit();
	}
			
?>