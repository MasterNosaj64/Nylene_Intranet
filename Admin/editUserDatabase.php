
<?php
//session_start();
 if (!session_id()) {
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../navigation.php';
} 

//print_r();

?>

<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<tr>
<form method="post" action="" >
  <label for="subjectEmail"><b>
	Enter employee email:</b></label><br />
	<input name="subjectEmail" type="email" maxlength="50" />
    
<input type="submit" name="Submit">
  </tr>
</form>  

</html>



<?php

if(isset($_POST['Submit'] )){
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_DATABASE = "nylene";
    $connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
	$db=mysqli_select_db($connect,"nylene");

	$field=trim($_POST['subjectEmail']);
	$check=0;

   


	if($connect) {
  
		   
		$sql = "SELECT employee_email FROM employee";
		$query = mysqli_query($connect,$sql);
		while ($row = mysqli_fetch_array($query)) {
			if($field==$row['employee_email']){
				$check=1;
			}
		}			
			
		if($check==1){
		$_SESSION['field'] = $field;
			header('location:editUser.php');
		}
		else{
			echo 'No such email found';
		}
	}
	
	else {
		echo '<h1>MySQL Server is not connected</h1>';
	}
}
?>