<?php
// session_start();
if (! session_id()) {
    session_start();
}

include 'navigation.php';
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="table.css">
</head>
<body onload="myFunction()">

	<form method="post" action="afterEditUser.php">



		<table class="form-table" border="1" cellpadding="5" cellspacing="0">
<thead>
			<tr>
				<td border=0 colspan="2" style="text-align: center;"><b>- Fill all the
					fields that need to be changed with new values -</b></td>
			</tr></thead>
<thead>
			<tr>
				<td id="column_heading" colspan="2" style="text-align: center;">Primary
					Information</td>
			</tr></thead>

		</table>
		<table class="form-table" border="1" cellpadding="5" cellspacing="0">
			<!--<tr>
	<td colspan="2">
	<label for="employee_id"><b>Employee ID*</b></label><br/>
	<input name="employee_id" type="text" maxlength="100" style="width: 535px" />
	</td> </tr>-->
			<tr>
				<td style="width: 50%"><label for="first_name">First Name *</label><br /> <input
					name="first_name" type="user" maxlength="50" /></td>
				<td style="width: 50%"><label for="last_name">Last Name *</label><br /> <input
					name="last_name" type="user" maxlength="50" /></td>
			</tr>
			<tr>
				<td style="width: 50%"><label for="title">Title *</label><br /> <select id="options"
					name="title">
						<option value=""></option>
						<option value="admin">Admin</option>
						<option value="sales_rep">Sales Rep</option>
						<option value="sales_manager">Sales Manager</option></td>
				<td><label for="department">Department</label><br /> <input
					name="department" type="user" maxlength="50" /></td>
			</tr>

			<tr>
				<td><label for="work_phone">Work Phone *</label><br /> <input
					name="work_phone" type="user" maxlength="50" /></td>
				<td><label for="reports_to">Reports to</label><br /> <select
					id="options" name="reports_to">
		<?php
$connect = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connect, "nylene");
$sql = "SELECT * FROM employee";
$query = mysqli_query($connect, $sql);
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
			</tr></thead>
		</table>
		<table class="form-table" border="1" cellpadding="5" cellspacing="0">
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

				<td colspan="2"><label for="date_modified">Date Modified *</label><br />
					<input name="date_modified" type="date" class="theDate"
					maxlength="100" readonly /></td>

			</tr>

			<tr>
				<td><label for="modified_by">Modified By *</label><br /> <input
					name="modified_by" type="text" maxlength="50"
					value="<?php echo $_SESSION['userid']?>" readonly /></td>
				<td style="width: 50%"><label for="username">Username *</label><br /> <input
					name="username" type="text" maxlength="50"  />
				</td>
			</tr>


			<tr>

				<td style="width: 50%"><label for="is_administrator"> Admin</label><br />
					<select id="options" name="is_administrator">
						<option value=""></option>

						<option value="1">Yes</option>
						<option value="0">No</option>

				</select></td>
				<td style="width: 50%"><label for="STATUS">Status</label><br />
					<input name="STATUS" type="text" maxlength="100"
					s/></td>

			</tr>

			<tr>
				<td colspan="2"><label for="employee_email">Email *</label><br />
					<input name="employee_email" type="text" maxlength="100"
					 /></td>
			</tr>
			<tr>
				<td colspan="2"><label for="password">Password *</label><br />
					<input name="password" type="text" maxlength="100"
					 /></td>
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


