


<?php







    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_DATABASE = "nylene";

    $connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);

//if(mysqli_connect_errno($connect))
//{
	//	echo 'Failed to connect';
//}

if($connect) {
  echo '<h1>Thanks for creating user</h1>';
 // if(isset($_POST['example2']) ){
 //$employee_id=$_POST['employee_id'];
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$title=$_POST['title'];
$department=$_POST['department'];
$work_phone=$_POST['work_phone'];
$reports_to=$_POST['reports_to'];
$date_entered=$_POST['date_entered'];
$date_modified=$_POST['date_modified'];
$modified_by=$_POST['modified_by'];
$username=$_POST['username'];
$is_administrator=$_POST['is_administrator'];
$STATUS=$_POST['STATUS'];
$employee_email=$_POST['employee_email'];
//$password=$_POST['password'];
$password=password_hash($_POST['password'],PASSWORD_BCRYPT);//JASON & JIMMY: PASSWORD_DEFAULT DOES NOT WORK, changed to PASSWORD_BCRYPT
	


/**
$dob=$_POST['DOB'];
$gender=$_POST["Gender"];
$mobile_phone=$_POST['MobilePhone'];
$home_phone=$_POST['HomePhone'];
$address1=$_POST['Address1'];
$address2=$_POST['Address2'];
$city=$_POST['City'];
$province=$_POST['Province'];
$postal_code=$_POST['PostalCode'];
$start_date=$_POST['StartDate'];
$employee_number=$_POST['EmployeeNumber'];
$sin=$_POST['SIN'];
$department=$_POST['Department'];
$category=$_POST['Category'];
$vacation_days=$_POST['VacationDays'];
$vacation_percent=$_POST['VacationPercent'];
$job_code=$_POST['JobCode'];
$pay_type=$_POST['PayType'];
$pay_rate=$_POST['PayRate'];
$emergency_contact_name=$_POST['EmergencyContactName'];
$emergency_contact_phone=$_POST['EmergencyContactPhone'];
//}

**/
  //if connected then Select Database. 
  $db=mysqli_select_db($connect,$DB_DATABASE);
    echo '<h1>Connected to MySQL</h1>';

    $query=mysqli_query($connect,"INSERT INTO employee(first_name,last_name,title,department,work_phone,reports_to,date_entered,date_modified,modified_by,username,is_administrator,STATUS,employee_email,password) VALUES ('$first_name', '$last_name', '$title','$department','$work_phone','$reports_to','$date_entered','$date_modified','$modified_by','$username','$is_administrator','$STATUS','$employee_email','$password')");
 if (!$query) {
    echo (mysqli_error($connect)) ;
	echo "           fail";
}
else{ echo "      Success </br> ";
    echo "<a href=\"Homepage.php\">Homepage</a>";
}
 
 
 // $query=mysqli_query($connect,"INSERT INTO employee(First_Name,Last_Name,Email_Address,DOB,MobilePhone,HomePhone,Address1,Address2,City,PostalCode,StartDate,EmployeeNumber,SIN,Department,VacationDays,VacationPercent,PayRate,EmergencyContactName,EmergencyContactPhone) VALUES('$first_name','$last_name','$email','$dob','$mobile_phone','$home_phone','$address1','$address2','$city','$postal_code','$start_date','$employee_number','$sin','$department','$vacation_days','$vacation_percent','$pay_rate','$emergency_contact_name,'$emergency_contact_phone')");

   //print_r($_POST);
  //echo '<h1>Connected to MySQL</h1>';

}

else {
  echo '<h1>MySQL Server is not connected</h1>';
}
 
?>