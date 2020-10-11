<?php
/*
 * FileName: searchCompany.php
 * Version Number: 0.85
 * Date Modified: 10/10/2020
 * Author: Jason Waid
 * Purpose:
 * Search for companies in the database.
 */
session_start();

// the following variables are used in navigation.php
// View navigation.php for more information
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

// The navigation bar for the website
include '../NavPanel/navigation.php';

// connection to the database
include '../Database/connect.php';
// input handling functions

// Company Object
include '../Database/Company.php';

// Employee Object
include '../Database/Employee.php';
// cleans input
/*
 * function clean_input($data) {
 * $data = trim($data);
 * $data = stripslashes($data);
 * $data = htmlspecialchars($data);
 * return $data;
 * }
 */

// Attempt connection to DB for Companies
$conn_Company = getDBConnection();

// Attempt connection to DB for Employees
$conn_Employee = getDBConnection();

// Handler for if the database connection fails
if ($conn_Company->connect_error || $conn_Employee->connect_error) {
    die("A connection failed: Company: " . $conn_Company->connect_error . "|| Employee: " . $conn_employee->connect_error);
} else {

    /*
     * The following code handles the offset for the list of companies
     * Below is an explaination of the variables
     * next10: the next 10 button
     * previous10: the previous 10 button
     * offset: the current offset value for the following query
     *
     */

    if (! isset($_POST['offset'])) {
        $_POST['offset'] = 0;
    }

    if (isset($_POST['next10'])) {
        $_POST['offset'] += 10;
    }

    if (isset($_POST['previous10'])) {
        $_POST['offset'] -= 10;

        if ($_POST['offset'] < 0) {
            $_POST['offset'] = 0;
        }
    }

    /*
     * The following code handles the search by name and website functionality
     * Below is an explaination of the variables
     * search_by_name: value is set to 1 when search button for search by name is used
     * search_by_website: value is set to 1 when search button for search by website is used
     */

    // Querys for getting all employee names

    $employeeList = new Employee($conn_Employee);
    $employeeListResult = $employeeList->read();

    $employeeNames = array();
    $employeeIds = array();
    $numEmployees = 0;

    // Store all employee names and id's in array
    while ($employeeListResult->fetch()) {
        array_push($employeeIds, $employeeList->getId());
        array_push($employeeNames, $employeeList->getName());
        $numEmployees ++;
    }
    $employeeListResult->close();

    /*
     * $sqlquery = "SELECT * FROM nylene.employee";
     * $employeeResult = $conn_Company->query($sqlquery);
     * $createdResult = $conn_Company->query($sqlquery);
     */

    // New Searching technique
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST["search_By_Name"];
        $website = $_POST["search_By_Website"];
        $address = $_POST["search_By_Address"];
        $city = $_POST["search_By_City"];
        $state = $_POST["search_By_State"];
        $country = $_POST["search_By_Country"];
        $assigned_To = $_POST["search_By_Assigned_To"];
        $created_By = $_POST["search_By_Created_By"];

        $companies = new Company($conn_Company);

        $result = $companies->search($name, $website, $address, $city, $state, $country, $assigned_To, $created_By);
    } else {
        $companies = new Company($conn_Company);
        /* $sqlquery = "SELECT * FROM nylene.company ORDER BY company_name ASC LIMIT 10 OFFSET " . $_POST['offset']; */
        $result = $companies->read();
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<!-- NEW Company Search -->
<!-- Below is the NEW search company functionality -->
<button type="button" class="collapsible">Toggle Search</button>
<div class="content">

	<form method="post" action=searchCompany.php name="search_company_data">
		<table class="form-table" border=5>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="search_By_Name" /></td>
				<td>Website:</td>
				<td><input type="text" value="http://" name="search_By_Website" /></td>
				<td>Assigned To:</td>
				<td><select name="search_By_Assigned_To">
						<option></option>
				<?php
    for ($i = 0; $i < $numEmployees; $i ++) {
        echo "<option value=\"" . $employeeIds[$i] . "\">";
        echo $employeeNames[$i] . "</option>";
    }
    ?>
				</select></td>
				<td>Created By:</td>
				<td><select name="search_By_Created_By">
						<option></option>
				<?php
    for ($i = 0; $i < $numEmployees; $i ++) {
        echo "<option value=\"" . $employeeIds[$i] . "\">";
        echo $employeeNames[$i] . "</option>";
    }
    ?>
				</select></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="search_By_Address" /></td>
				<td>City</td>
				<td><input type="text" name="search_By_City" /></td>
				<td>State</td>
				<td><input type="text" name="search_By_State" /></td>
				<td>Country</td>
				<td><input type="text" name="search_By_Country" /></td>

			</tr>
		</table>
		<input type="submit" value="Search" /> <input type="reset"
			value="Clear" />
	</form>

</div>

<!-- Script for collapsible search menu -->
<!-- https://www.w3schools.com/howto/howto_js_collapsible.asp -->
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>

<?php
/*
 * if ($_SERVER["REQUEST_METHOD"] != "POST"){
 * die();
 * }
 */
?>

<!-- Company Search -->
<!-- Below is the table that is presented to the user for the query results on the Company table -->

<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Name</td>
			<td>Website</td>
			<td>Email</td>
			<td>Street</td>
			<td>City</td>
			<td>State</td>
			<td>Assigned To</td>
			<?php
if ($_SESSION["role"] == "admin") {
    echo "<td>Created By</td>";
}
?>
			<td>Menu</td>
		</tr>
	</thead>

	<!-- </head> </html> -->
	<?php

/*
 * Each row of the SQL query is printed in sequence
 * This includes Edit and View buttons
 */
/*
 * while ($row = mysqli_fetch_array($result)) {
 *
 *
 * //Run query if Admin is logged in
 * if($_SESSION["role"] == "admin"){
 * $getCreated_By = "SELECT * FROM nylene.employee WHERE employee_id = ".$row["created_by"]."";
 * $getCreated_By = $conn->query($getCreated_By);
 * $getCreated_By = mysqli_fetch_array($getCreated_By);
 * }
 *
 * $getAssigned_To = "SELECT * FROM nylene.employee WHERE employee_id = ".$row["assigned_to"]."";
 * $getAssigned_To = $conn->query($getAssigned_To);
 * $getAssigned_To = mysqli_fetch_array($getAssigned_To);
 *
 * echo "<tr>";
 * echo "<td>" . $row["company_name"] . "</td>";
 * echo "<td><a href=\"" . $row["website"] . "\">" . $row["website"] . "</a></td>";
 * echo "<td><a href =\"mailto: " . $row["company_email"] . "\">" . $row["company_email"] . "</a></td>";
 * echo "<td>" . $row["billing_address_street"] . "</td>";
 * echo "<td>" . $row["billing_address_city"] . "</td>";
 * echo "<td>" . $row["billing_address_state"] . "</td>";
 * echo "<td>".$getAssigned_To["first_name"]." ".$getAssigned_To["last_name"]."</td>";
 *
 * //Show Created by field if Admin is logged in
 * if($_SESSION["role"] == "admin"){
 * echo "<td>".$getCreated_By["first_name"]." ".$getCreated_By["last_name"]."</td>";
 * }
 *
 * echo "<td><form action=\"./editCompany.php\" method=\"post\">
 * <input hidden name =\"company_id_edit\" value=\"" . $row['company_id'] . "\"/>
 * <input type=\"submit\" value=\"edit\"/>
 * </form>
 * <form action=\"./viewCompany.php\" method=\"post\">
 * <input hidden name =\"company_id_view\" value=\"" . $row['company_id'] . "\"/>
 * <input type=\"submit\" value=\"view\"/>
 * </form>
 * </td>";
 * echo "</tr>";
 * }
 */

// OBJECT VERSION WIP
while ($result->fetch()) {

    // Run query if Admin is logged in
    if ($_SESSION["role"] == "admin") {

        $createdByEmployee = new Employee(getDBConnection());
        $getCreated_By = $createdByEmployee->search($companies->getCreatedBy(), "", "", "", "", "", "", "", "", "", "", "");
        $getCreated_By->fetch();

        /*
         * $getCreated_By = "SELECT * FROM nylene.employee WHERE employee_id = ".$companies->created_by."";
         * $getCreated_By = $conn->query($getCreated_By);
         * $getCreated_By = mysqli_fetch_array($getCreated_By);
         */
    }

    $assignedToEmployee = new Employee(getDBConnection());
    $getAssigned_To = $assignedToEmployee->search($companies->getAssignedTo(), "", "", "", "", "", "", "", "", "", "", "");
    $getAssigned_To->fetch();

    /*
     * $getAssigned_To = "SELECT * FROM nylene.employee WHERE employee_id = ".$companies->assigned_to."";
     * $getAssigned_To = $conn->query($getAssigned_To);
     * $getAssigned_To = mysqli_fetch_array($getAssigned_To);
     */

    echo "<tr>";
    echo "<td>" . $companies->company_name . "</td>";
    echo "<td><a href=\"" . $companies->website . "\">" . $companies->website . "</a></td>";
    echo "<td><a href =\"mailto: " . $companies->company_email . "\">" . $companies->company_email . "</a></td>";
    echo "<td>" . $companies->billing_address_street . "</td>";
    echo "<td>" . $companies->billing_address_city . "</td>";
    echo "<td>" . $companies->billing_address_state . "</td>";
    echo "<td>" . $assignedToEmployee->getName() . "</td>";

    // Show Created by field if Admin is logged in
    if ($_SESSION["role"] == "admin") {
        echo "<td>" . $createdByEmployee->getName() . "</td>";
    }

    echo "<td><form action=\"./editCompany.php\" method=\"post\">
		<input hidden name =\"company_id_edit\" value=\"" . $companies->company_id . "\"/>
		<input type=\"submit\" value=\"edit\"/>
	</form>
    <form action=\"./viewCompany.php\" method=\"post\">
		<input hidden name =\"company_id_view\" value=\"" . $companies->company_id . "\"/>
		<input type=\"submit\" value=\"view\"/>
	</form>
   </td>";
    echo "</tr>";
    $getAssigned_To->close();
    $getCreated_By->close();
}

$conn_Company->close();
?>

<!-- Next 10 Previous 10 Buttons -->
	<!-- The following code presents the user with buttons to navigate the query -->
	<table class="form-table" border=0align:center;>
		<td><form method="post" action="searchCompany.php">
				<input hidden name="previous10"
					value="<?php echo $_POST['offset'];?>" /> <input type="submit"
					value="Previous 10" />
			</form></td>
		<td><form method="post" action="searchCompany.php">
				<input hidden name="next10" value="<?php echo $_POST['offset'];?>" />
				<input type="submit" value="Next 10" />
			</form></td>
	</table>
	</html>