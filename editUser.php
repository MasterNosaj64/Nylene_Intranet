<?php
//session_start();
 if (!session_id()) {
session_start();

} 

//print_r();

?>
	

<!DOCTYPE html>
<html>
<head> <link rel="stylesheet" href="style_cU.css">
</head>
<body onload="myFunction()">
<h1><h1>



<form  method="post" action="afterEditUser.php">



<table border="1" cellpadding="5" cellspacing="0">

<tr>
				<td  border=0 colspan="2"  style="text-align: center;">Fill all the fields that need to be changed with new values</td>
			</tr>  

<tr>
				<td id="column_heading" colspan="2"  style="text-align: left;">Standard Information</td>
			</tr>  
			
</table>
			<table border="1" cellpadding="5" cellspacing="0">
	<!--<tr>
	<td colspan="2">
	<label for="employee_id"><b>Employee ID*</b></label><br/>
	<input name="employee_id" type="text" maxlength="100" style="width: 535px" />
	</td> </tr>-->
<tr>
<td style="width: 50%">
	<label for="first_name">
	<b>First Name *</b></label><br />
	<input name="first_name" type="text" maxlength="50" style="width: 260px" />
	</td>
	<td style="width: 50%">
	<label for="last_name">
	<b>Last Name *</b></label><br />
	<input name="last_name" type="text" maxlength="50" style="width: 260px" />
	</td>
</tr> 
<tr>
<td>
<label for="title"><b>Title *</b></label><br />
<select name="title">
    <option value=""></option>
  <option value="admin">Admin</option>
  <option value="sales_rep">Sales Rep</option>
  <option value="sales_manager">Sales Manager</option>
</td> <td>
<label for="department"><b>Department</b></label><br />
<input name="department" type="text" maxlength="50" style="width: 260px" />
</td> </tr>

<tr> <td>
<label for="work_phone"><b>Work Phone *</b></label><br />
<input name="work_phone" type="text" maxlength="50" style="width: 260px" />
</td>  <td>
<label for="reports_to"><b>Reports to</b></label><br />

<select name="reports_to">
		<?php 
		   $connect = mysqli_connect("localhost", "root", "");
  $db=mysqli_select_db($connect,"nylene");
$sql = "SELECT * FROM employee";
$query = mysqli_query($connect,$sql);
while ($row = mysqli_fetch_array($query)) {
echo '<option style="width: 260px" value='.$row['employee_id'].'>'.$row['first_name']." ".$row['last_name'].'</option>';
}
?>
		</select>





	
		
		
</td> </tr>

</table>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
				<td id="column_heading" colspan="2"  style="text-align: left;">Secondary Information</td>
			</tr></table><table border="1" cellpadding="5" cellspacing="0">
<tr>


	</td> 
<script>	
	function myFunction() {
var date = new Date();
var day = date.getDate();
var month = date.getMonth() + 1;
var year = date.getFullYear();
if (month < 10) month = "0" + month;
if (day < 10) day = "0" + day;
var today = year + "-" + month + "-" + day;
var x = document.getElementsByClassName('theDate');
x[0].value = today;
x[1].value = today;
}
</script>
	
	<td colspan="2">
	<label for="date_modified"><b>Date Modified *</b></label><br />
	<input name="date_modified" type="date" class="theDate" maxlength="100" readonly />

</td>



</tr>

<tr> <td>
<label for="modified_by"><b>Modified By *</b></label><br />
<input name="modified_by" type="text" maxlength="50" style="width: 260px" value="<?php echo $_SESSION['userid']?>" readonly />
</td>  <td>
<label for="username"><b>Username *</b></label><br />
<input name="username" type="text" maxlength="50" style="width: 260px" />
</td> </tr>


<tr>

<td style="width: 50%">
	<label for="is_administrator">
	<b>is Admin </b></label><br />
	<select name="is_administrator">
	    <option value=""></option>

	  <option value="1">Yes</option>
  <option value="0">No</option>
  
</select>
	</td>
	<td style="width: 50%">
	<label for="STATUS"><b>STATUS</b></label><br />
	<input name="STATUS" type="text" maxlength="100" style="width: 260px" />
</td> 

</tr>







<tr>
	<td colspan="2">
	<label for="employee_email"><b>Email *</b></label><br />
<input name="employee_email" type="text" maxlength="100" style="width: 535px" />
</td> </tr>
<tr>
	<td colspan="2">
	<label for="password"><b>Password *</b></label><br />
	<input name="password" type="text" maxlength="100" style="width: 535px" />
</td> 
</tr></table>

<table><tr><td>
<input type="submit" value="submit">
</td>
<td>
<input type="reset" value="Reset">
</td></tr>
</table>
</form>
</body>
</html>


