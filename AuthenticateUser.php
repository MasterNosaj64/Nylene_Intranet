<?php
session_start();
//$message="";
//if(count($_POST)>0) {
    include 'databaseConnection.php';
    $dbConnection = setConnectionInfo();
	//$userQuery = mysqli_query($conn,"SELECT * FROM nylene.employee WHERE user_name='" . $_POST["userName"] . "' and password = '". $_POST["password"]."'");
	//$userQuery = "SELECT * FROM nylene.employee WHERE username = " . $_POST['username'];
	$userQuery = "SELECT * FROM nylene.employee WHERE username = '" .$_POST['username']."'";
    
	$result = $dbConnection->query($userQuery);

	$row = $result->fetch(PDO::FETCH_ASSOC);
	
	$password1 = $_POST['password'];
	$password2 = $row['password'];
	
	if(!strcmp($password1, $password2)){	    
	    $_SESSION['name'] = $row['first_name']." ".$row['last_name'];
	    $_SESSION['role'] = $row['title'];
	    $_SESSION['user_id'] = $row['employee_id'];
	    
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./Homepage.php\" />;";
	    exit();		
	} else {
	    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./login.php\" />;";
	    exit();
	}
//}
// if(isset($_SESSION["id"])) {
// header("Location:index.php");
// }

			
?>