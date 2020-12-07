<?php
/*
 * FileName: viewInteraction.php
 * Version Number: 2.0
 * Date Modified: 12/7/2020
 * Author: Jason Waid, Modified by Kaitlyn Breker and Ahmad Syed
 * Purpose:
 * View interaction data in the database.
 */
session_start();

// interaction object
include '../Database/Interaction.php';

// customer object
include '../Database/Customer.php';

// company object
include '../Database/Company.php';

// nav bar
include '../NavPanel/navigation.php';

// connection to the database
include '../Database/connect.php';

$conn_Interaction = getDBConnection();

$conn_Company = getDBConnection();

$conn_Customer = getDBConnection();

$conn_Forms = getDBConnection();

if (isset($_GET['interaction_id'])) {

    $_POST['interaction_id'] = $_GET['interaction_id'];
}

if (isset($_POST['interaction_id'])) {

    // the following variables are used in navigation.php
    // View navigation.php for more information
    $_SESSION['interaction_id'] = $_POST['interaction_id'];
    // The navigation bar for the website

    // Handler for if the database connection fails
    if ($conn_Interaction->connect_error || $conn_Company->connect_error || $conn_Customer->connect_error || $conn_Forms->connect_error) {
        die("Connection failed: " . $conn_Interaction->connect_error . " || " . $conn_Company->connect_error . " || " . $conn_Customer->connect_error . " || " . $conn_Forms->connect_error);
    } else {

        $interaction = new Interaction($conn_Interaction);
        $interaction = $interaction->searchId($_SESSION['interaction_id']);

        $_SESSION['company_id'] = $interaction->getCompanyId();

        $company = new Company($conn_Company);
        $company = $company->searchId($interaction->getCompanyId());
        $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCountry()}, {$company->getBillingAddressPostalCode()}";

        $customer = new Customer($conn_Customer);
        $customer = $customer->searchById($interaction->getCustomerId());

        $query_view_form = "SELECT * FROM nylene.interaction_relational_form WHERE interaction_id = " . $_SESSION['interaction_id'];
        $viewInteractionForm = mysqli_fetch_array($conn_Forms->query($query_view_form));

        $conn_Interaction->close();
        $conn_Company->close();
        $conn_Customer->close();
        $conn_Forms->close();
    }
} else {
    // If the above results in error redirect the user to homepage
    ?>
<meta http-equiv="refresh" content="0 url = ../Home/Homepage.php" />
";
    <?php
    exit();
}
?>
<!-- Table containing the company/customer information -->
<html>
<head>
<title>View Interaction</title>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<body>

	<form name="edit_interaction" action="editInteraction.php"
		method="post">
		<input hidden="true" type="text" name="interaction_id"
			value="<?php echo $interaction->getInteractionId();?>"> <input
			type="Submit" id="edit_interaction" style="width: 100%"
			value="Edit Interaction">
	</form>

	<!-- <h1>Interaction</h1> -->
	<table class="form-table" border="1">
		<tr>
			<td>Company:</td>
			<td><?php echo $company->getName();?></td>
			<td>Address:</td>
			<td><?php echo $companyAddress;?></td>
			<td>Company Email:</td>
			<td><a href="mailto:<?php echo $company->getEmail();?>"><?php echo $company->getEmail();?></a></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?php echo $customer->getName();?></td>
			<td>Email:</td>
			<td><a href="mailto: <?php echo $customer->getEmail();?>"><?php echo $customer->getEmail();?></a></td>
			<td>Phone:</td>
			<td><?php echo $customer->getPhone();?></td>
		</tr>
		<tr>

			<td>Reason:</td>
			<td colspan=3><?php echo $interaction->getReason();?></td>

			<td>Date Created:</td>
			<td><?php echo $interaction->getDateCreated();?></td>
		</tr>
		<tr>
			<td>Interaction Status:</td>
			<td>
			<?php
/* status of the interaction open/closed */
if ($interaction->getStatus() == 'open') {
    echo 'Open';
} else if ($interaction->getStatus() == 'closed') {
    echo 'Closed';
} else {
    echo '--';
}
?>
     	   	</td>
			<td>Follow Up Type:</td>
			<td>
			<?php
/* switch between the type in the db */
switch ($interaction->getFollowUpType()) {
    case 'interaction':
        echo 'Follow up based on interaction date';
        break;
    case 'form':
        echo 'Follow up based on form date';
        break;
    case 'manual':
        echo 'Follow up determined by user';
        break;
    case 'none':
        echo 'No follow up required';
        break;
    default:
        echo 'No follow up designated';
        break;
}
?>
			</td>
			<td>Follow Up Date:</td>
			<td>
    			<?php
    /* display followupdate or no date */
    if ($interaction->getFollowUpDate() == 0) {
        echo '--';
    } else {
        echo $interaction->getFollowUpDate();
    }
    ?>
			</td>
		
		
		<tr>
			<td>Form:</td>
		
