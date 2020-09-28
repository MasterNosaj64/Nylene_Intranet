<?php
	session_start();
	include '../Database/connect.php';

	// Check connection
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {


		$interaction_id = $_SESSION['interaction_id'];

		
		$sql = "INSERT INTO ltl_quote (date_created, 
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
	

		if ($conn->query($sql)===TRUE) {
		
		echo "New record created successfully<br/>";
	
				//tl = ltl_quote_id
				$getFormId = "SELECT tl_quote_id FROM ltl_quote ORDER BY tl_quote_id DESC";
				$formId = $conn->query($getFormId);
				$id_form = mysqli_fetch_array($formId);

				$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['tl_quote_id'] . ", '2')";
					
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

	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	}

?>

