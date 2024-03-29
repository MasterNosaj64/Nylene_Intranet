<?php
    /* Name: newSampleForm.php
     * Author: Emmett Janssens, Modified by Kaitlyn Breker
     * Last Modified: Descember 1st, 2020
     * Purpose: File called when user clicks submit on the input sample form. Inserts form information into
     *          the sample_form table of the database.
     */
    include "../Database/connect.php";
    session_start();
    $conn = getDBConnection();
    

    /*Check required variables for value, if none input 0*/
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
	if (isset($_POST['curr_filler_sys']))
	{
		$curr_filler_sys = $_POST['curr_filler_sys'];
	}
	else 
	{
		$curr_filler_sys = 0;
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
	$dateSubmitted		= htmlspecialchars(strip_tags($_POST['dateSubmitted']));
	$marketCode			= htmlspecialchars(strip_tags($_POST['mCode']));
	$customer_id        = htmlspecialchars(strip_tags($_SESSION['customer_id']));
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
		$stmt->bind_param("sssisiiisssssssssssssssssiisiisssssssss", $dateSubmitted, $marketCode, $customer_id, $credit_app_submitted, $business_case, $match_sample_sub,
		    $match_data_sheet, $match_descr, $material_descr, $customer_proc, $curr_supplier, $finished_good_app,
		    $annual_vol, $curr_resin_system, $target_price, $melt_reqs, $curr_filler_sys, $colors, $known_additives,
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
		
		
		/*Close statements*/
		$stmt->close();
		$stmt2->close();
		
		
		 /*Search follow up info using interaction id posted from session value*/
		$interactionQuery = "SELECT status, follow_up_type FROM interaction
								WHERE interaction_id = ". $interactionNum;
		$interactionResult = $conn->query($interactionQuery);
		$interactionRow = mysqli_fetch_array($interactionResult);
		
		
		/*Code for updating date in interaction table if form selected*/
		if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
		    /*Prepare Update statement into the interaction table to update notification date*/
		    $stmt3 = $conn->prepare("UPDATE interaction SET follow_up_date = ?
                                        WHERE interaction_id = ?");
		    
		    /*Assign follow up modified - must convert to date, modify, than convert back to string*/
		    $fDate = strtotime($sample_req_date);
		    $followDate = date("Y/m/d", $fDate);
		    $followUpDate = date_create($followDate);
		    date_modify($followUpDate, "+30 days");
		    $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
		    
		    /*Bind statement parameters to statement*/
		    $stmt3->bind_param("si", $followUpDateFormatted, $interactionNum);
		    
		    /*Execute statement*/
		    $stmt3->execute();
		    $stmt3->close();
		    
		} else {
		    //do nothing
		}
		
		/*Close connection*/
		$conn->close();
	  
		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php?sort=1\" />;";
		exit();

	}
?>

