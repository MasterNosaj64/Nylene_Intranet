<?php
/*
 * Name: editSampleDatabase.php
 * Author: Madhav Sachdeva, Modified by Kaitlyn Breker
 * Last Modified:December 5st, 2020
 * Purpose: 
 */
    if (! session_id()) {
        session_start();
    }

    include '../Database/connect.php';
    $conn = getDBConnection();
    
    $field = $_SESSION['field'];
    
    $query_samples = "SELECT * FROM sample_form WHERE sample_form_id = " . $field;
    $query_samples_results = $conn->query($query_samples);
    $qsr = mysqli_fetch_array($query_samples_results);
    

    /* Check required variables for value, if none input 0 */
    $m_code = $qsr['m_code'];
    $business_case = $qsr['business_case'];
    $material_description = $qsr['material_description'];
    $customer_proc = $qsr['customer_proc'];
    $customer_supplier = $qsr['customer_supplier'];
    $finished_good_app = $qsr['finished_good_app'];
    $annual_vol = $qsr['annual_vol'];
    $current_resin_system = $qsr['current_resin_system'];
    $target_price = $qsr['target_price'];
    $melt_reqs = $qsr['melt_reqs'];
    $current_filler_sys = $qsr['current_filler_sys'];
    $colors = $qsr['colors'];
    $known_additives = $qsr['known_additives'];
    $uv_reqs = $qsr['uv_reqs'];
    $ul_reqs = $qsr['ul_reqs'];
    $auto_reqs = $qsr['auto_reqs'];
    $fda_reqs = $qsr['fda_reqs'];
    $color_specs = $qsr['color_specs'];
    $response_date = $qsr['response_date'];
    $other_doc = $qsr['other_doc'];
    $sample_qty = $qsr['sample_qty'];
    $sample_req_date = $qsr['sample_req_date'];
    $sample_price = $qsr['sample_price'];
    $sample_frt = $qsr['sample_frt'];
    $other_contact_1 = $qsr['other_contact_1'];
    $other_contact_2 = $qsr['other_contact_2'];
    $other_contact_3 = $qsr['other_contact_3'];
    $other_contact_4 = $qsr['other_contact_4'];

    if (isset($_POST['credit_app_submitted'])) {
       $credit_app_submitted = htmlspecialchars(strip_tags($_POST['credit_app_submitted']));
    }
    
    if (isset($_POST['business_case'])) {
        $business_case = htmlspecialchars(strip_tags($_POST['business_case']));
    }
    
    if (isset($_POST['match_sample_sub'])) {
        $match_sample_sub = htmlspecialchars(strip_tags($_POST['match_sample_sub']));
    }
    
    if (isset($_POST['match_data_sheet'])) {
        $match_data_sheet = htmlspecialchars(strip_tags($_POST['match_data_sheet']));
    }

    if (isset($_POST['match_description'])) {
        $match_description = htmlspecialchars(strip_tags($_POST['match_description']));
    }

    if (isset($_POST['material_description'])) {
        $material_description = htmlspecialchars(strip_tags($_POST['material_description']));
    }

    if (isset($_POST['customer_proc'])) {
        $customer_proc = htmlspecialchars(strip_tags($_POST['customer_proc']));
    }
    
    if (isset($_POST['customer_supplier'])) {
        $customer_supplier = htmlspecialchars(strip_tags($_POST['customer_supplier']));
    }
    
    if (isset($_POST['finished_good_app'])) {
        $finished_good_app = htmlspecialchars(strip_tags($_POST['finished_good_app']));
    }

    if (isset($_POST['annual_vol'])) {
        $annual_vol = htmlspecialchars(strip_tags($_POST['annual_vol']));
    }
    
    if (isset($_POST['current_resin_system'])) {
        $current_resin_system = htmlspecialchars(strip_tags($_POST['current_resin_system']));
    }
    
    if (isset($_POST['target_price'])) {
        $target_price = htmlspecialchars(strip_tags($_POST['target_price']));
    }
    
    if (isset($_POST['melt_reqs'])) {
        $melt_reqs = htmlspecialchars(strip_tags($_POST['melt_reqs']));
    }
    
    if (isset($_POST['current_filler_sys'])) {
        $current_filler_sys = htmlspecialchars(strip_tags($_POST['current_filler_sys']));
    }
    
    if (isset($_POST['colors'])) {
        $colors = htmlspecialchars(strip_tags($_POST['colors']));
    }
    
    if (isset($_POST['known_additives'])) {
        $known_additives = htmlspecialchars(strip_tags($_POST['known_additives']));
    }
    
    if (isset($_POST['uv_reqs'])) {
        $uv_reqs = htmlspecialchars(strip_tags($_POST['uv_reqs']));
    }
    
    if (isset($_POST['ul_reqs'])) {
        $ul_reqs = htmlspecialchars(strip_tags($_POST['ul_reqs']));
    }
    
    if (isset($_POST['auto_reqs'])) {
        $auto_reqs = htmlspecialchars(strip_tags($_POST['auto_reqs']));
    }
    
    if (isset($_POST['fda_reqs'])) {
        $fda_reqs = htmlspecialchars(strip_tags($_POST['fda_reqs']));
    }
    
    if (isset($_POST['color_specs'])) {
        $color_specs = htmlspecialchars(strip_tags($_POST['color_specs']));
    }
    
    if (isset($_POST['response_date'])) {
        $response_date = date(htmlspecialchars(strip_tags($_POST['response_date'])));
    }
    
    if (isset($_POST['prod_rec'])) {
        $prod_rec = htmlspecialchars(strip_tags($_POST['prod_rec']));
    }
    
    if (isset($_POST['stock_prod_qty'])) {
        $stock_prod_qty = htmlspecialchars(strip_tags($_POST['stock_prod_qty']));
    }
    
    if (isset($_POST['other_doc'])) {
        $other_doc = htmlspecialchars(strip_tags($_POST['other_doc']));
    }
    
    if (isset($_POST['sds'])) {
        $sds = htmlspecialchars(strip_tags($_POST['sds']));
    }
    
    if (isset($_POST['coa'])) {
        $coa = htmlspecialchars(strip_tags($_POST['coa']));
    }
    
    if (isset($_POST['sample_qty'])) {
        $sample_qty = htmlspecialchars(strip_tags($_POST['sample_qty']));
    }
        
    if (isset($_POST['data_sheet'])) {
        $data_sheet = htmlspecialchars(strip_tags($_POST['data_sheet']));
    }
    
    if (isset($_POST['sample_price'])) {
        $sample_price = htmlspecialchars(strip_tags($_POST['sample_price']));
    }
    
    if (isset($_POST['sample_frt'])) {
        $sample_frt = htmlspecialchars(strip_tags($_POST['sample_frt']));
    }
    
    if (isset($_POST['other_contact_1'])) {
        $other_contact_1 = htmlspecialchars(strip_tags($_POST['other_contact_1']));
    }
    
    if (isset($_POST['other_contact_2'])) {
        $other_contact_2 = htmlspecialchars(strip_tags($_POST['other_contact_2']));
    }
    
    if (isset($_POST['other_contact_3'])) {
        $other_contact_3 = htmlspecialchars(strip_tags($_POST['other_contact_3']));
    }
    
    if (isset($_POST['other_contact_4'])) {
        $other_contact_4 = htmlspecialchars(strip_tags($_POST['other_contact_4']));
    }
    if (isset($_POST['sample_req_date'])) {
        $sample_req_date = date(htmlspecialchars(strip_tags($_POST['sample_req_date'])));
    }
    
    
    /*UPDATING THE FORM IN THE DATABASE*/
    /* Check the connection */
    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error);
    } else {
        /* Prepare insert statement into the sample_form table */
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
    
        /* Bind statement parameters to statement and execute */
        $stmt->bind_param("sisiiisssssssssssssssssiisiisssssssss",
            	$m_code, 
            	$credit_app_submitted,
            	$business_case, 
            	$match_sample_sub, 
            	$match_data_sheet, 
            	$match_description, 
            	$material_description, 
            	$customer_proc, 
            	$customer_supplier,
            	$finished_good_app,
            	$annual_vol,
            	$current_resin_system,
            	$target_price,
            	$melt_reqs,
            	$current_filler_sys,
            	$colors,
            	$known_additives,
            	$uv_reqs,
            	$ul_reqs,
            	$auto_reqs, 
            	$fda_reqs, 
            	$color_specs,
            	$response_date, 
            	$prod_rec,
            	$stock_prod_qty, 
            	$sds, 
            	$coa,
            	$data_sheet,
            	$other_doc,
            	$sample_qty,
            	$sample_req_date,
            	$sample_price,
            	$sample_frt, 
            	$other_contact_1, 
            	$other_contact_2,
            	$other_contact_3, 
            	$other_contact_4);
    
        $stmt->execute();
        $stmt->close();
    
        
        /*AUTO UPDATE INTERACTION COMMENTS*/
        $interactionNum = $_SESSION['interaction_id'];
        /*Retrieve original values from db*/
        $old_m_code = $qsr['m_code'];
        $old_credit_app_submitted = $qsr['credit_app_submitted'];
        $old_business_case = $qsr['business_case'];
        $old_match_sample_sub = $qsr['match_sample_sub'];
        $old_match_data_sheet = $qsr['match_data_sheet'];
        $old_match_description = $qsr['match_description'];
        $old_material_description = $qsr['material_description'];
        $old_customer_proc = $qsr['customer_proc'];
        $old_customer_supplier = $qsr['customer_supplier'];
        $old_finished_good_app = $qsr['finished_good_app'];
        $old_annual_vol = $qsr['annual_vol'];
        $old_current_resin_system = $qsr['current_resin_system'];
        $old_target_price = $qsr['target_price'];
        $old_melt_reqs = $qsr['melt_reqs'];
        $old_current_filler_sys = $qsr['current_filler_sys'];
        $old_colors = $qsr['colors'];
        $old_known_additives = $qsr['known_additives'];
        $old_uv_reqs = $qsr['uv_reqs'];
        $old_ul_reqs = $qsr['ul_reqs'];
        $old_auto_reqs = $qsr['auto_reqs'];
        $old_fda_reqs = $qsr['fda_reqs'];
        $old_color_specs = $qsr['color_specs'];
        $old_response_date = $qsr['response_date'];
        $old_prod_rec = $qsr['prod_rec'];
        $old_stock_prod_qty = $qsr['stock_prod_qty'];
        $old_other_doc = $qsr['other_doc'];
        $old_sds = $qsr['sds'];
        $old_coa = $qsr['coa'];
        $old_sample_qty = $qsr['sample_qty'];
        $old_sample_req_date = $qsr['sample_req_date'];;
        $old_data_sheet = $qsr['data_sheet'];
        $old_sample_price = $qsr['sample_price'];
        $old_sample_frt = $qsr['sample_frt'];
        $old_other_contact_1 = $qsr['other_contact_1'];
        $old_other_contact_2 = $qsr['other_contact_2'];
        $old_other_contact_3 = $qsr['other_contact_3'];
        $old_other_contact_4 = $qsr['other_contact_4'];
        $commentString = "";
        $autoUpdate = 0;
        $dateModified = date("Y-m-d");
        
        /*CREATE STRING OF EDITS*/
        $commentString = "Form Modified on {$dateModified}. Old form value(s): ";
        
        /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
        /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
        if (strcmp($old_m_code, $m_code) !== 0){
            $autoUpdate = 1;
            $commentString .= "M Code: {$old_m_code}, ";
        }
        if($old_credit_app_submitted != $credit_app_submitted){
            $autoUpdate = 1;
            $commentString .= "Credit App Submitted: {$old_credit_app_submitted}, ";
        }
        if (strcmp($old_business_case, $business_case) !== 0){
            $autoUpdate = 1;
            $commentString .= "Business Case: {$old_business_case}, ";
        }
        if (($old_match_sample_sub != $match_sample_sub) || 
            ($old_match_data_sheet != $match_data_sheet) || 
            ($old_match_description != $match_description)){
                $autoUpdate = 1;
                $commentString .= "Match Changed, ";
        }
        if (strcmp($old_material_description, $material_description) !== 0){
            $autoUpdate = 1;
            $commentString .= "Material Description: {$old_material_description}, ";
        }
        if (strcmp($old_customer_proc, $customer_proc) !== 0){
            $autoUpdate = 1;
            $commentString .= "Customer Proc: {$old_customer_proc}, ";
        }
        if (strcmp($old_customer_supplier, $customer_supplier) !==0) {
            $autoUpdate = 1;
            $commentString .= "Customer Supplier: {$old_customer_supplier}, ";
        }
        if (strcmp($old_finished_good_app, $finished_good_app) !== 0){
            $autoUpdate = 1;
            $commentString .= "Finished Good App: {$old_finished_good_app}, ";
        }
        if (strcmp($old_annual_vol, $annual_vol) !== 0){
            $autoUpdate = 1;
            $commentString .= "M Code: {$old_annual_vol}, ";
        }
        if (strcmp($old_current_resin_system, $current_resin_system) !== 0){
            $autoUpdate = 1;
            $commentString .= "Resin System: {$old_current_resin_system}, ";
        }
        if (strcmp($old_target_price, $target_price) !== 0){
            $autoUpdate = 1;
            $commentString .= "Target Price: {$old_target_price}, ";
        }
        if (strcmp($old_melt_reqs, $old_melt_reqs) !== 0){
            $autoUpdate = 1;
            $commentString .= "Melt Reqs: {$old_melt_reqs}, ";
        }
        if (strcmp($old_current_filler_sys, $current_filler_sys) !==0) {
            $autoUpdate = 1;
            $commentString .= "Current filler system: {$old_current_filler_sys}, ";
        }
        if (strcmp($old_colors, $colors) !== 0){
            $autoUpdate = 1;
            $commentString .= "Colors: {$old_colors}, ";
        }
        if (strcmp($old_known_additives, $known_additives) !== 0){
            $autoUpdate = 1;
            $commentString .= "Known additives: {$old_known_additives}, ";
        }
        if ((strcmp($old_uv_reqs, $uv_reqs) !== 0) ||
            (strcmp($old_ul_reqs, $ul_reqs) !== 0) ||
            (strcmp($old_auto_reqs, $auto_reqs) !== 0) ||
            (strcmp($old_fda_reqs, $fda_reqs) !== 0) ||
            (strcmp($old_color_specs, $color_specs) !== 0)){
            $autoUpdate = 1;
            $commentString .= "Requirements Updatesd, ";
        }
        if (strcmp($old_response_date, $old_response_date) !== 0){
            $autoUpdate = 1;
            $commentString .= "Response Date Updated: {$old_response_date}, ";
        }
        if (strcmp($old_current_filler_sys, $current_filler_sys) !==0) {
            $autoUpdate = 1;
            $commentString .= "Current filler system: {$old_current_filler_sys}, ";
        }
        if (strcmp($old_colors, $colors) !== 0){
            $autoUpdate = 1;
            $commentString .= "Colors: {$old_colors}, ";
        }
        if ((strcmp($old_other_doc, $other_doc) !== 0) ||
            ($old_prod_rec != $old_prod_rec) ||
            ($old_stock_prod_qty != $stock_prod_qty) ||
            ($old_sds != $sds) || 
            ($old_coa != $coa) || 
            ($old_data_sheet != $data_sheet)){
                $autoUpdate = 1;
                $commentString .= "Type of Response Updated, ";
        }
        if (strcmp($old_sample_qty, $sample_qty) !== 0){
            $autoUpdate = 1;
            $commentString .= "Sample Quantity: {$old_sample_qty}, ";
        }
        
        if (strcmp($old_sample_req_date, $sample_req_date) !==0) {
            $autoUpdate = 1;
            $commentString .= "Sample Req Date: {$old_sample_req_date}, ";
        }
        if (strcmp($old_sample_price, $sample_price) !== 0){
            $autoUpdate = 1;
            $commentString .= "Sample Price: {$old_sample_price}, ";
        }
        if (strcmp($old_sample_frt, $sample_frt) !== 0){
            $autoUpdate = 1;
            $commentString .= "Sample frt: {$old_sample_frt}, ";
        }
        if ((strcmp($old_other_contact_1, $other_contact_1) !== 0) ||
            (strcmp($old_other_contact_2, $other_contact_2) !== 0) ||
            (strcmp($old_other_contact_3, $other_contact_3) !== 0) ||
            (strcmp($old_other_contact_4, $other_contact_4) !== 0)){
                $autoUpdate = 1;
                $commentString .= "Other Contact Updated, ";
        }
        
        $commentString .= "END Modified.";
        

        /*UPDATING THE STATUS AND FOLLOWUP IN THE INTERACTION TABLE*/
        /*Search follow up info using interaction id posted from session value*/
        $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
    								WHERE interaction_id = ". $interactionNum;
        $interactionResult = $conn->query($interactionQuery);
        $interactionRow = mysqli_fetch_array($interactionResult);
        
        /*Code for updating date in interaction table if form selected*/
        if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
            /*Prepare Update statement into the interaction table to update notification date*/
            $stmt2 = $conn->prepare("UPDATE interaction SET follow_up_date = ?
                                        WHERE interaction_id = ?");
            
            /*Assign follow up modified - must convert to date, modify, than convert back to string*/
            $fDate = strtotime($sample_req_date);
            $followDate = date("Y-m-d", $fDate);
            $followUpDate = date_create($followDate);
            date_modify($followUpDate, "+30 days");
            $followUpDateFormatted = date_format($followUpDate,"Y-m-d");
            
            /*Bind statement parameters to statement*/
            $stmt2->bind_param("si", $followUpDateFormatted, $interactionNum);
            
            /*Execute statement*/
            $stmt2->execute();
            $stmt2->close();
            
        } else {
            //do nothing
        }
    
        
        /*UPDATING THE COMMENTS IN THE INTERACTION TABLE*/
        /*If autoUpdate == 1, do changes*/
        if ($autoUpdate == 1){
            
            $comments = $interactionRow['comments'];
            
            /*Only update the comments in the interaction if the max length is not reached*/
            $old_commentLength = strlen($comments);
            
            if($old_commentLength >= 1024){
                //echo "Cannot append modified changes to comments, exceeding max length for comments in database";
            } else {
                
                /*Check new comments for length*/
                $comments .= "\n\n{$commentString}";
                $newCommentLength = strlen($comments);
                
                if($newCommentLength < 1024){
                    
                    /*Update comments in the interaction with the modified fields*/
                    $stmt3 = $conn->prepare("UPDATE interaction SET comments = ?
                                            WHERE interaction_id = ?");
                    $stmt3->bind_param("si", $comments, $interactionNum);
                    $stmt3->execute();
                    $stmt3->close();
                    
                } else {
                    //echo "Cannot append modified changes to comments, exceeding max length for comments in database";
                }
            }
            
        } else {
            //do nothing
        }
        
        
        /* Close Connection */
        $conn->close();
    
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
        exit();
    }
?>

