<?php
	session_start();
	include '../Database/connect.php';
	
	//Check connection
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {

		$interaction_id = $_SESSION['interaction_id'];
		
		$stmt = $conn->prepare("INSERT INTO distributor_quote_form (
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
					range2240, 
					range1122, 
					range610, 
					range24)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		

		$stmt->bind_param("isssssissssssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc, 
		                  $ltlQuantities, $annualVol, $specialTerms, $OEM, $application, 
		                  $truckLoad, $range2240, $range1122, $range610, $range24); 
		
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
		$range2240 = $_POST["range2240"];
		$range1122 = $_POST["range1122"];
		$range610 = $_POST["range610"];
		$range24 = $_POST["range24"];
		
		$stmt->execute();
		

		/*Don't need to check if true -> preparing and executing does this already*/
//		if ($conn->query($sql)===TRUE) {
			
//			echo "New record created successfully<br/>";
		

				$getFormId = "SELECT distributor_quote_id FROM distributor_quote_form ORDER BY distributor_quote_id DESC";
				$formId = $conn->query($getFormId);
				$id_form = mysqli_fetch_array($formId);

			
				
				$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['distributor_quote_id'] . ", '4')";				
				
				if ($conn->query($insert_into_interaction_relational_manager_table)===TRUE)
				{
					echo "Inserted into interation relational manager table";
				}
				else
				{
				    echo "Error: " . $conn->error;
				}	
	
		
//		} else {
			
//		    echo "Error: " . $sql . " " . $conn->error;
//		}

		
		$stmt->close();
		$conn->close();
		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
	}

?>
