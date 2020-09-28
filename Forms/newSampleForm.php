<?php
	session_start();

	if (isset($_POST['credit_app_submitted']))
	{
		$credit_app_submitted = $_POST['credit_app_submitted'];
	}
	else 
	{
		$credit_app_submitted = 0;
	}

	if (isset($_POST['match_sample_sub']))
	{
		$match_sample_sub = $_POST['match_sample_sub'];
	}
	else 
	{
		$match_sample_sub = 0;
	}

	if (isset($_POST['match_data_sheet']))
	{
		$match_data_sheet = $_POST['match_data_sheet'];
	}
	else 
	{
		$match_data_sheet = 0;
	}
	if (isset($_POST['match_descr']))
	{
		$match_descr = $_POST['match_descr'];
	}
	else 
	{
		$match_descr = 0;
	}
	if (isset($_POST['curr_filter_sys']))
	{
		$curr_filter_sys = $_POST['curr_filter_sys'];
	}
	else 
	{
		$curr_filter_sys = 0;
	}
	if (isset($_POST['prod_rec']))
	{
		$prod_rec = $_POST['prod_rec'];
	}
	else 
	{
		$prod_rec = 0;
	}

	if (isset($_POST['stock_prod_qty']))
	{
		$stock_prod_qty = $_POST['stock_prod_qty'];
	}
	else 
	{
		$stock_prod_qty = 0;
	}
	
	if (isset($_POST['sds']))
	{
		$sds = $_POST['sds'];
	}
	else 
	{
		$sds = 0;
	}
	if (isset($_POST['coa']))
	{
		$coa = $_POST['coa'];
	}
	else 
	{
		$coa = 0;
	}
	if (isset($_POST['data_sheet']))
	{
		$data_sheet = $_POST['data_sheet'];
	}
	else 
	{
		$data_sheet = 0;
	}
  
  if (empty($_POST['submittedBy']))
  {
    echo "There were some errors with your form:";
    
    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
	
	  if (!empty($referer)) 
	  {
		    echo '<p><a href="'. $referer .'" title="Return to the previous page">&laquo; Go back</a></p>';
	  } 
	  else 
	  {
		
		    echo '<p><a href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p>';	
	  }
	}
  
	$submittedBy		= filter_input(INPUT_POST, 'submittedBy');
	$dateSubmitted		= $_POST['dateSubmitted'];
	$marketCode			= $_POST['mCode'];
	$customer_id        = $_SESSION['customer_id'];
	$company_id         = $_SESSION['company_id'];
	$business_case		= $_POST['business_case'];
	$material_descr		= $_POST['material_descr'];
	$customer_proc		= $_POST['customer_proc'];
	$curr_supplier		= $_POST['curr_supplier'];
	$finished_good_app	= $_POST['finised_good_app'];
	$annual_vol			= $_POST['annual_vol'];
	$curr_resin_system	= $_POST['curr_resin_system'];
	$target_price		= $_POST['target_price'];
	$melt_reqs			= $_POST['melt_reqs'];
	$colors				= $_POST['colors'];
	$known_additives	= $_POST['known_additives'];
	$uv_reqs			= $_POST['uv_reqs'];
	$ul_reqs			= $_POST['ul_reqs'];
	$auto_reqs			= $_POST['auto_reqs'];
	$fda_reqs			= $_POST['fda_reqs'];
	$color_specs		= $_POST['color_specs'];
	$response_date		= $_POST['response_date'];
	$other_doc			= $_POST['other_doc'];
	$sample_qty			= $_POST['sample_qty'];
	$sample_req_date	= $_POST['sample_req_date'];
	$sample_price		= $_POST['sample_price'];
	$sample_frt			= $_POST['sample_frt'];
	$other_contact1		= $_POST['other_contact1'];
	$other_contact2		= $_POST['other_contact2'];
	$other_contact3		= $_POST['other_contact3']; 
	$other_contact4		= $_POST['other_contact4'];

	include "../Database/connect.php";

	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
		$insert_into_forms_table = "INSERT INTO sample_form (
				date_submitted, m_code, customer_code, credit_app_submitted, business_case, match_sample_sub,
				match_data_sheet, match_description, material_description, customer_proc, customer_supplier, finished_good_app,
				annual_vol, current_resin_system, target_price, melt_reqs, current_filler_sys, colors, known_additives,
				uv_reqs, ul_reqs, auto_reqs, fda_reqs, color_specs, response_date, prod_rec, stock_prod_qty,
				sds, coa, data_sheet, other_doc, sample_qty, sample_req_date, sample_price, sample_frt,
				other_contact_1, other_contact_2, other_contact_3, other_contact_4) values (
				'$dateSubmitted', '$marketCode', '$customer_id', '$credit_app_submitted', '$business_case', '$match_sample_sub',
				'$match_data_sheet', '$match_descr', '$material_descr', '$customer_proc', '$curr_supplier', '$finished_good_app',
				'$annual_vol', '$curr_resin_system', '$target_price', '$melt_reqs', '$curr_filter_sys', '$colors', '$known_additives',
				'$uv_reqs', '$ul_reqs', '$auto_reqs', '$fda_reqs', '$color_specs', '$response_date', '$prod_rec', '$stock_prod_qty',
				'$sds', '$coa', '$data_sheet', '$other_doc', '$sample_qty', '$sample_req_date', '$sample_price', '$sample_frt',
				'$other_contact1', '$other_contact2', '$other_contact3', '$other_contact4')";

		if ($conn->query($insert_into_forms_table) === TRUE) {
		
		}		
		else {
			echo "Error: " . $insert_into_forms_table . "<br>" . $conn->error;
		}

// 		$insert_into_interaction_table = "INSERT INTO interaction (
// 			company_id, employee_id, comments, date_created) values (
// 			'$company_id', 
// 			" . $_SESSION['userid'] . ", 
// 			'Sample Form', 
// 			'$dateSubmitted')";

// 		if ($conn->query($insert_into_interaction_table) === TRUE) {
		
// 		}		
// 		else {
// 			echo "Error: " . $insert_into_interaction_table . "<br>" . $conn->error;
// 		}

// 		$getInteractionId = "SELECT interaction_id FROM interaction ORDER BY interaction_id DESC";
// 		$interactionId = $conn->query($getInteractionId);

// 		$id = mysqli_fetch_array($interactionId);

		//Modified by Jason, to take Interaction_id generated previously
		$id = $_SESSION['interaction_id'];
		
		
		$getFormId = "SELECT sample_form_id FROM sample_form ORDER BY sample_form_id DESC";
		$formId = $conn->query($getFormId);
		$idf = mysqli_fetch_array($formId);

		$insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
			interaction_id, form_id, form_type) values (
			" . $id . ", " . $idf['sample_form_id'] . ", '1')";

		if ($conn->query($insert_into_interaction_relational_manager_table) === TRUE) {
		  
		    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		    exit();
		}		
		else {
			echo "Error: " . $insert_into_interaction_relational_manager_table . "<br>" . $conn->error;
		}		
	}
?>

