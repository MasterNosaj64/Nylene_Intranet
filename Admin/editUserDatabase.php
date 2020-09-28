
<?php
//session_start();
 if (!session_id()) {
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../navigation.php';
include '../Database/databaseConnection.php';
include '../Database/connect.php';


} 

//print_r();

?>

<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<form method="post" action="" >

<tr>
<!--<form method="post" action="" >
  <label for="subjectEmail"><b>
	Enter employee email:</b></label><br />
	<input name="subjectEmail" type="email" maxlength="50" />
    
<input type="submit" name="Submit">-->

<td>Name of the user to be edited <select id="employee" name="edit_user">
		<?php
//$connect = mysqli_connect("localhost", "root", "");
//$db = mysqli_select_db($connect, "nylene");
$sql = "SELECT * FROM employee";
$query = mysqli_query($connect, $sql);
while ($row = mysqli_fetch_array($query)) {
    echo '<option style="width: 260px" value=' . $row['employee_id'] . '>' . $row['first_name'] . " " . $row['last_name'] . '</option>';
}
?>
		</select></td>

  </tr>
  
  <input type="submit" name="Submit">
			<input type="reset" name="Reset">
		
</form>

</html>


<?php 
if(isset($_POST['Submit'] )){
    /*$DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_DATABASE = "nylene";
    $connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
	$db=mysqli_select_db($connect,"nylene");
*/
	$field=$_POST['edit_user'];
			$_SESSION['field'] = $field;

			//echo '<h1>MySQL Server is connected</h1>';
			header('location:editUser.php');

	//$check=0;

   


	//if($connect) {
  
		   
		//$sql = "SELECT employee_id FROM employee";
		//$query = mysqli_query($connect,$sql);
		/**while ($row = mysqli_fetch_array($query)) {
			if($field==$row['employee_email']){
				$check=1;
			}
		}			
			
		if($check==1){
		*/
		//$_SESSION['field'] = $field;
			//header('location:editUser.php');
		//}
		//else{
			//echo 'No such email found';
		//}
	}
	
	

?>