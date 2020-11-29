<?php
 if (!session_id()) {
session_start();
//TODO: MADHAV change database connection file and/or align code to mysqli standard
include '../Database/databaseConnection.php';
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


 
  //$db=mysqli_select_db($conn,$DB_DATABASE);
/*without sql injection thingi*/
    //$query=mysqli_query($conn,"INSERT INTO employee(first_name,last_name,title,department,work_phone,reports_to,date_entered,date_modified,modified_by,username,is_administrator,STATUS,employee_email,password) VALUES ('$first_name', '$last_name', '$title','$department','$work_phone','$reports_to','$date_entered','$date_modified','$modified_by','$username','$is_administrator','$STATUS','$employee_email','$password')");
	
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

	   /* 
	   
	   sssssssssssssssssi
	   $query->bind_param("s", $last_name);
	    $query->bind_param("s", $title);
	    $query->bind_param("s", $department);
	    $query->bind_param("s", $work_phone);
	    $query->bind_param("s", $reports_to);
	    $query->bind_param("s", $date_entered);
	    $query->bind_param("s", $date_modified);
	    $query->bind_param("s", $modified_by);
		$query->bind_param("s", $username);
	    $query->bind_param("s", $is_administrator);
	    $query->bind_param("s", $STATUS);
	    $query->bind_param("s", $employee_email);
	    $query->bind_param("s", $password);
*/

	
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