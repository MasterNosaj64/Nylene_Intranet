<!DOCTYPE html>

<?php
	session_start();
	$id = $_POST["id"]; 

	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene_database";
	$connect     = new mysqli($host, $username, $password, $dbname);

	if (mysqli_connect_error())
	{
		die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error);
	}
	else
	{
		echo "Connected Successfully!";

		$query_samples				= "SELECT * FROM interaction 
										INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
											INNER JOIN marketing_request_form ON marketing_request_form.marketing_request_id = interaction_relational_form.form_id
												INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id
													WHERE interaction_relational_form.form_type = 1 AND interaction.employee_id = " . $_SESSION["userid"] . "
														AND marketing_request_form.marketing_request_id = " . $id;
	}
?>

<html>
	<body>

	</body>
</html>