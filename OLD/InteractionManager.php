<!DOCTYPE html>

<?php
    include '../navigation.php';
    //$_SESSION["userid"] = 2;

	$userid   = $_SESSION["user_id"];
	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene";
	$conn     = new mysqli($host, $username, $password, $dbname);

	if (mysqli_connect_error())
	{
		die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error);
	}
	else
	{
		$query_samples				= "SELECT * FROM sample_form
										INNER JOIN interaction_relational_form ON interaction_relational_form.form_id = sample_form.sample_form_id
											INNER JOIN interaction ON interaction.interaction_id = interaction_relational_form.interaction_id
												INNER JOIN customer ON customer.customer_id = sample_form.customer_code 
													INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
														INNER JOIN company ON company.company_id = company_relational_customer.company_id
															WHERE interaction_relational_form.form_type = 1 AND interaction.employee_id = " . $_SESSION["user_id"] . "
																ORDER BY sample_form.date_submitted ASC";

		$query_ltl_quotes			= "SELECT * FROM interaction 
											INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
												INNER JOIN ltl_quote ON ltl_quote.tl_quote_id = interaction_relational_form.form_id
													INNER JOIN company_relational_customer ON company_relational_customer.company_id = interaction.company_id
														INNER JOIN company ON company.company_id = company_relational_customer.company_id 
															INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id
																WHERE interaction_relational_form.form_type = 2 AND interaction.employee_id = " . $_SESSION["user_id"] . "
																	ORDER BY interaction.date_created";

		$query_tl_quotes			= "SELECT * FROM interaction 
										INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
											INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
												INNER JOIN company_relational_customer ON company_relational_customer.company_id = interaction.company_id
													INNER JOIN company ON company.company_id = company_relational_customer.company_id 
														INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id
															WHERE interaction_relational_form.form_type = 3 AND interaction.employee_id = " . $_SESSION["user_id"] . "
																ORDER BY interaction.date_created";

		$query_distributor_quotes	= "SELECT * FROM interaction 
										INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
											INNER JOIN distributor_quote_form ON distributor_quote_form.distributor_quote_id = interaction_relational_form.form_id
												INNER JOIN company_relational_customer ON company_relational_customer.company_id = interaction.company_id
													INNER JOIN company ON company.company_id = company_relational_customer.company_id 
														INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id
															WHERE interaction_relational_form.form_type = 4 AND interaction.employee_id = " . $_SESSION["user_id"] . "
																ORDER BY interaction.date_created";

		$query_marketing_requests	= "SELECT * FROM interaction 
										INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
											INNER JOIN marketing_request_form ON marketing_request_form.marketing_request_id = interaction_relational_form.form_id
												INNER JOIN company_relational_customer ON company_relational_customer.company_id = interaction.company_id
													INNER JOIN company ON company.company_id = company_relational_customer.company_id 
														INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id
															WHERE interaction_relational_form.form_type = 5 AND interaction.employee_id = " . $_SESSION["user_id"] . "
																ORDER BY interaction.date_created";
	
		function getMarketRequestForm()
		{
			//Get all the markest request forms 
			$query_distributors_result = $conn->query($query_distributor_quotes);

		}

		$query_samples_result = $conn->query($query_samples);
		$query_ltls_result = $conn->query($query_ltl_quotes);
		$query_tls_result = $conn->query($query_tl_quotes);
		$query_distributors_result = $conn->query($query_distributor_quotes);
		$query_marketing_reqs_result = $conn->query($query_marketing_requests);

		$queries = array();

		if ($query_samples_result)
		{
		} 
		else
		{
			echo "error retrieving samples";
		}

		if ($query_ltls_result)
		{
		} 
		else
		{
			echo "error retrieving ltl quotes";
		}

		if ($query_tls_result)
		{
		} 
		else
		{
			echo "error retrieving tl quotes";
		}

		if ($query_distributors_result)
		{
		} 
		else
		{
			echo "error retrieving distributor quotes";
		}

		if ($query_marketing_reqs_result)
		{
		} 
		else
		{
			echo "error retrieving marketing requests";
		}
	}

	function viewMarketRequest ()
	{
		echo "WORKING";
	}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
		<table border=1 cellspacing=0 cellpadding=15 align=center>
		<tr colspan="6"> <th colspan="6" id="heading1"> <h2> Your Interactions </h2>  </th> </tr>
			<tr colspan="6"> <th colspan="6" id="heading2">  Sample Forms </th> </tr>
			<tr> 
				<th id="heading3"> Company </th> 
				<th id="heading3"> Point of Contact </th>
				<th id="heading3"> Email </th>
				<th id="heading3"> Phone Number </th>
				<th id="heading3"> Date Created </th>
				<th id="heading3"> Options </th>
			<tr/>
			<?php
				while ($row = mysqli_fetch_array($query_samples_result))
				{
					echo "<tr> 
							   <td> " . $row['company_name']   . " </td>
							   <td>	" . $row['customer_name']  . "
							   <td> " . $row['customer_email'] . "
							   <td> " . $row['customer_phone'] . "
							   <td> " . $row['date_submitted']   . "
							   <td>  
									<form action=\"sample_form_view.php\" method=\"post\">
										<input type=\"hidden\" value=" . $row['sample_form_id'] . " name=\"id\" id=\"id\">
										<input type=\"submit\" name=\"view\" value=\"View\">
									</form>
							   </td>		     
						  </tr>";
				}
			?>
			<tr colspan="6"> <th colspan="6" id="heading2"> Ltl Quotes </th> </tr>
			<tr> 
				<th id="heading3"> Company </th> 
				<th id="heading3"> Point of Contact </th>
				<th id="heading3"> Email </th>
				<th id="heading3"> Phone Number </th>
				<th id="heading3"> Date Created </th>
				<th id="heading3"> Options </th>
			<tr/>
			<?php
				while ($row = mysqli_fetch_array($query_ltls_result))
				{
					echo "<tr> 
							   <td> " . $row['company_name']   . " </td>
							   <td>	" . $row['customer_name']  . "
							   <td> " . $row['customer_email'] . "
							   <td> " . $row['customer_phone'] . "
							   <td> " . $row['date_created']   . "
							   <td> <a> View </a> <a> Print to PDF </a> </td>
						  </tr>";
				}
			?>
			<tr colspan="6"> <th colspan="6" id="heading2"> Tl Quotes </th> </tr>
			<tr> 
				<th id="heading3"> Company </th> 
				<th id="heading3"> Point of Contact </th>
				<th id="heading3"> Email </th>
				<th id="heading3"> Phone Number </th>
				<th id="heading3"> Date Created </th>
				<th id="heading3"> Options </th>
			<tr/>
			<?php
				while ($row = mysqli_fetch_array($query_tls_result))
				{
					echo "<tr> 
							   <td> " . $row['company_name']   . " </td>
							   <td>	" . $row['customer_name']  . "
							   <td> " . $row['customer_email'] . "
							   <td> " . $row['customer_phone'] . "
							   <td> " . $row['date_created']   . " 
							   <td> <a> View </a> <a> Print to PDF </a> </td>
						  </tr>";
				}
			?>
			<tr colspan="6"> <th colspan="6" id="heading2"> Distributor Quotes </th> </tr>
			<tr> 
				<th id="heading3"> Company </th> 
				<th id="heading3"> Point of Contact </th>
				<th id="heading3"> Email </th>
				<th id="heading3"> Phone Number </th>
				<th id="heading3"> Date Created </th>
				<th id="heading3"> Options </th>
			<tr/>
			<?php
				while ($row = mysqli_fetch_array($query_distributors_result))
				{
					echo "<tr> 
							   <td> " . $row['company_name']   . " </td>
							   <td>	" . $row['customer_name']  . "
							   <td> " . $row['customer_email'] . "
							   <td> " . $row['customer_phone'] . "
							   <td> " . $row['date_created']   . "
							   <td>  
									<form action=\"viewMarketRequest.php\" method=\"post\">
										<input type=\"hidden\" value=" . $row['distributor_quote_id'] . " name=\"id\">
										<input type=\"button\" name=\"view\" value=\"View\">
									</form>
							   </td>
						  </tr>";
				}
			?>
			<tr colspan="6"> <th colspan="6" id="heading2"> Marketing Requests </th> </tr>
			<tr> 
				<th id="heading3"> Company </th> 
				<th id="heading3"> Point of Contact </th>
				<th id="heading3"> Email </th>
				<th id="heading3"> Phone Number </th>
				<th id="heading3"> Date Created </th>
				<th id="heading3"> Options </th>
			<tr/>
			<?php
				while ($row = mysqli_fetch_array($query_marketing_reqs_result))
				{
					echo "<tr> 
							   <td> " . $row['company_name']   . " </td>
							   <td>	" . $row['customer_name']  . "
							   <td> " . $row['customer_email'] . "
							   <td> " . $row['customer_phone'] . "
							   <td> " . $row['date_created']   . " 
							   <td>  
									<form action=\"viewMarketRequest.php\" method=\"post\">
										<input type=\"hidden\" value=" . $row['marketing_request_id'] . " name=\"id\">
										<input type=\"submit\" name=\"view\" value=\"View\">
									</form>
							   </td>
						  </tr>";
				}
			?>
		</table>
    </body>
</html>