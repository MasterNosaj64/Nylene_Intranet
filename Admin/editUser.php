<?php
// session_start();
if (! session_id()) {
    session_start();
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}

include '../NavPanel/navigation.php';
include '../Database/databaseConnection.php';
include '../Database/connect.php';

$val1=1;
/*
$json = filter_input(INPUT_POST, 'json');
 $decoded_json = json_decode($json);
 $val1 = $decoded_json->val1;
 var_dump($decoded_json, $val1);
 */










$_SESSION['field']=$val1;
$field=$_SESSION['field'];
$sql = "SELECT * FROM employee WHERE employee_id=$field"; 
$query = mysqli_query($conn, $sql);

$rows=mysqli_fetch_array($query);





$first_name=$rows['first_name'];
$last_name=$rows['last_name'];
$title=$rows['title'];
$department=$rows['department'];
$work_phone=$rows['work_phone'];
$reports_to=$rows['reports_to'];
$date_entered=date("Y-m-d");
$date_modified=date("Y-m-d");
$modified_by=$rows['userid'];
$username=$rows['username'];
$is_administrator=$rows['is_administrator'];
$STATUS=$rows['STATUS'];
$employee_email=$rows['employee_email'];




?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<body>

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
	
			<tr>
				<td style="width: 50%"><label for="first_name">First Name </label><br /> <input
					name="first_name" type="user" maxlength="50" value="<?php echo $first_name; ?>"/></td>
				<td style="width: 50%"><label for="last_name">Last Name </label><br /> <input
					name="last_name" type="user" value="<?php echo $last_name; ?>" maxlength="50" /></td>
			</tr>
			<tr>
				<td style="width: 50%"><label for="title">Title </label><br /> <select id="options"
					name="title">
						<option value="<?php echo $title; ?>"></option>
						<option value="admin">Admin</option>
						<option value="sales_rep">Sales Rep</option>
						<option value="sales_manager">Sales Manager</option></td>
				<td><label for="department">Department</label><br /> <input
					name="department" type="user" value="<?php echo $department; ?>" maxlength="50" /></td>
			</tr>

			<tr>
				<td><label for="work_phone">Work Phone </label><br /> <input
					name="work_phone" type="user" value="<?php echo $work_phone; ?>" maxlength="50" /></td>
				<td><label for="reports_to">Reports to</label><br /> <select
					id="options" name="reports_to">
		<?php

$sql = "SELECT * FROM employee";
$query = mysqli_query($conn, $sql);
echo '<option value="$reports_to"></option>';
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


				
				<td style="width: 50%"><label for="username">Username </label><br /> <input
					name="username" type="text" value="<?php echo $username; ?>" maxlength="50"  />
				</td>
			</tr>


			<tr>

				<td style="width: 50%"><label for="is_administrator"> Admin</label><br />
					<select id="options" name="is_administrator">
						<option value="<?php echo $is_administrator; ?>"></option>

						<option value="1">Yes</option>
						<option value="0">No</option>

				</select></td>
				<td style="width: 50%"><label for="STATUS">Status</label><br />
					<input name="STATUS" type="text" value="<?php echo $STATUS; ?>" maxlength="100"
					s/></td>

			</tr>

			<tr>
				<td colspan="2"><label for="employee_email">Email </label><br />
					<input name="employee_email" type="text"  value="<?php echo $employee_email; ?>" maxlength="100"
					 /></td>
			</tr>
			<tr>
				<td colspan="2"><label for="password">Password </label><br />
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


