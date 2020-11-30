<?php
    /* Name: editSampleDatabase.php
     * Author: Madhav Sachdeva, modified by Kaitlyn Breker
     * Last Modified: November 27th, 2020
     * Purpose: Update fields in the db sample table
     */
	
   	if (!session_id()) {
 session_start();}

include '../Database/connect.php';
$conn = getDBConnection();
			
			$field=$_SESSION['field'];
			
			
			
			
	$query_samples	= "SELECT * FROM sample_form WHERE sample_form_id = ".$field;
	$query_samples_results = $conn->query($query_samples);
	$qsr = mysqli_fetch_array($query_samples_results);
	
	//echo $qsr['m_code'];
	$getCustomer = "SELECT * FROM company
						INNER JOIN company_relational_customer ON company_relational_customer.company_id = company.company_id
						INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id WHERE customer.customer_id = " . $qsr['customer_code'];

	$getCustomerResult = $conn->query($getCustomer);
	$gcr = mysqli_fetch_array($getCustomerResult);
	
	
	
	
	//$_SESSION['field']=$qsr[sample_form_id];
    /*Check required variables for value, if none input 0*/

	if (isset($_POST['m_code']))
	{
		$m_code = $_POST['m_code'];
//		$m_code = htmlspecialchars(strip_tags($_POST['m_code']));
		
	}
	else 
	{
		$m_code = $qsr['m_code'];
	}
	echo $m_code;

	if (isset($_POST['company_name']))
	{
		$company_name = htmlspecialchars(strip_tags($_POST['company_name']));
		
	}
	else 
	{
		$company_name = $gcr['company_name'];
	}
	

	
	if (isset($_POST['billing_address_street']))
	{
		$billing_address_street = htmlspecialchars(strip_tags($_POST['billing_address_street']));
		
	}
	else 
	{
		$billing_address_street = $gcr['billing_address_street'];
	}
	
	
	
	if (isset($_POST['billing_address_city']))
	{
		$billing_address_city = htmlspecialchars(strip_tags($_POST['billing_address_city']));
		
	}
	else 
	{
		$billing_address_city = $gcr['billing_address_city'];
	}
	
	
	
	if (isset($_POST['billing_address_state']))
	{
		$billing_address_state = htmlspecialchars(strip_tags($_POST['billing_address_state']));
		
	}
	else 
	{
		$billing_address_state = $gcr['billing_address_state'];
	}
	
	
	if (isset($_POST['billing_address_postalcode']))
	{
		$billing_address_postalcode = htmlspecialchars(strip_tags($_POST['billing_address_postalcode']));
		
	}
	else 
	{
		$billing_address_postalcode = $gcr['billing_address_postalcode'];
	}


	if (isset($_POST['customer_name']))
	{
		$customer_name = htmlspecialchars(strip_tags($_POST['customer_name']));
		
	}
	else 
	{
		$customer_name = $gcr['customer_name'];
	}




	if (isset($_POST['customer_phone']))
	{
		$customer_phone = htmlspecialchars(strip_tags($_POST['customer_phone']));
		
	}
	else 
	{
		$customer_phone = $gcr['customer_phone'];
	}


	if (isset($_POST['customer_email']))
	{
		$customer_email = htmlspecialchars(strip_tags($_POST['customer_email']));
		
	}
	else 
	{
		$customer_email = $gcr['customer_email'];
	}





	if (isset($_POST['customer_fax']))
	{
		$customer_fax = htmlspecialchars(strip_tags($_POST['customer_fax']));
		
	}
	else 
	{
		$customer_fax = $gcr['customer_fax'];
	}







	if (isset($_POST['credit_app_submitted']))
	{
		$credit_app_submitted = htmlspecialchars(strip_tags($_POST['credit_app_submitted']));
		
	}
	else 
	{
		$credit_app_submitted = $qsr['credit_app_submitted'];
	}
	echo " CAS".$credit_app_submitted;

	if (isset($_POST['business_case']))
	{
		$business_case = htmlspecialchars(strip_tags($_POST['business_case']));
	}
	else 
	{
		$business_case =$qsr['business_case'] ;
	}
	echo "BC".$business_case;
	
	if (isset($_POST['match_sample_sub']))
	{
		$match_sample_sub = htmlspecialchars(strip_tags($_POST['match_sample_sub']));
	}
	else 
	{
		$match_sample_sub = $qsr['match_sample_sub'];
	}
	
	echo $match_sample_sub;

	if (isset($_POST['match_data_sheet']))
	{
		$match_data_sheet = htmlspecialchars(strip_tags($_POST['match_data_sheet']));
	}
	else 
	{
		$match_data_sheet = $qsr['match_data_sheet'];
	}
	echo "MDS".$match_data_sheet;
	
	if (isset($_POST['match_description']))
	{
		$match_description = htmlspecialchars(strip_tags($_POST['match_description']));
	}
	else 
	{
		$match_description = $qsr['match_description'];
	}
	echo "MD".$match_description;
	
	if (isset($_POST['material_description']))
	{
		$material_description = htmlspecialchars(strip_tags($_POST['material_description']));
	}
	else 
	{
		$material_description = $qsr['material_description'];
	}
	echo "MAD">$material_description;
	
	if (isset($_POST['customer_proc']))
	{
		$customer_proc = htmlspecialchars(strip_tags($_POST['customer_proc']));
	}
	else 
	{
		$customer_proc = $qsr['customer_proc'];
	}
	echo "CP".$customer_proc;
	
	
	if (isset($_POST['customer_supplier']))
	{
		$customer_supplier = htmlspecialchars(strip_tags($_POST['customer_supplier']));
	}
	else 
	{
		$customer_supplier = $qsr['customer_supplier'];
	}
	echo "CS".$customer_supplier;
	
	
	if (isset($_POST['finished_good_app']))
	{
		$finished_good_app = htmlspecialchars(strip_tags($_POST['finished_good_app']));
	}
	else 
	{
		$finished_good_app = $qsr['finished_good_app'];
	}
	echo "FGA".$finished_good_app;
	
	if (isset($_POST['annual_vol']))
	{
		$annual_vol = htmlspecialchars(strip_tags($_POST['annual_vol']));
	}
	else 
	{
		$annual_vol = $qsr['annual_vol'];
	}
	echo "AV".$annual_vol;

	if (isset($_POST['current_resin_system']))
	{
		$current_resin_system = htmlspecialchars(strip_tags($_POST['current_resin_system']));
	}
	else 
	{
		$current_resin_system = $qsr['current_resin_system'];
	}
	echo "CRS".$current_resin_system;
	
	
	
	if (isset($_POST['target_price']))
	{
		$target_price = htmlspecialchars(strip_tags($_POST['target_price']));
	}
	else 
	{
		$target_price = $qsr['target_price'];
	}
	
	
	if (isset($_POST['melt_reqs']))
	{
		$melt_reqs = htmlspecialchars(strip_tags($_POST['melt_reqs']));
	}
	else 
	{
		$melt_reqs = $qsr['melt_reqs'];
	}
	
	if (isset($_POST['current_filler_sys']))
	{
		$current_filler_sys = htmlspecialchars(strip_tags($_POST['current_filler_sys']));
	}
	else 
	{
		$current_filler_sys = $qsr['current_filler_sys'];
	}
	
	
	if (isset($_POST['colors']))
	{
		$colors = htmlspecialchars(strip_tags($_POST['colors']));
	}
	else 
	{
		$colors = $qsr['colors'];
	}
	
	if (isset($_POST['known_additives']))
	{
		$known_additives = htmlspecialchars(strip_tags($_POST['known_additives']));
	}
	else 
	{
		$known_additives = $qsr['known_additives'];
	}
	
	if (isset($_POST['uv_reqs']))
	{
		$uv_reqs = htmlspecialchars(strip_tags($_POST['uv_reqs']));
	}
	else 
	{
		$uv_reqs = $qsr['uv_reqs'];
	}
	
	
	if (isset($_POST['ul_reqs']))
	{
		$ul_reqs = htmlspecialchars(strip_tags($_POST['ul_reqs']));
	}
	else 
	{
		$ul_reqs = $qsr['ul_reqs'];
	}
	
	
		
	if (isset($_POST['auto_reqs']))
	{
		$auto_reqs = htmlspecialchars(strip_tags($_POST['auto_reqs']));
	}
	else 
	{
		$auto_reqs = $qsr['auto_reqs'];
	}
	
	
		
	if (isset($_POST['fda_reqs']))
	{
		$fda_reqs = htmlspecialchars(strip_tags($_POST['fda_reqs']));
	}
	else 
	{
		$fda_reqs = $qsr['fda_reqs'];
	}
	
	
	if (isset($_POST['color_specs']))
	{
		$color_specs = htmlspecialchars(strip_tags($_POST['color_specs']));
	}
	else 
	{
		$color_specs = $qsr['color_specs'];
	}


	
	if (isset($_POST['response_date']))
	{
		$response_date = date(htmlspecialchars(strip_tags($_POST['response_date'])));
	}
	else 
	{
		$response_date = $qsr['response_date'];
	}
	
	
	if (isset($_POST['prod_rec']))
	{
		$prod_rec = htmlspecialchars(strip_tags($_POST['prod_rec']));
	}
	else 
	{
		$prod_rec = $qsr['prod_rec'];
	}

	if (isset($_POST['stock_prod_qty']))
	{
		$stock_prod_qty = htmlspecialchars(strip_tags($_POST['stock_prod_qty']));
	}
	else 
	{
		$stock_prod_qty = $qsr['stock_prod_qty'];
	}
	
	if (isset($_POST['other_doc']))
	{
		$other_doc = htmlspecialchars(strip_tags($_POST['other_doc']));
	}
	else 
	{
		$other_doc = $qsr['other_doc'];
	}
	
	
	
	
	
	
	if (isset($_POST['sds']))
	{
		$sds = htmlspecialchars(strip_tags($_POST['sds']));
	}
	else 
	{
		$sds = $qsr['sds'];
	}
	if (isset($_POST['coa']))
	{
		$coa = htmlspecialchars(strip_tags($_POST['coa']));
	}
	else 
	{
		$coa = $qsr['coa'];
	}
	if (isset($_POST['sample_qty']))
	{
		$sample_qty = htmlspecialchars(strip_tags($_POST['sample_qty']));
	}
	else 
	{
		$sample_qty = $qsr['sample_qty'];
	}
	
	
	if (isset($_POST['sample_req_date']))
	{
		$sample_req_date = htmlspecialchars(strip_tags($_POST['sample_req_date']));
	}
	else 
	{
		$sample_req_date = $qsr['sample_req_date'];
	}
	
	if (isset($_POST['data_sheet']))
	{
		$data_sheet = htmlspecialchars(strip_tags($_POST['data_sheet']));
	}
	else 
	{
		$data_sheet = $qsr['data_sheet'];
	}
  
	if (isset($_POST['sample_price']))
	{
		$sample_price = htmlspecialchars(strip_tags($_POST['sample_price']));
	}
	else 
	{
		$sample_price = $qsr['sample_price'];
	} 
	
	
	
	if (isset($_POST['sample_frt']))
	{
		$sample_frt = htmlspecialchars(strip_tags($_POST['sample_frt']));
	}
	else 
	{
		$sample_frt = $qsr['sample_frt'];
	} 
	
	if (isset($_POST['other_contact_1']))
	{
		$other_contact_1 = htmlspecialchars(strip_tags($_POST['other_contact_1']));
	}
	else 
	{
		$other_contact_1 = $qsr['other_contact_1'];
	} 
  
  if (isset($_POST['other_contact_2']))
	{
		$other_contact_2 = htmlspecialchars(strip_tags($_POST['other_contact_2']));
	}
	else 
	{
		$other_contact_2 = $qsr['other_contact_2'];
	} 
	
	if (isset($_POST['other_contact_3']))
	{
		$other_contact_3 = htmlspecialchars(strip_tags($_POST['other_contact_3']));
	}
	else 
	{
		$other_contact_3 = $qsr['other_contact_3'];
	} 
	
	if (isset($_POST['other_contact_4']))
	{
		$other_contact_4 = htmlspecialchars(strip_tags($_POST['other_contact_4']));
	}
	else 
	{
		$other_contact_4 = $qsr['other_contact_4'];
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
  
	 /* /*Assign values to variables*/
/*     $dateSubmitted		= htmlspecialchars(strip_tags($_POST['dateSubmitted']));
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
	$other_contact4		= htmlspecialchars(strip_tags($_POST['other_contact4'])); */


	
	
	/*Check the connection*/
	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
        /*Prepare insert statement into the sample_form table*/
        $stmt = $conn->prepare("UPDATE sample_form SET
					m_code=?, 
                    credit_app_submitted=?, 
                    business_case=?, 
                    match_sample_sub=?,
				    match_data_sheet=?, 
                    match_description=?, 
                    material_description=?, 
                    customer_proc=?, 
                    customer_supplier=?, 
                    finished_good_app=?,
				    annual_vol=?, 
                    current_resin_system=?, 
                    target_price=?, 
                    melt_reqs=?, 
                    current_filler_sys=?, 
                    colors=?, 
                    known_additives=?,
				    uv_reqs=?, 
                    ul_reqs=?, 
                    auto_reqs=?, 
                    fda_reqs=?, 
                    color_specs=?, 
                    response_date=?, 
                    prod_rec=?, 
                    stock_prod_qty=?,
				    sds=?, 
                    coa=?, 
                    data_sheet=?, 
                    other_doc=?, 
                    sample_qty=?, 
                    sample_req_date=?, 
                    sample_price=?, 
                    sample_frt=?,
				    other_contact_1=?, 
                    other_contact_2=?, 
                    other_contact_3=?, 
                    other_contact_4=? WHERE sample_form_id = " . $field);
		
        /*Bind statement parameters to statement and execute*/
		$stmt->bind_param("sisiiisssssssssssssssssiisiississssss",$marketCode, $credit_app_submitted, $business_case, $match_sample_sub,
		    $match_data_sheet, $match_description, $material_description, $customer_proc, $customer_supplier, $finished_good_app,
		    $annual_vol, $current_resin_system, $target_price, $melt_reqs, $curr_filler_sys, $colors, $known_additives,
		    $uv_reqs, $ul_reqs, $auto_reqs, $fda_reqs, $color_specs, $response_date, $prod_rec, $stock_prod_qty,
		    $sds, $coa, $data_sheet, $other_doc, $sample_qty, $sample_req_date, $sample_price, $sample_frt,
		    $other_contact1, $other_contact2, $other_contact3, $other_contact4);
		
		$stmt->execute();

		/*Required for followup update*/
		$interactionNum = $_SESSION['interaction_id'];
		
		/*Search follow up info using interaction id posted from session value*/
		$interactionQuery = "SELECT status, follow_up_type FROM interaction
								WHERE interaction_id = ". $interactionNum;
		$interactionResult = $conn->query($interactionQuery);
		$interactionRow = mysqli_fetch_array($interactionResult);
		
		
		/*Code for updating date in interaction table if form selected*/
		if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
		    /*Prepare Update statement into the interaction table to update notification date*/
		    $stmt2 = $conn->prepare("UPDATE interaction SET
                                    follow_up_date = ?
                                    WHERE interaction_id = ?");
		    
		    /*Assign follow up modified - must convert to date, modify, than convert back to string*/
		    $fDate = strtotime($sample_req_date);
		    $followDate = date("Y/m/d", $fDate);
		    $followUpDate = date_create($followDate);
		    date_modify($followUpDate, "+30 days");
		    $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
		    
		    /*Bind statement parameters to statement*/
		    $stmt2->bind_param("si", $followUpDateFormatted, $interactionNum);
		    
		    /*Execute statement*/
		    $stmt2->execute();
		    $stmt2->close();
		    
		} else {
		    //do nothing
		}

		
		/*Close statements and connection*/
		$stmt->close();

		$conn->close();
	  
		echo "<meta http-equiv = \"refresh\" content = \"100; url = ../Interactions/companyHistory.php?sort=1\" />;";
		exit();

	}
?>

