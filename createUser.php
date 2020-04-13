

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
<form  method="post" action="employee_database.php"   onsubmit="return ValidateForm(this)";>
<script type="text/javascript">
function ValidateForm(frm) {
//if (frm.employee_id.value == "") { alert('Employee ID is required.'); frm.employee_id.focus(); return false; }
if (frm.first_name.value == "") { alert('First name is required.'); frm.first_name.focus(); return false; }
if (frm.last_name.value == "") { alert('Last name is required.'); frm.last_name.focus(); return false; }
if (frm.title.value == "") { alert('Title is required.'); frm.title.focus(); return false; }
if (frm.work_phone.value == "") { alert('Work Phone is required.'); frm.work_phone.focus(); return false; }
if (frm.date_entered.value == "") { alert('Date entered is required.'); frm.date_entered.focus(); return false; }
if (frm.date_modified.value == "") { alert('Date modified is required.'); frm.date_modified.focus(); return false; }
if (frm.modified_by.value == "") { alert('Modified by is required.'); frm.modified_by.focus(); return false; }
if (frm.username.value == "") { alert('Username is required.'); frm.username.focus(); return false; }
if (frm.employee_email.value == "") { alert('Email address is required.'); employee_email.focus(); return false; }
if (frm.employee_email.value.indexOf("@") < 1 || frm.employee_email.value.indexOf(".") < 1) { alert('Please enter a valid email address.'); frm.employee_email.focus(); return false; }
if (frm.password.value == "") { alert('Password is required.'); frm.password.focus(); return false; }
return true; }



</script>



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
 


<table border="1" cellpadding="5" cellspacing="0">



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
<input name="reports_to" type="text" maxlength="50" style="width: 260px" />
</td> </tr>


<table border="1" cellpadding="5" cellspacing="0">
<tr>
				<td id="column_heading" colspan="2"  style="text-align: left;">Secondary Information</td>
			</tr></table><table border="1" cellpadding="5" cellspacing="0">
<tr>


	<td style="width: 50%">
	<label for="date_entered"><b>Date Entered *</b></label><br />
	<input name="date_entered" type="date" class="theDate" maxlength="100" style="width: 260px" readonly />


</td> 
	<td style="width: 50%">
	<label for="date_modified"><b>Date Modified *</b></label><br />
	<input name="date_modified" type="date" class="theDate" maxlength="100" style="width: 260px" readonly />
		<!--<input name="date_modified" type="date" value ="<?php echo date("Y-m-d") ?>" style="width: 260px">
-->
</td>



</tr>

<tr> <td>
<label for="modified_by"><b>Modified By *</b></label><br />
<input name="modified_by" type="text" maxlength="50" style="width: 260px" value="<?php echo $_SESSION['name']?>" readonly />
</td>  <td>
<label for="username"><b>Username *</b></label><br />
<input name="username" type="text" maxlength="50" style="width: 260px" />
</td> </tr>


<tr>

<td style="width: 50%">
	<label for="is_administrator">
	<b>is Admin </b></label><br />
	<select name="is_administrator">
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
<input type="submit" value="Submit">
</td>
<td>
<input type="reset" value="Reset">
</td></tr>
</table>
</form>
</body>
</html>

<!--<td style="width: 50%">
	<label for="Gender">
	<b>Gender </b></label><br />
	<select name="Gender">
	  <option value="not_willing_to_specify">Not willing to specify</option>
  <option value="male">male</option>
  <option value="female">female</option>
  <option value="other">other</option>
</select>
	</td></tr>
 <tr> <td>
<label for="MobilePhone"><b>Mobile Phone *</b></label><br />
<input name="MobilePhone" type="text" maxlength="50" style="width: 260px" />
</td>  <td>
<label for="HomePhone"><b>Home Phone</b></label><br />
<input name="HomePhone" type="text" maxlength="50" style="width: 260px" />
</td> </tr>

<tr> <td>
<label for="Address1"><b>Address 1 *</b></label><br />
<input name="Address1" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="Address2"><b>Address 2</b></label><br />
<input name="Address2" type="text" maxlength="50" style="width: 260px" />
</td> </tr>

