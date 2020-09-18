<?php
	session_start();
	include '../Database/db_config.php';

	// Check connection
	if ($dbConnection-> connect_error) {
	
	die("Connection failed: " . $dbConnection-> connect_error);
	
	} else {


		$interaction_id	= $_SESSION['interaction_id'];
		
		
		$sql = "INSERT INTO tl_quote (date_created, 
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
							range1022, 
							range610, 
							range46, 
							range24)
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
						'".$_POST["range40plus"]."', 
						'".$_POST["range1022"]."', 
						'".$_POST["range610"]."', 
						'".$_POST["range46"]."', 
						'".$_POST["range24"]."')";
	

	if ($dbConnection->query($sql)===TRUE) {
		echo "New record created successfully<br/>";
	


				$getFormId = "SELECT tl_quote_id FROM tl_quote ORDER BY tl_quote_id DESC";
				$formId = $dbConnection->query($getFormId);
				$id_form = mysqli_fetch_array($formId);

				$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['tl_quote_id'] . ", '3')";
					
				if ($dbConnection->query($insert_into_interaction_relational_manager_table)===TRUE)
				{
					//echo "Inserted into interation relational manager table";
					echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
					exit();
				}
				else
				{
					echo "Error: " . $dbConnection->error;
				}	

	} else {
		echo "Error: " . $sql . "<br>" . $dbConnection->error;
	}

	$dbConnection->close();
	}

?>
