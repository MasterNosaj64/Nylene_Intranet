<?php
    /* Name: newLtlQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: November 5th, 2020
     * Purpose: File called when user clicks submit on the input light truckload form. Inserts form information into 
     *          the ltl_quote table of the database.
     */

    session_start();
	include '../Database/connect.php';

	$conn = getDBConnection();
	
	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {

		$interaction_id = $_SESSION['interaction_id'];

		/*Prepare insert statement into the ltl_quote table*/
		$stmt = $conn->prepare("INSERT INTO ltl_quote (
					date_created,
					quote_num,
					product_name,
					payment_terms,
					product_desc,
					ltl_quantities,
					annual_vol,
					special_terms,
					OEM,
					application,
					truck_load,
					range1522,
					range1121,
					range510,
					range25,
                    range12, 
					range5)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		
		/*Assign values to variables and execute*/
		$dateCreated = htmlspecialchars(strip_tags($_POST["date_created"]));
		$quoteNum = htmlspecialchars(strip_tags($_POST["quote_num"]));
		$productName = htmlspecialchars(strip_tags($_POST["product_name"]));
		$payment_terms = htmlspecialchars(strip_tags($_POST["payment_terms"]));
		$productDesc = htmlspecialchars(strip_tags($_POST["product_desc"]));
		$ltlQuantities = htmlspecialchars(strip_tags($_POST["ltl_quantities"])); 
		$annualVol = htmlspecialchars(strip_tags($_POST["annual_vol"]));
		$specialTerms = htmlspecialchars(strip_tags($_POST["special_terms"]));
		$OEM = htmlspecialchars(strip_tags($_POST["OEM"]));
		$application = htmlspecialchars(strip_tags($_POST["application"]));
		$truckLoad = htmlspecialchars(strip_tags($_POST["truck_load"]));
		$range1522 = htmlspecialchars(strip_tags($_POST["range1522"]));
		$range1121 = htmlspecialchars(strip_tags($_POST["range1121"]));
		$range510 = htmlspecialchars(strip_tags($_POST["range510"]));
		$range25 = htmlspecialchars(strip_tags($_POST["range25"]));
		$range12 = htmlspecialchars(strip_tags($_POST["range12"]));
		$range5 = htmlspecialchars(strip_tags($_POST["range5"]));
		
		/*Bind statement parameters to statement*/
		$stmt->bind_param("ssssssisssissssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range1522, $range1121, $range510, $range25, $range12, $range5);
		
		$stmt->execute();
	
		/*Select the form Id from the database*/
		$getFormId = "SELECT ltl_quote_id FROM ltl_quote ORDER BY ltl_quote_id DESC";
		$formId = $conn->query($getFormId);
		$id_form = mysqli_fetch_array($formId);

		/*Prepare insert statement into the interaction_relational_form table*/
		$stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id,
                    form_id,
                    form_type)
                    VALUES (?, ?, ?)");
		
		/*Bind statement parameters to statement*/
		$stmt2->bind_param("iii", $interactionNum, $formID, $formType);
		
		/*Assign values to variables and execute*/
		$interactionNum = $interaction_id;
		$formID = $id_form['ltl_quote_id'];
		$formType = 2;
		
		$stmt2->execute();
		
		/*Close statements and connection*/
		$stmt->close();
		$stmt2->close();
		$conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
					
	}

?>

