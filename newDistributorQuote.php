<?php
	session_start();
	include 'db_config.php';
	
	//Check connection
	if ($dbConnection-> connect_error) {
		
		die("Connection failed: " . $dbConnection-> connect_error);
	
	} else {

		
		$interaction_id = $_SESSION['interaction_id'];
	

		$sql = "INSERT INTO distributor_quote_form (
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
					'".$_POST["range2240"]."', 
					'".$_POST["range1122"]."', 
					'".$_POST["range610"]."', 
					'".$_POST["range24"]."')";
		

		if ($dbConnection->query($sql)===TRUE) {
			
			echo "New record created successfully<br/>";
		

				$getFormId = "SELECT distributor_quote_id FROM distributor_quote_form ORDER BY distributor_quote_id DESC";
				$formId = $dbConnection->query($getFormId);
				$id_form = mysqli_fetch_array($formId);

			
				
				$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['distributor_quote_id'] . ", '4')";				
				
				if ($dbConnection->query($insert_into_interaction_relational_manager_table)===TRUE)
				{
					echo "Inserted into interation relational manager table";
				}
				else
				{
					echo "Error: " . $dbConnection->error;
				}	
	
		
		} else {
			
			echo "Error: " . $sql . " " . $dbConnection->error;
		}

		$dbConnection->close();
		echo "<meta http-equiv = \"refresh\" content = \"0; url = ./companyHistory.php\" />;";
		exit();
	}

?>
