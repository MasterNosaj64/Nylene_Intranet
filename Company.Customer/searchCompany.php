<?php
/*
 * FileName: searchCompany.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 *  Search for companies in the database.
 */
session_start();

//the following variables are used in navigation.php
//View navigation.php for more information
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

//The navigation bar for the website
include '../navigation.php';

//connection to the database
include '../Database/connect.php';

//Handler for if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    /*
     * The following code handles the offset for the list of companies
     * Below is an explaination of the variables
     *      next10: the next 10 button
     *      previous10: the previous 10 button
     *      offset: the current offset value for the following query
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
    
    if (isset($_POST['search_By_Name'])) {
        $length = strlen($_POST['search_By_Name']);
        $sqlquery = "SELECT * FROM nylene.company WHERE SUBSTRING(company_name,1," . $length . ") = '" . $_POST['search_By_Name'] . "' ORDER BY company_name ASC";
        $result = $conn->query($sqlquery);

    } else if (isset($_POST['search_By_Website'])) {

        $length = strlen($_POST['search_By_Website']);
        $sqlquery = "SELECT * FROM nylene.company WHERE SUBSTRING(website,1," . $length . ") = '" . $_POST['search_By_Website'] . "' ORDER BY company_name ASC";
        $result = $conn->query($sqlquery);

    } else {

        $sqlquery = "SELECT * FROM nylene.company ORDER BY company_name ASC LIMIT 10 OFFSET " . $_POST['offset'];
        $result = $conn->query($sqlquery);
    }
    $conn->close();
}
?>
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<!-- Company Search -->
<!-- Below is the search by company name and search by website functionality -->
<table class="form-table" border=5>
	<tr>
		<form method="post" action=searchCompany.php name="search_companyName">
			<td>Name:</td>
			<td><input type="text" required name="search_By_Name" /></td>
			<td><input type="submit" value="Search" /></td>
		</form>
		<form method="post" action=searchCompany.php
			name="search_companyWebsite">
			<td>Website:</td>
			<td><input type="url" required value="http://"
				name="search_By_Website" /></td>
			<td><input type="submit" value="Search" /></td>
		</form>
		<form method="post" action=searchCompany.php name=reset>
			<td><input type="submit" value="Reset" /></td>
		</form>
	</tr>
</table>

<!-- Company Search -->
<!-- Below is the table that is presented to the user for the query results on the Company table -->

<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Name</td>
			<td>Website</td>
			<td>Email</td>
			<td>Billing Street</td>
			<td>Billing City</td>
			<td>Billing State</td>
			<td>Menu</td>
		</tr>
	</thead>

	<!-- </head> </html> -->
	<?php

/*
 * Each row of the SQL query is printed in sequence
 * This includes Edit and View buttons
 */
while ($row = mysqli_fetch_array($result)) {

    echo "<tr><td>" . $row["company_name"] . "</td><td><a href=\"" . $row["website"] . "\">" . $row["website"] . "</a></td><td><a href =\"mailto: " . $row["company_email"] . "\">" . $row["company_email"] . "</a></td><td>" . $row["billing_address_street"] . "</td><td>" . $row["billing_address_city"] . "</td><td>" . $row["billing_address_state"] . "</td>
<td><form action=\"./editCompany.php\" method=\"post\">
		<input hidden name =\"company_id_edit\" value=\"" . $row['company_id'] . "\"/>
		<input type=\"submit\" value=\"edit\"/>
	</form>
    <form action=\"./viewCompany.php\" method=\"post\">
		<input hidden name =\"company_id_view\" value=\"" . $row['company_id'] . "\"/>
		<input type=\"submit\" value=\"view\"/>
	</form>




   </td></tr>";
}
?>

<!-- Next 10 Previous 10 Buttons -->
<!-- The following code presents the user with buttons to navigate the query -->
<table class="form-table" border=0 align:center;>
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