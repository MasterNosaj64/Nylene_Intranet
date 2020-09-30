<?php
	session_start();
	include '../Database/connect.php';

	// Check connection
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {


		$interaction_id = $_SESSION['interaction_id'];

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
		
		
/*		$sql = "INSERT INTO ltl_quote (date_created, 
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
						VALUES ('".$_POST["date_created"]."', 
								'".$_POST["quote_num"]."', 
								'".$_POST["product_name"]."', 
								'".$_POST["payment_terms"]."', 
								'".$_POST["product_desc"]."', 
								'".$_POST["ltl_quantities"]."', 
								'".$_POST["annual_vol"]."', 
								'".$_POST["special_terms"]."', 
								'".$_POST["OEM"]."', 
								'".$_POST["application"]."', 
								'".$_POST["truck_load"]."', 
								'".$_POST["range1522"]."', 
								'".$_POST["range1121"]."', 
								'".$_POST["range510"]."', 
								'".$_POST["range25"]."', 
								'".$_POST["range12"]."', 
								'".$_POST["range5"]."')";
	*/

		$stmt->bind_param("isssssisssissssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range1522, $range1121, $range510, $range25, $range12, $range5);
		
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
		$range1522 = $_POST["range1522"];
		$range1121 = $_POST["range1121"];
		$range510 = $_POST["range510"];
		$range25 = $_POST["range25"];
		$range12 = $_POST["range12"];
		$range5 = $_POST["range5"];
		
		$stmt->execute();

/*		if ($conn->query($sql)===TRUE) {
		
		echo "New record created successfully<br/>";
*/	
				//tl = ltl_quote_id
				$getFormId = "SELECT ltl_quote_id FROM ltl_quote ORDER BY ltl_quote_id DESC";
				$formId = $conn->query($getFormId);
				$id_form = mysqli_fetch_array($formId);

				$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['ltl_quote_id'] . ", '2')";
					
				if ($conn->query($insert_into_interaction_relational_manager_table)===TRUE)
				{
					echo "Inserted into interation relational manager table";
					echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
					exit();
					
    			}
				else
				{
				    echo "Error: " . $conn->error;
				}	
/*
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}*/
	
	$stmt->close();
	$conn->close();
	}

?>

