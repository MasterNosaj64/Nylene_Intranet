<?php
	session_start();
	include '../Database/connect.php';

	// Check connection
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {


		$interaction_id	= $_SESSION['interaction_id'];
		
		$stmt = $conn->prepare("INSERT INTO tl_quote (
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
                    range40plus,
					range2240,
					range1022,
					range610,
                    range46,
					range24)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		
		$stmt->bind_param("isssssisssissssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range40up, $range2240, $range1022, $range610, $range46, $range24);
		
		$dateCreated = $_POST["date_created"];
		$quoteNum = $_POST["quote_num"];
		$productName = $_POST["product_name"];
		$payment_terms = $_POST["payment_terms"];
		$productDesc = $_POST["product_desc"];
		$ltlQuantities = $_POST["ltl_quantities"]; //this needs to be updated to text in the db, not sure why it's an int
		$annualVol = $_POST["annual_vol"];
		$specialTerms = $_POST["special_terms"];
		$OEM = $_POST["OEM"];
		$application = $_POST["application"];
		$truckLoad = $_POST["truck_load"];
		$range40up = $_POST["range40up"];
		$range2240 = $_POST["range2240"];
		$range1022 = $_POST["range1022"];
		$range610 = $_POST["range610"];
		$range46 = $_POST["range46"];
		$range24 = $_POST["range24"];
		
		$stmt->execute();
		

/*		if ($conn->query($sql)===TRUE) {
		echo "New record created successfully<br/>";
	
*/
		$getFormId = "SELECT tl_quote_id FROM tl_quote ORDER BY tl_quote_id DESC";
		$formId = $conn->query($getFormId);
		$id_form = mysqli_fetch_array($formId);

		$stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id, 
                    form_id, 
                    form_type) 
                    VALUES (?, ?, ?)");
		$stmt2->bind_param("iii", $interactionNum, $formID, $formType);
		
		
/*		$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['tl_quote_id'] . ", '3')";
					
*/		
		$interactionNum = $interaction_id;
        $formID = $id_form['tl_quote_id'];
        $formType = 3;
        $stmt2->execute();
        
        $stmt->close();
        $stmt2->close();
        $conn->close();
	/*			if ($conn->query($insert_into_interaction_relational_manager_table)===TRUE)
				{
					//echo "Inserted into interation relational manager table"; */
		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
/*			}
				else
				{
				    echo "Error: " . $conn->error;
				}	
*/
/*	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
*/
		
	}

?>
