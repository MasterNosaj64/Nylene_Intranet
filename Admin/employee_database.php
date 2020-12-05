<?php
/*
 * FileName: employee_database.php
 * Author: Madhav Sachdeva
 * Version: 2.1
 * Date Modified: 12/05/2020
 * Purpose:
 * Inser the valeus from create user form to the loacal host database
 */
if (!session_id()) {
	session_start();
	include '../Database/connect.php';
} 
$conn = getDBConnection();  
if($conn) {
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$title=$_POST['title'];
	$department=$_POST['department'];
	$work_phone=$_POST['work_phone'];
	$reports_to=$_POST['reports_to'];
	$date_entered=date("Y-m-d");
	$date_modified=date("Y-m-d");
	$modified_by=$_SESSION['userid'];
	$username=$_POST['username'];
	$STATUS=$_POST['STATUS'];
	$employee_email=$_POST['employee_email'];
	$password=password_hash($_POST['password'],PASSWORD_BCRYPT);

	/*with sql injection thing*/
	$query=$conn->prepare("INSERT INTO employee
	(first_name,
	last_name,
	title,
	department,
	work_phone,
	reports_to,
	date_entered,
	date_modified,
	modified_by,
	username,
	STATUS,
	employee_email,
	password
	) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)"); //13 columns
	    $query->bind_param("sssssssssssss" , $first_name, $last_name, $title,$department,$work_phone,$reports_to,$date_entered,$date_modified,$modified_by,$username,$STATUS,$employee_email,$password);
	
	$query->execute();
    $query->close();
    $query->close();
	if (!$query) {
		echo (mysqli_error($conn)) ;
	}
	else{ 
	header('Location: ../Home/Homepage.php');
	}
}
else {
  echo '<h1>MySQL Server is not connected</h1>';
}
?>