<tr> <td>
<label for="City"><b>City</b></label><br />
<input name="City" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="Province"><b>State/Province</b></label><br />
<select name="Province" >
  <option value="AB">Alberta</option>
	<option value="BC">British Columbia</option>
	<option value="MB">Manitoba</option>
	<option value="NB">New Brunswick</option>
	<option value="NL">Newfoundland and Labrador</option>
	<option value="NS">Nova Scotia</option>
	<option value="ON">Ontario</option>
	<option value="PE">Prince Edward Island</option>
	<option value="QC">Quebec</option>
	<option value="SK">Saskatchewan</option>
	<option value="NT">Northwest Territories</option>
	<option value="NU">Nunavut</option>
	<option value="YT">Yukon</option></select>
</td> </tr>

<tr> <td>
<label for="PostalCode"><b>Postal/Zip Code *</b></label><br />
<input name="PostalCode" type="text" maxlength="50" style="width: 260px" />
</td>  
<td colspan="2">
<label for="StartDate"><b>Start Date</b></label><br />
<input name="StartDate" type="date" maxlength="50" style="width: 260px" />
</td> </tr></table><table border="1" cellpadding="5" cellspacing="0">
<tr>
				<td id="column_heading" colspan="2"  style="text-align: left;">Pay & Benefit Information</td>
			</tr></table><table border="1" cellpadding="5" cellspacing="0">
<tr> <td>
<label for="EmployeeNumber"><b>Employee Number</b></label><br />
<input name="EmployeeNumber" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="SIN"><b>SIN/SSN</b></label><br />
<input name="SIN" type="text" maxlength="50" style="width: 260px" />
</td> </tr>
<tr> <td>
<label for="Department"><b>Department</b></label><br />
<input name="Department" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="Category"><b>Category</b></label><br />
<select name="Category">
  <option value="FullTime">Full Time</option>
  <option value="PartTime">Part time</option>
  <option value="Management">Management</option>
</td> </tr>
<tr> <td>
<label for="VacationDays"><b>Vacation Days</b></label><br />
<input name="VacationDays" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="VacationPercent"><b>Vacation Percent</b></label><br />
<input name="VacationPercent" type="text" maxlength="50" style="width: 260px" />
</td> </tr>
<tr>
<td colspan="2">
<label for="JobCode"><b>Job Code *</b></label><br />
<select name="JobCode">
  <option value="admin">Admin</option>
  <option value="sales_rep">Sales Rep</option>
  <option value="sales_manager">Sales Manager</option>
</td> </tr>

<tr>
<td>
<label for="PayType"><b>Pay Type</b></label><br />
<select name="PayType">
  <option value="Hourly">Hourly</option>
  <option value="Salary">Salary</option>
  <option value="Shift">Shift</option>
</td> 
<td>
<label for="PayRate"><b>Pay Rate</b></label><br />
<input name="PayRate" type="text" maxlength="50" style="width: 260px" />
</td>  </tr></table>
<table border="1" cellpadding="5" cellspacing="0">
<tr>
				<td id="column_heading" colspan="2"  style="text-align: left;">Emergency Contact Information</td>
			</tr></table><table border="1" cellpadding="5" cellspacing="0">
<tr> <td>
<label for="EmergencyContactName"><b>Emergency Contact Name</b></label><br />
<input name="EmergencyContactName" type="text" maxlength="50" style="width: 260px" />
</td>  
<td>
<label for="EmergencyContactPhone"><b>Emergency Contact Phone</b></label><br />
<input name="EmergencyContactPhone" type="text" maxlength="50" style="width: 260px" />
</td> </tr>
-->



<!--
<!DOCTYPE html>
<html>
<head>
<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
 
 
<title>Add Employee</title>
</head>
<body>
 
<form method="post" action="">
<label>First Name</label>
<input type="text" name="first_name" />
<br />
<label>Last Name</label>
<input type="text" name="last_name" />
<br />
<label>Department</label>
<input type="text" name="department" />
<br />
<label>Email</label>
<input type="text" name="email" />
 
<br />
<input type="submit" value="Add Employee">
</form>
 
 
 
</body>
</html>
-->