<?php

if ($viewInteractionForm != null) {

    // Sample Form
    if ($viewInteractionForm['form_type'] == 1) {
        ?>
        <td>
				<form method="post" action="../Forms/sample_form_view.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%" value="View Sample Request Form" />
				</form>
			</td>
			<td>
				<form method="post" action="../Forms/editSample.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%" value="Edit Sample Request Form" />
				</form>
			</td>
			<td><form method="post" target="_blank"
					action="../Nylene_TCPDF_Forms/sampleForm_TCPDF.php?id=<?php echo $viewInteractionForm['form_id'];?>">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="image" src="../Graphics/export-pdf-icon.png"
						alt="Click To Export" />
				</form></td>
    <?php
    } // Light Truck Load Quote Form
    else if ($viewInteractionForm['form_type'] == 2) {
        ?>
        <td>
				<form method="post" action="../Forms/viewLtlQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="View Light Truckload Form" />
				</form>
			</td>
			<td>
				<form method="post" action="../Forms/editLtlQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" value="Edit Light Truckload Form" />
				</form>
			</td>
			<td><form method="post" target="_blank"
					action="../Nylene_TCPDF_Forms/ltlQuoteForm_TCPDF.php?id=<?php echo $viewInteractionForm['form_id'];?>">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="image" src="../Graphics/export-pdf-icon.png"
						alt="Click To Export" />
				</form></td>
    <?php
    } // Truck Load Quote Form
    else if ($viewInteractionForm['form_type'] == 3) {
        ?>
        <td>
				<form method="post" action="../Forms/viewTlQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="View Truckload Quote Form" />
				</form>
			</td>
			<td>
				<form method="post" action="../Forms/editTlQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="Edit Truckload Quote Form" />
				</form>
			</td>
			<td><form method="post" target="_blank"
					action="../Nylene_TCPDF_Forms/tlQuoteForm_TCPDF.php?id=<?php echo $viewInteractionForm['form_id'];?>">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="image" src="../Graphics/export-pdf-icon.png"
						alt="Click To Export" />
				</form></td>
    <?php
    } // Distributor Quote Form
    else if ($viewInteractionForm['form_type'] == 4) {
        ?>
        <td>
				<form method="post" action="../Forms/viewDistributorQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="View Distributor Quote Form" />
				</form>
			</td>
			<td>
				<form method="post" action="../Forms/editDistributorQuote.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="Edit Distributor Quote Form" />
				</form>
			</td>
			<td><form method="post" target="_blank"
					action="../Nylene_TCPDF_Forms/distributorQuoteForm_TCPDF.php?id=<?php echo $viewInteractionForm['form_id'];?>">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="image" src="../Graphics/export-pdf-icon.png"
						alt="Click To Export" />
				</form></td>
    <?php
    } // Marketing Request Form
    else if ($viewInteractionForm['form_type'] == 5) {
        ?>
        <td>
				<form method="post" action="../Forms/viewMarketRequest.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%" value="View Market Request Form" />
				</form>
			</td>
			<td>
				<form method="post" action="../Forms/editMarketRequest.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%" value="Edit Market Request Form" />
				</form>
			</td>
  <?php
    } // Business Credit Application Form
    else if ($viewInteractionForm['form_type'] == 6) {
        ?>
       <td>
				<form method="post"
					action="../Forms/viewCreditBusinessApplication.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="View Business Credit App. Form" />
				</form>
			</td>
			<td>
				<form method="post"
					action="../Forms/editCreditBusinessApplication.php">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="submit" style="width: 100%"
						value="Edit Business Credit App. Form" />
				</form>
			</td>
			<td><form method="post" target="_blank"
					action="../Nylene_TCPDF_Forms/creditBusinessApp_TCPDF.php?id=<?php echo $viewInteractionForm['form_id'];?>">
					<input hidden="true" type="text" name="id"
						value="<?php echo $viewInteractionForm['form_id']; ?>"> <input
						type="image" src="../Graphics/export-pdf-icon.png"
						alt="Click To Export" />
				</form></td>
   <?php
    }
} else { // No Form ?>
<td colspan="5">--</td>
<?php
}
?>
    </tr>
		<tr>
			<td colspan=6><textarea readonly rows="20" cols="100"><?php echo $interaction->getComments(); ?> </textarea></td>
		</tr>
	</table>
</body>
</html>
