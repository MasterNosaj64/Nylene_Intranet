<?php
/*
 * FileName: addInteraction.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 * View a list of interactions for the company
 */
session_start();

//the following variables are used in navigation.php
//View navigation.php for more information
unset($_SESSION['interaction_id']);
//The navigation bar for the website
include '../navigation.php';
//connection to the database
include '../Database/connect.php';

//Handler for if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    if ($_SESSION['company_id'] != "") {

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

        $_SESSION['companyHistoryPage'] = $_SESSION['company_id'];

        // Get Interactions for Company by company_id
        $sqlquery = "SELECT * FROM nylene.interaction WHERE company_id = " . $_SESSION['company_id'] . " ORDER BY date_created ASC LIMIT 10 OFFSET " . $_POST['offset'];
        $result = $conn->query($sqlquery);

        // Get company info
        $sqlGetCompany = "SELECT * FROM nylene.company WHERE company_id = " . $_SESSION['company_id'];
        $getCompanyInfo = $conn->query($sqlGetCompany);
        $companyInfo = mysqli_fetch_array($getCompanyInfo);

        $companyAddress = $companyInfo["billing_address_street"] . ", " . $companyInfo["billing_address_city"] . ", " . $companyInfo["billing_address_state"] . ", " . $companyInfo["billing_address_country"] . ", " . $companyInfo["billing_address_postalcode"];
        echo "<link rel=\"stylesheet\" href=\"table.css\">";
        echo "<table class =\"form-table\" border=5>";
        echo "<tr><td>Company:</td><td>" . $companyInfo["company_name"] . "</td><td>Address:</td><td>$companyAddress</td></tr>";
        echo "<tr><td>Website:</td><td><a href=\"" . $companyInfo["website"] . "\">" . $companyInfo["website"] . "</a></td><td>Email:</td><td><a href=\"mailto: " . $companyInfo["company_email"] . "\">" . $companyInfo["company_email"] . "</a></td></tr>";
        echo "</table>";

    } else {
        //If the above results in error redirect the user to homepage
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
        exit();
    }
}
?>

<!-- Company History -->
<!-- Below is the interface for all interactions assigned to the company -->

<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<!-- Button to add an interaction -->
<form method="post" action="AddInteraction.php">
	<input hidden name="company_id"
		value="<?php echo $_SESSION['company_id'];?>" /> <input type="submit"
		id="create_interaction" name="create_interaction"
		value="Create Interaction" />
</form>

<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Date</td>
			<td>Customer</td>
			<td>Reason</td>
			<td>Notes</td>
			<td>Manage</td>
		</tr>
	</thead>
	<?php
//Prints a row for every interaction in the query
while ($row = mysqli_fetch_array($result)) {
    $sqlGetCustomerID = "SELECT * FROM nylene.customer WHERE customer_id =" . $row["customer_id"];
    $getCustomerName = $conn->query($sqlGetCustomerID);
    $customerName = mysqli_fetch_array($getCustomerName);
    echo "<tr><td>" . $row["date_created"] . "</td><td>" . $customerName["customer_name"] . "</td><td>" . $row["reason"] . "</td><td>" . substr($row["comments"], 0, 50) . "</td><td>

<form method=\"post\" action=\"viewInteraction.php\">
<input hidden type=\"text\" name=\"interaction_id\" value=\"" . $row["interaction_id"] . "\">
<input type=\"submit\" value=\"view\"/>
</form>
</td></tr>";
}
$conn->close();
?>

<!-- Next 10 Previous 10 Buttons -->
<!-- The following code presents the user with buttons to navigate the query -->
<table class="form-table"align:center;>
		<td>
			<form method="post" action="companyHistory.php">
				<input hidden name="previous10"
					value="<?php echo $_POST['offset'];?>" /> <input type="submit"
					value="Previous 10" />
			</form>
		</td>

		<td>
			<form method="post" action="companyHistory.php">
				<input hidden name="next10" value="<?php echo $_POST['offset'];?>" />
				<input type="submit" value="Next 10" />
			</form>
		</td>

	</table>
	</html>