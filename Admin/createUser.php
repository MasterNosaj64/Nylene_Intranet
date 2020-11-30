
<?php
session_start();
// TODO: MADHAV change database connection file and align code to mysqli standard
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../NavPanel/navigation.php';
include '../Database/databaseConnection.php';
include '../Database/connect.php';

// TODO: MADHAV call getDBConnection to get connection
// $conn = getDBConnection();

$accessLevel = $_SESSION['role'];

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<body onload="myFunction()">
	<form method="post" action="employee_database.php"
		onsubmit="return ValidateForm(this)";>
		<script type="text/javascript">
function ValidateForm(frm) {
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



		<table class="form-table" border="1" cellpadding="5" cellspacing="0">


			<thead>
				<tr>
					<td id="column_heading" colspan="2" style="text-align: center;">Standard
						Information</td>
				</tr>
			</thead>

		</table>
		<table class="form-table" border="1" cellpadding="5" cellspacing="0">

			<tr>
				<td><label for="first_name"> First Name *</label> <input
					name="first_name" type="text" maxlength="50" /></td>
				<td style="width: 50%"><label for="last_name">Last Name *</label> <input
					name="last_name" type="text" maxlength="50" /></td>
			</tr>
			<tr>

				<td>Title* <select id="title" name="title">
				
				<?php

    if ($accessLevel == admin) {
        echo '<option style="width: 260px" value=""></option>';
        echo '<option style="width: 260px" value="admin">Administrator</option>';
        echo '<option style="width: 260px" value="supervisor">Supervisor</option>';
        echo '<option style="width: 260px" value="sales_rep">Sales Representative</option>';
        echo '<option style="width: 260px" value="ind_rep">Independent Representative</option>';
    } else if ($accessLevel == supervisor) {
        echo '<option style="width: 260px" value=""></option>';
        echo '<option style="width: 260px" value="sales_rep">Sales Representative</option>';
        echo '<option style="width: 260px" value="ind_rep">Independent Representative</option>';
    }

    ?>
				
								<!--		<option value=""></option>
						<option value="1">Admin</option>
						<option value="2">Manager</option>
						<option value="3">Independent/Member</option>
						-->
				</select>
				</td>


				<td><label for="department">Department</label> <input
					name="department" type="text" maxlength="50" /></td>
			</tr>

			<tr>
				<td><label for="work_phone">Work Phone *</label><br /> <input
					name="work_phone" type="text" maxlength="50" /></td>
				<td>Reports to <select id="employee" name="reports_to">
		<?php
if ($accessLevel == admin) {
    $sql = "SELECT * FROM employee WHERE title='admin' OR title='supervisor'";
} else if ($accessLevel == supervisor) {
    $sql = "SELECT * FROM employee WHERE title='supervisor'";
}
$query = mysqli_query($conn, $sql);
echo '<option style="width: 260px" value=""</option>';
while ($row = mysqli_fetch_array($query)) {
    echo '<option style="width: 260px" value=' . $row['employee_id'] . '>' . $row['first_name'] . " " . $row['last_name'] . '</option>';
}
?>
		</select></td>
			</tr>

		</table>
		<table class="form-table" border="1" cellpadding="5" cellspacing="0">
			<thead>
				<tr>
					<td id="column_heading" colspan="2" style="text-align: center;">Secondary
						Information</td>
				</tr>
			</thead>
		</table>
		<table class="form-table" border="1" cellpadding="5" cellspacing="0">

			<tr>
				<td colspan="2"><label for="username">Username *</label><br /> <input
					name="username" type="text" /></td>
			</tr>

			<tr>


				<td colspan="2" style="width: 100%"><label for="Status">Status</label><br />
					<input name="STATUS" type="text" maxlength="100" /></td>

			</tr>


			<tr>
				<td colspan="2"><label for="employee_email">Email *</label><br /> <input
					name="employee_email" type="text" maxlength="100" /></td>
			</tr>
			<tr>
				<td colspan="2"><label for="password">Password *</label><br /> <input
					type="password" id="password" name="password" type="text"
					maxlength="100" /></td>
			</tr>
		</table>

		<table class="form-table">
			<tr>
				<td><input type="submit" value="Submit"></td>
				<td><input type="reset" value="Reset"></td>
			</tr>
		</table>
	</form>
</body>
</html>




