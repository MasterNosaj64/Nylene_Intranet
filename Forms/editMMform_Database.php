<?php
/*
 * Name: editMMform_Database.php
 * Author: Karandeep Singh, modified by Kaitlyn Breker
 * Date Modifed: November 29th, 2020
 * Purpose: Edit MM database table. Inserts into interaction 
 *          autoupdated fields, and followup date information.
 */
 session_start();
 
//include '../Database/databaseConnection.php';
include '../Database/connect.php';


 if (isset($_POST['brochure']))
	{
		$brochure = $_POST['brochure'];
	}
	else 
	{
		$brochure = 0;
	}
    
    if (isset($_POST['ppt']))
	{
		$ppt = $_POST['ppt'];
	}
	else 
	{
		$ppt = 0;
	}
    
    if (isset($_POST['fact_sheet']))
	{
		$fact_sheet = $_POST['fact_sheet'];
	}
	else 
	{
		$fact_sheet = 0;
	}
    
    if (isset($_POST['video']))
	{
		$video = $_POST['video'];
	}
	else 
	{
		$video = 0;
	}
    
    if (isset($_POST['direct_mail']))
	{
		$direct_mail = $_POST['direct_mail'];
	}
	else 
	{
		$direct_mail = 0;
	}
    
    if (isset($_POST['web']))
	{
		$web = $_POST['web'];
	}
	else 
	{
		$web = 0;
	}
    
    if (isset($_POST['page']))
	{
		$page = $_POST['page'];
	}
	else 
	{
		$page = 0;
	}
    
    if (isset($_POST['section']))
	{
		$section = $_POST['section'];
	}
	else 
	{
		$section = 0;
	}
    
    if (isset($_POST['blog']))
	{
		$blog = $_POST['blog'];
	}
	else 
	{
		$blog = 0;
	}
    
    if (isset($_POST['landing_page']))
	{
		$landing_page = $_POST['landing_page'];
	}
	else 
	{
		$landing_page = 0;
	}
    
    if (isset($_POST['updt']))
	{
		$updt = $_POST['updt'];
	}
	else 
	{
		$updt = 0;
	}
    
    if (isset($_POST['graphic']))
	{
		$graphic = $_POST['graphic'];
	}
	else 
	{
		$graphic = 0;
	}
    
    if (isset($_POST['tradeshow']))
	{
		$tradeshow = $_POST['tradeshow'];
	}
	else 
	{
		$tradeshow = 0;
	}
    
    if (isset($_POST['promotional_item']))
	{
		$promotional_item = $_POST['promotional_item'];
	}
	else 
	{
		$promotional_item = 0;
	}
    
    if (isset($_POST['print_aid']))
	{
		$print_aid = $_POST['print_aid'];
	}
	else 
	{
		$print_aid = 0;
	}
    if (isset($_POST['press_release']))
	{
		$press_release = $_POST['press_release'];
	}
	else 
	{
		$press_release = 0;
	}
    
    if (isset($_POST['prospective_customers']))
	{
		$prospective_customers = $_POST['prospective_customers'];
	}
	else 
	{
		$prospective_customers = 0;
	}
    
    if (isset($_POST['engineers']))
	{
		$engineers = $_POST['engineers'];
	}
	else 
	{
		$engineers = 0;
	}
    
    if (isset($_POST['procurement_managers']))
	{
		$procurement_managers = $_POST['procurement_managers'];
	}
	else 
	{
		$procurement_managers = 0;
	}
    
    if (isset($_POST['current_customers']))
	{
		$current_customers = $_POST['current_customers'];
	}
	else 
	{
		$current_customers = 0;
	}
    
    if (isset($_POST['plant_managers']))
	{
		$plant_managers = $_POST['plant_managers'];
	}
	else 
	{
		$plant_managers = 0;
	}
    
