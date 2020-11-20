<?php
    /* Name: newSampleForm.php
     * Author: Emmett Janssens, Modified by Kaitlyn Breker
     * Last Modified: November 15th, 2020
     * Purpose: File called when user clicks submit on the input sample form. Inserts form information into
     *          the sample_form table of the database.
     */
	
   	if (!session_id()) {
 session_start();}Q
include '../Database/databaseConnection.php';
include '../Database/connect.php';
			
			$field=$_SESSION['field'];
			
			
			
			
	$query_samples	= "SELECT * FROM sample_form WHERE sample_form_id = " . $field;
	$query_samples_results = $conn->query($query_samples);
	$qsr = mysqli_fetch_array($query_samples_results);
	
	//$_SESSION['field']=$qsr[sample_form_id];
    /*Check required variables for value, if none input 0*/

	if (isset($_POST['m_code']))
	{
		$m_code = $_POST['m_code'];
		
	}
	else 
	{
		$m_code = $qsr['mcode'];
	}


	if (isset($_POST['credit_app_submitted']))
	{
		$credit_app_submitted = $_POST['credit_app_submitted'];
		
	}
	else 
	{
		$credit_app_submitted = $qsr['credit_app_submitted'];
	}

	if (isset($_POST['business_case']))
	{
		$match_sample_sub = $_POST['business_case'];
	}
	else 
	{
		$match_sample_sub =$qsr['business_case'] ;
	}
	if (isset($_POST['match_sample_sub']))
	{
		$match_data_sheet = $_POST['match_sample_sub'];
	}
	else 
	{
		$match_data_sheet = $qsr['match_saC1_sub'];
	}

	if (isset($_POST['match_data_sheet']))
	{
		$match_data_sheet = $_POST['match_data_sheet'];
	}
	else 
	{
		$match_data_sheet = $qsr['match_data_sheet'];
	}
	if (isset($_POST['match_descr']))
	{
		$match_descr = $_POST['match_descr'];
	}
	else 
	{
		$match_descr = $qsr['match_descr'];
	}
	if (isset($_POST['curr_filter_sys']))
	{
		$curr_filter_sys = $_POST['curr_filter_sys'];
	}
	else 
	{
		$curr_filter_sys = $qsr['curr_filter_sys'];
	}
	if (isset($_POST['prod_rec']))
	{
		$prod_rec = $_POST['prod_rec'];
	}
	else 
	{
		$prod_rec = $qsr['prod_rec'];
	}

	if (isset($_POST['stock_prod_qty']))
	{
		$stock_prod_qty = $_POST['stock_prod_qty'];
	}
	else 
	{
		$stock_prod_qty = $qsr['stock_prod_qty'];
	}
	
	if (isset($_POST['sds']))
	{
		$sds = $_POST['sds'];
	}
	else 
	{
		$sds = $qsr['sds'];
	}
	if (isset($_POST['coa']))
	{
		$coa = $_POST['coa'];
	}
	else 
	{
		$coa = $qsr['coa'];
	}
	if (isset($_POST['data_sheet']))
	{
		$data_sheet = $_POST['data_sheet'];
	}
	else 
	{
		$data_sheet = $qsr['data_sheet'];
	}
  
	/*Check submittedBy field, if blank, display error*/
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
  
	/*Assign values to variables*/
	$submittedBy		= filter_input(INPUT_POST, 'submittedBy');
	$dateSubmitted		= htmlspecialchars(strip_tags($_POST['dateSubmitted']));
	$marketCode			= htmlspecialchars(strip_tags($_POST['mCode']));
	$customer_id        = htmlspecialchars(strip_tags($_SESSION['customer_id']));
	$company_id         = htmlspecialchars(strip_tags($_SESSION['company_id']));
	$business_case		= htmlspecialchars(strip_tags($_POST['business_case']));
	$material_descr		= htmlspecialchars(strip_tags($_POST['material_descr']));
	$customer_proc		= htmlspecialchars(strip_tags($_POST['customer_proc']));
	$curr_supplier		= htmlspecialchars(strip_tags($_POST['curr_supplier']));
	$finished_good_app	= htmlspecialchars(strip_tags($_POST['finised_good_app']));
	$annual_vol			= htmlspecialchars(strip_tags($_POST['annual_vol']));
	$curr_resin_system	= htmlspecialchars(strip_tags($_POST['curr_resin_system']));
	$target_price		= htmlspecialchars(strip_tags($_POST['target_price']));
	$melt_reqs			= htmlspecialchars(strip_tags($_POST['melt_reqs']));
	$colors				= htmlspecialchars(strip_tags($_POST['colors']));
	$known_additives	= htmlspecialchars(strip_tags($_POST['known_additives']));
	$uv_reqs			= htmlspecialchars(strip_tags($_POST['uv_reqs']));
	$ul_reqs			= htmlspecialchars(strip_tags($_POST['ul_reqs']));
	$auto_reqs			= htmlspecialchars(strip_tags($_POST['auto_reqs']));
	$fda_reqs			= htmlspecialchars(strip_tags($_POST['fda_reqs']));
	$color_specs		= htmlspecialchars(strip_tags($_POST['color_specs']));
	$response_date		= htmlspecialchars(strip_tags($_POST['response_date']));
	$other_doc			= htmlspecialchars(strip_tags($_POST['other_doc']));
	$sample_qty			= htmlspecialchars(strip_tags($_POST['sample_qty']));
	$sample_req_date	= htmlspecialchars(strip_tags($_POST['sample_req_date']));
	$sample_price		= htmlspecialchars(strip_tags($_POST['sample_price']));
	$sample_frt			= htmlspecialchars(strip_tags($_POST['sample_frt']));
	$other_contact1		= htmlspecialchars(strip_tags($_POST['other_contact1']));
	$other_contact2		= htmlspecialchars(strip_tags($_POST['other_contact2']));
	$other_contact3		= htmlspecialchars(strip_tags($_POST['other_contact3'])); 
	$other_contact4		= htmlspecialchars(strip_tags($_POST['other_contact4']));

	include "../Database/connect.php";

	$conn = getDBConnection();
	
	
	/*Check the connection*/
	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
        /*Prepare insert statement into the sample_form table*/
        $stmt = $conn->prepare("INSERT INTO sample_form (
					date_submitted, 
                    m_code, 
                    customer_code, 
                    credit_app_submitted, 
                    business_case, 
                    match_sample_sub,
				    match_data_sheet, 
                    match_description, 
                    material_description, 
                    customer_proc, 
                    customer_supplier, 
                    finished_good_app,
				    annual_vol, 
                    current_resin_system, 
                    target_price, 
                    melt_reqs, 
                    current_filler_sys, 
                    colors, 
                    known_additives,
				    uv_reqs, 
                    ul_reqs, 
                    auto_reqs, 
                    fda_reqs, 
                    color_specs, 
                    response_date, 
                    prod_rec, 
                    stock_prod_qty,
				    sds, 
                    coa, 
                    data_sheet, 
                    other_doc, 
                    sample_qty, 
                    sample_req_date, 
                    sample_price, 
                    sample_frt,
				    other_contact_1, 
                    other_contact_2, 
                    other_contact_3, 
                    other_contact_4) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		
        /*Bind statement parameters to statement and execute*/
		$stmt->bind_param("sssisiiissssssssssssssssiiisiisiissssss", $dateSubmitted, $marketCode, $customer_id, $credit_app_submitted, $business_case, $match_sample_sub,
		    $match_data_sheet, $match_descr, $material_descr, $customer_proc, $curr_supplier, $finished_good_app,
		    $annual_vol, $curr_resin_system, $target_price, $melt_reqs, $curr_filter_sys, $colors, $known_additives,
		    $uv_reqs, $ul_reqs, $auto_reqs, $fda_reqs, $color_specs, $response_date, $prod_rec, $stock_prod_qty,
		    $sds, $coa, $data_sheet, $other_doc, $sample_qty, $sample_req_date, $sample_price, $sample_frt,
		    $other_contact1, $other_contact2, $other_contact3, $other_contact4);
		
		$stmt->execute();

		/*Modified by Jason, to take Interaction_id generated previously*/
		$id = $_SESSION['interaction_id'];
		
		/*Prepare insert statement into the interaction_relational_form table*/
		$stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id,
                    form_id,
                    form_type)
                    VALUES (?, ?, ?)");
	
		/*Assign values to variables*/
		$interactionNum = $id;
		$formID = $conn->insert_id; //retrieve id of last query under $conn
		$formType = 1;

		/*Bind statement parameters to statement*/
		$stmt2->bind_param("iii", $interactionNum, $formID, $formType);
		
		/*Execute statement*/
		$stmt2->execute();
		
		/*Close statements and connection*/
		$stmt->close();
		$stmt2->close();
		$conn->close();
	  
		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();

	}
?>