$conn = getDBConnection();
// if connection is established,
if ($conn->connect_error) {
    
    die("Connection failed: " . $conn->connect_error);
} else {
    
    /*Assign values to variables for update query*/
    $interactionNum = $_SESSION['interaction_id'];
    $Requester_Name = htmlspecialchars(strip_tags($_POST['Requester_Name']));
    $Market_Segment = htmlspecialchars(strip_tags($_POST['Market_Segment']));
    $Sales_Territory = htmlspecialchars(strip_tags($_POST['Sales_Territory']));
    $Email = htmlspecialchars(strip_tags($_POST['Email']));
    $Phone = htmlspecialchars(strip_tags($_POST['Phone']));
    $Date = htmlspecialchars(strip_tags($_POST['Date']));
    $Name_of_Project = htmlspecialchars(strip_tags($_POST['Name_of_Project']));
    $type_of_project = ($_POST['type_of_project']);
    $other_type_of_project=htmlspecialchars(strip_tags($_POST['other_type_of_project']));
    $project_content = htmlspecialchars(strip_tags($_POST['project_content']));
    $update_info = htmlspecialchars(strip_tags($_POST['update_info']));
    $other_audience = htmlspecialchars(strip_tags($_POST['other_audience']));
    $Info = htmlspecialchars(strip_tags($_POST['Info']));
    $purpose = htmlspecialchars(strip_tags($_POST['purpose']));
    $key_messages = htmlspecialchars(strip_tags($_POST['key_messages']));
    $support = htmlspecialchars(strip_tags($_POST['support']));
    $is_photography_needed = htmlspecialchars(strip_tags($_POST['is_photography_needed']));
    $needed_photography = htmlspecialchars(strip_tags($_POST['needed_photography']));
    $estimate = htmlspecialchars(strip_tags($_POST['estimate']));
    $delivery = htmlspecialchars(strip_tags($_POST['delivery']));
    $date_needed = htmlspecialchars(strip_tags($_POST['date_needed']));
    $budget = htmlspecialchars(strip_tags($_POST['budget']));
    $cost = htmlspecialchars(strip_tags($_POST['cost']));
    $marketing_request_id = htmlspecialchars(strip_tags($_POST['marketing_request_id']));
    
    
    /*AUTO UPDATE INTERACTION COMMENTS*/
    /*Select current database fields*/
    $mmDatabase = "SELECT * FROM marketing_request_form
								WHERE marketing_request_id =". $marketing_request_id;
    $mmDatabaseQuery = $conn->query($mmDatabase);
    $mmRow = mysqli_fetch_array($mmDatabaseQuery);
    
    /*Retrieve original values from db*/
    $old_requester_name = $mmRow['requester_name'];
    $old_market_segment = $mmRow['market_segment'];
    $old_sales_territory = $mmRow['sales_territory'];
    $old_email = $mmRow['email'];
    $old_phone = $mmRow['phone'];
    $old_name_project_or_piece = $mmRow['name_project_or_piece'];
    $old_type_of_project = $mmRow['type_of_project'];
    $old_other_type_of_project = $mmRow['other_type_of_project'];
    $old_brochure = $mmRow['brochure'];
    $old_ppt = $mmRow['ppt'];
    $old_fact_sheet = $mmRow['fact_sheet'];
    $old_video = $mmRow['video'];
    $old_direct_mail = $mmRow['direct_mail'];
    $old_web = $mmRow['web'];
    $old_page = $mmRow['page'];
    $old_section = $mmRow['section'];
    $old_blog = $mmRow['blog'];
    $old_landing_page = $mmRow['landing_page'];
    $old_updt = $mmRow['updt'];
    $old_graphic = $mmRow['graphic'];
    $old_tradeshow = $mmRow['tradeshow'];
    $old_promotional_item = $mmRow['promotional_item'];
    $old_print_aid = $mmRow['print_aid'];
    $old_press_release = $mmRow['press_release'];
    $old_is_project_new = $mmRow['is_project_new'];
    $old_if_piece_new = $mmRow['if_piece_new'];
    $old_prospective_customers = $mmRow['prospective_customers'];
    $old_engineers = $mmRow['engineers'];
    $old_procurement_managers = $mmRow['procurement_managers'];
    $old_current_customers = $mmRow['current_customers'];
    $old_plant_managers = $mmRow['plant_managers'];
    $old_other_audience = $mmRow['other_audience'];
    $old_audience_personal_info = $mmRow['audiance_personal_info'];
    $old_purpose = $mmRow['purpose'];
    $old_key_message = $mmRow['key_message'];
    $old_supporting_info = $mmRow['supporting_info'];
    $old_tradeshow = $mmRow['tradeshow'];
    $old_promotional_item = $mmRow['promotional_item'];
    $old_is_photography_needed = $mmRow['is_photography_needed'];
    $old_needed_photography = $mmRow['needed_photography'];
    $old_estimated_quantity = $mmRow['estimated_quantity'];
    $old_means_of_delivery = $mmRow['means_of_delivery'];
    $old_date_needed = $mmRow['date_needed'];
    $old_available_budget = $mmRow['available_budget'];
    $old_cost_center_number = $mmRow['cost_center_number'];

    $commentString = "";
    $autoUpdate = 0;
    $dateModified = date("Y-m-d");
    
    /*CREATE STRING OF EDITS*/
    $commentString = "Form Modified on {$dateModified}. Old form value(s): ";
    
    /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
    /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
    if (strcmp($old_requester_name, $Requester_Name) !== 0){
        $autoUpdate = 1;
        $commentString .= "Requester's Name: {$old_requester_name}, ";
    }
    if(strcmp($old_market_segment, $Market_Segment) !== 0){
        $autoUpdate = 1;
        $commentString .= "Market Segment: {$old_market_segment}, ";
    }
    if (strcmp($old_sales_territory, $Sales_Territory) !== 0){
        $autoUpdate = 1;
        $commentString .= "Sales Territory: {$old_sales_territory}, ";
    }
    if (strcmp($old_email, $Email) !== 0){
        $autoUpdate = 1;
        $commentString .= "Email: {$old_email}, ";
    }
    if (strcmp($old_phone, $Phone) !== 0){
        $autoUpdate = 1;
        $commentString .= "Phone: {$old_phone}, ";
    }
    if (strcmp($old_name_project_or_piece, $Name_of_Project) !== 0){
        $autoUpdate = 1;
        $commentString .= "Project Name: {$old_name_project_or_piece}, ";
    }
    if ((strcmp($old_type_of_project, $type_of_project) !==0 ) ||
        (strcmp($old_other_type_of_project, $other_type_of_project) !==0 ) ||
        ($old_brochure != $brochure) ||
        ($old_ppt != $ppt) ||
        ($old_fact_sheet != $fact_sheet) ||
        ($old_video != $video) ||
        ($old_direct_mail != $direct_mail) ||
        ($old_web != $web) ||
        ($old_page != $page) ||
        ($old_section != $section) ||
        ($old_blog != $blog) ||
        ($old_landing_page != $landing_page) ||
        ($old_updt != $updt) ||
        ($old_graphic != $graphic) ||
        ($old_tradeshow != $tradeshow) ||
        ($old_promotional_item != $promotional_item) ||
        ($old_print_aid != $print_aid) ||
        ($old_press_release != $press_release))
    {
        $autoUpdate = 1;
        $commentString .= "Type of Project Updated, ";
    }

    if ($old_is_project_new != $project_content) { 
        $autoUpdate = 1;
        $commentString .= "Project New: {$old_is_project_new}, ";
    }
    
    if (strcmp($old_if_piece_new, $update_info) !== 0){
        $autoUpdate = 1;
        $commentString .= "Update Infor: {$old_if_piece_new}, ";
    }
    
    if ((strcmp($old_other_audience, $other_audience) !==0 ) ||
        ($old_prospective_customers != $prospective_customers) ||
        ($old_engineers != $engineers) ||
        ($old_procurement_managers != $procurement_managers) ||
        ($old_current_customers != $current_customers) ||
        ($old_plant_managers != $plant_managers))
    {
        $autoUpdate = 1;
        $commentString .= "Target Audience Updated, ";
    }
    
    if (strcmp($old_audience_personal_info, $Info) !== 0){
        $autoUpdate = 1;
        $commentString .= "Other audience personal info: {$old_audience_personal_info}, ";
    }
    if (strcmp($old_purpose, $purpose) !== 0){
        $autoUpdate = 1;
        $commentString .= "Purpose: {$old_purpose}, ";
    }
    if (strcmp($old_key_message, $key_messages) !== 0){
        $autoUpdate = 1;
        $commentString .= "Key Message: {$old_key_message}, ";
    }
    if (strcmp($old_supporting_info, $support) !== 0){
        $autoUpdate = 1;
        $commentString .= "Supporting Info: {$old_supporting_info}, ";
    }
    if (strcmp($old_is_photography_needed, $is_photography_needed) !== 0){
        $autoUpdate = 1;
        $commentString .= "Is Photo Needed: {$old_is_photography_needed}, ";
    }
    if (strcmp($old_needed_photography, $needed_photography) !== 0){
        $autoUpdate = 1;
        $commentString .= "Needed Photography: {$old_needed_photography}, ";
    }

    if (strcmp($old_estimated_quantity, $estimate) !== 0){
        $autoUpdate = 1;
        $commentString .= "Estimated Quantity: {$old_estimated_quantity}, ";
    }
    if (strcmp($old_means_of_delivery, $delivery) !== 0){
        $autoUpdate = 1;
        $commentString .= "Delivery: {$old_means_of_delivery}, ";
    }
    if (strcmp($old_date_needed, $date_needed) !== 0){
        $autoUpdate = 1;
        $commentString .= "Date Needed: {$old_date_needed}, ";
    }
    if (strcmp($old_available_budget, $budget) !== 0){
        $autoUpdate = 1;
        $commentString .= "Available Budget: {$old_available_budget}, ";
    }
    if (strcmp($old_cost_center_number, $cost) !== 0){
        $autoUpdate = 1;
        $commentString .= "Cost: {$old_cost_center_number}, ";
    }

    $commentString .= "END Modified.";
    

    /*Search follow up info using interaction id posted from session value*/
    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
    $interactionResult = $conn->query($interactionQuery);
    $interactionRow = mysqli_fetch_array($interactionResult);
    
    
    
    
    /*UPDATING THE FORM IN THE DATABASE*/
    $stmt = $conn->prepare("UPDATE marketing_request_form SET
                                                            requester_name= ?,
                                                            market_segment= ?, 
                                                            sales_territory= ?, 
                                                            email= ?,
                                                            phone= ?,
                                                            request_date= ?,
                                                            name_project_or_piece= ?,
                                                            type_of_project= ?,
                                                            other_type_of_project= ?,
                                                            brochure= ?,
                                                            ppt= ?,
                                                            fact_sheet= ?,
                                                            video =?,
                                                            direct_mail= ?,
                                                            web= ?,
                                                            page= ?,
                                                            section= ?,
                                                            blog= ?,
                                                            landing_page= ?,
                                                            updt= ?,
                                                            graphic= ?,
                                                            tradeshow= ?,
                                                            promotional_item= ?,
                                                            print_aid= ?,
                                                            press_release= ?,
                                                            is_project_new= ?,
                                                            if_piece_new= ?,
                                                            prospective_customers= ?,
                                                            engineers= ?,
                                                            procurement_managers= ?,
                                                            current_customers= ?,
                                                            plant_managers= ?,
                                                            other_audience= ?,
                                                            audiance_personal_info= ?,
                                                            purpose= ?, 
                                                            key_message= ?, 
                                                            supporting_info= ?,
                                                            is_photography_needed= ?,
                                                            needed_photography= ?,
                                                            estimated_quantity= ?,
                                                            means_of_delivery= ?,
                                                            date_needed= ?,
                                                            available_budget= ?,
                                                            cost_center_number= ? 
                                                            WHERE marketing_request_id = ?" );
                                                

    if($stmt!== FALSE){
            
     $stmt->bind_param("sssssssssiiiiiiiiiiiiiiiiisiiiiissssssssssssi", $Requester_Name, $Market_Segment, $Sales_Territory, $Email, $Phone, $Date, $Name_of_Project, $type_of_project,$other_type_of_project, $brochure, $ppt, $fact_sheet, $video, $direct_mail, $web, $page, $section, $blog, $landing_page, $updt, $graphic, $tradeshow, $promotional_item, $print_aid, $press_release, $project_content, $update_info, $prospective_customers, $engineers, $procurement_managers, $current_customers, $plant_managers,$other_audience, $Info, $purpose,  $key_messages, $support, $is_photography_needed,  $needed_photography, $estimate, $delivery, $date_needed, $budget, $cost, $marketing_request_id);
    
     $stmt -> execute();
     $stmt->close();

    }else{
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }
    
    
    /*UPDATING THE STATUS AND FOLLOWUP IN THE INTERACTION TABLE*/
    /*Code for updating date in interaction table if form selected*/
    if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
        /*Prepare Update statement into the interaction table to update notification date*/
        $stmt2 = $conn->prepare("UPDATE interaction SET
                                    follow_up_date = ?
                                    WHERE interaction_id = ?");
        
        /*Assign follow up modified - must convert to date, modify, than convert back to string*/
        $fDate = strtotime($date_needed);
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
    
    
    /*UPDATING THE COMMENTS IN THE INTERACTION TABLE*/
    /*If autoUpdate == 1, do changes*/
    if ($autoUpdate == 1){
        
        //Implement This
        /*Ensure strlen(comments) does not reach max length of field*/
        
        
        $comments = $interactionRow['comments'];
        $comments .= "\n{$commentString}";
        $stmt3 = $conn->prepare("UPDATE interaction SET
                                        comments = ?
                                        WHERE interaction_id = ?");
        $stmt3->bind_param("si", $comments, $interactionNum);
        $stmt3->execute();
        $stmt3->close();
    } else {
        //do nothing
    }
    
    
    $conn->close();
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
   }

?>
	