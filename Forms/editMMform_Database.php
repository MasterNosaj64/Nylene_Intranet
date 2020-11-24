<?php
/*
 * Name: editMMform_Database.php
 * Author: Karandeep Singh
 */
if (!session_id()) {
 session_start();}Q
include '../Database/databaseConnection.php';
include '../Database/connect.php';
			
			$field=$_SESSION['field'];

$query_marketing	= "SELECT * FROM marketing_request_form WHERE marketing_request_id = " . $field;
	$query_marketing_results = $conn->query($query_marketing);
	$row = mysqli_fetch_array($query_marketing_results);

if (isset($_POST['requester_name']))
	{
		$Requester_Name = $_POST['requester_name'];
		
	}
	else 
	{
		$Requester_Name = $row['requester_name'];
	}

if (isset($_POST['market_segment']))
{
		$Market_Segment = $_POST['market_segment'];
		
	}
	else 
	{
		$Market_Segment = $row['market_segment'];
	}
	
if (isset($_POST['sales_territory']))
{
		$Sales_Territory = $_POST['sales_territory'];
		
	}
	else 
	{
		$Sales_Territory = $row['sales_territory'];
	}

if (isset($_POST['email']))
{
		$Email = $_POST['email'];
		
	}
	else 
	{
		$Email = $row['email'];
	}

if (isset($_POST['phone']))
{
		$Phone = $_POST['phone'];
		
	}
	else 
	{
		$Phone = $row['phone'];
	}

if (isset($_POST['request_date']))
{
		$Date = $_POST['request_date'];
		
	}
	else 
	{
		$Date = $row['request_date'];
	}

if (isset($_POST['name_project_or_piece']))
{
		$Name_of_Project = $_POST['name_project_or_piece'];
		
	}
	else 
	{
		$Name_of_Project = $row['name_project_or_piece'];
	}

if (isset($_POST['type_of_project']))
{
		$type_of_project = $_POST['type_of_project'];
		
	}
	else 
	{
		$type_of_project = $row['type_of_project'];
	}

if (isset($_POST['brochure']))
	{
		$brochure = $_POST['brochure'];
	}
	else 
	{
		$brochure = $row['brochure'];
	}
    
    if (isset($_POST['ppt']))
	{
		$ppt = $_POST['ppt'];
	}
	else 
	{
		$ppt = $row['ppt'];
	}
    
    if (isset($_POST['fact_sheet']))
	{
		$fact_sheet = $_POST['fact_sheet'];
	}
	else 
	{
		$fact_sheet = $row['fact_sheet'];
	}
    
    if (isset($_POST['video']))
	{
		$video = $_POST['video'];
	}
	else 
	{
		$video = $row['video'];
	}
    
    if (isset($_POST['direct_mail']))
	{
		$direct_mail = $_POST['direct_mail'];
	}
	else 
	{
		$direct_mail = $row['direct_mail'];
	}
    
    if (isset($_POST['web']))
	{
		$web = $_POST['web'];
	}
	else 
	{
		$web = $row['web'];
	}
    
    if (isset($_POST['page']))
	{
		$page = $_POST['page'];
	}
	else 
	{
		$page =$row['page'];
	}
    
    if (isset($_POST['section']))
	{
		$section = $_POST['section'];
	}
	else 
	{
		$section = $row['section'];
	}
    
    if (isset($_POST['blog']))
	{
		$blog = $_POST['blog'];
	}
	else 
	{
		$blog = $row['blog'];
	}
    
    if (isset($_POST['landing_page']))
	{
		$landing_page = $_POST['landing_page'];
	}
	else 
	{
		$landing_page = $row['landing_page'];
	}
    
    if (isset($_POST['updt']))
	{
		$updt = $_POST['updt'];
	}
	else 
	{
		$updt = $row['updt'];
	}
    
    if (isset($_POST['graphic']))
	{
		$graphic = $_POST['graphic'];
	}
	else 
	{
		$graphic = $row['graphic'];
	}
    
    if (isset($_POST['tradeshow']))
	{
		$tradeshow = $_POST['tradeshow'];
	}
	else 
	{
		$tradeshow = $row['tradeshow'];
	}
    
    if (isset($_POST['promotional_item']))
	{
		$promotional_item = $_POST['promotional_item'];
	}
	else 
	{
		$promotional_item = $row['promotional_item'];
	}
    
    if (isset($_POST['print_aid']))
	{
		$print_aid = $_POST['print_aid'];
	}
	else 
	{
		$print_aid = $row['print_aid'];
	}
    if (isset($_POST['press_release']))
	{
		$press_release = $_POST['press_release'];
	}
	else 
	{
		$press_release = $row['press_release'];
	}

if (isset($_POST['other_type_of_project']))
	{
		$other_type_of_project = $_POST['other_type_of_project'];
	}
	else 
	{
		$other_type_of_project = $row['other_type_of_project'];
	}

if (isset($_POST['is_project_new']))
	{
		$project_content = $_POST['is_project_new'];
	}
	else 
	{
		$project_content = $row['is_project_new'];
	}

if (isset($_POST['if_piece_new']))
	{
		$update_info = $_POST['is_piece_new'];
	}
	else 
	{
		$update_info = $row['is_piece_new'];
	}

if (isset($_POST['prospective_customers']))
	{
		$prospective_customers = $_POST['prospective_customers'];
	}
	else 
	{
		$prospective_customers = $row['prospective_customers'];
	}
    
    if (isset($_POST['engineers']))
	{
		$engineers = $_POST['engineers'];
	}
	else 
	{
		$engineers = $row['engineers'];
	}
    
    if (isset($_POST['procurement_managers']))
	{
		$procurement_managers = $_POST['procurement_managers'];
	}
	else 
	{
		$procurement_managers = $row['procurement_managers'];
	}
    
    if (isset($_POST['current_customers']))
	{
		$current_customers = $_POST['current_customers'];
	}
	else 
	{
		$current_customers = $row['current_customers'];
	}
    
    if (isset($_POST['plant_managers']))
	{
		$plant_managers = $_POST['plant_managers'];
	}
	else 
	{
		$plant_managers = $row['plant_managers'];
	}
if (isset($_POST['other_audience']))
	{
		$other_audience = $_POST['other_audience'];
	}
	else 
	{
		$other_audience = $row['other_audience'];
	}

if (isset($_POST['audiance_personal_info']))
	{
		$Info = $_POST['audiance_personal_info'];
	}
	else 
	{
		$Info = $row['audiance_personal_info'];
	}

if (isset($_POST['purpose']))
	{
		$purpose = $_POST['purpose'];
	}
	else 
	{
		$purpose = $row['purpose'];
	}

if (isset($_POST['key_message']))
	{
		$key_messages = $_POST['key_message'];
	}
	else 
	{
		$key_messages = $row['key_message'];
	}

if (isset($_POST['supporting_info']))
	{
		$support = $_POST['supporting_info'];
	}
	else 
	{
		$support = $row['supporting_info'];
	}

if (isset($_POST['is_photography_needed']))
	{
		$is_photography_needed = $_POST['is_photography_needed'];
	}
	else 
	{
		$is_photography_needed = $row['is_photography_needed'];
	}

if (isset($_POST['needed_photography']))
	{
		$needed_photography = $_POST['needed_photography'];
	}
	else 
	{
		$needeed_photography = $row['needed_photography'];
	}

if (isset($_POST['estimated_quantity']))
	{
		$estimate = $_POST['estimated_quantity'];
	}
	else 
	{
		$estimate = $row['estimated_quantity'];
	}


if (isset($_POST['means_of_delivery']))
	{
		$delivery = $_POST['means_of_delivery'];
	}
	else 
	{
		$delivery = $row['means_of_delivery'];
	}

if (isset($_POST['date_needed']))
	{
		$date_needed = $_POST['date_needed'];
	}
	else 
	{
		$date_needed = $row['date_needed'];
	}

if (isset($_POST['available_budget']))
	{
		$budget = $_POST['available_budget'];
	}
	else 
	{
		$budget = $row['available_budget'];
	}

if (isset($_POST['cost_center_number']))
	{
		$cost = $_POST['cost_center_number'];
	}
	else 
	{
		$cost = $row['cost_center_number'];
	}

$conn = getDBConnection();
// if connection is established,
if ($conn->connect_error) {
    
    die("Connection failed: " . $conn->connect_error);
} else {
    
    $interaction_id = $_SESSION['interaction_id'];
    $stmt = $conn->prepare("INSERT INTO marketing_request_form(requester_name,
                                                            market_segment, 
                                                            sales_territory, 
                                                            email,
                                                            phone,
                                                            request_date,
                                                            name_project_or_piece,
                                                            type_of_project,
                                                            other_type_of_project,
                                                            brochure,
                                                            ppt,
                                                            fact_sheet,
                                                            video,
                                                            direct_mail,
                                                            web,
                                                            page,
                                                            section,
                                                            blog,
                                                            landing_page,
                                                            updt,
                                                            graphic,
                                                            tradeshow,
                                                            promotional_item,
                                                            print_aid,
                                                            press_release,
                                                            is_project_new,
                                                            if_piece_new,
                                                            prospective_customers,
                                                            engineers,
                                                            procurement_managers,
                                                            current_customers,
                                                            plant_managers,
                                                            other_audience,
                                                            audiance_personal_info,
                                                            purpose, 
                                                            key_message, 
                                                            supporting_info,
                                                            is_photography_needed,
                                                            needed_photography,
                                                            estimated_quantity,
                                                            means_of_delivery,
                                                            date_needed,
                                                            available_budget,
                                                            cost_center_number )
                                                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    
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
    
  //  if($stmt!== FALSE){
            
     $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssss", $Requester_Name, $Market_Segment, $Sales_Territory, $Email, $Phone, $Date, $Name_of_Project, $type_of_project,$other_type_of_project, $brochure, $ppt, $fact_sheet, $video, $direct_mail, $web, $page, $section, $blog, $landing_page, $updt, $graphic, $tradeshow, $promotional_item, $print_aid, $press_release, $project_content, $update_info, $prospective_customers, $engineers, $procurement_managers, $current_customers, $plant_managers,$other_audience, $Info, $purpose,  $key_messages, $support, $is_photography_needed,  $needed_photography, $estimate, $delivery, $date_needed, $budget, $cost);
    
     $stmt -> execute();
    
    /*
     $getFormId = "SELECT marketing_request_id FROM marketing_request_form ORDER BY marketing_request_id DESC";
        $formId = $conn->query($getFormId);
        $id_form = mysqli_fetch_array($formId);
    }else{
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }
    */
     $stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
                                     interaction_id,
                                     form_id, form_type)
                                      VALUES (?,?,?)");
    
    $interactionNum = $interaction_id;
        $formId = $conn-> insert_id;
        $formType = 5;
        
        $stmt2 -> bind_param("iii", $interactionNum, $formId, $formType);
        
        $stmt2 -> execute();
     
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
            $fDate = strtotime($Date);
		    $followDate = date("Y/m/d", $fDate);
		    $followUpDate = date_create($followDate);
		    date_modify($followUpDate, "+30 days");
		    $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
            
             $stmt3->bind_param("si", $followUpDateFormatted, $interactionNum);
		    
		    /*Execute statement*/
		    $stmt3->execute();
		    $stmt3->close();
        }else{
            
        };
        $conn->close();
       echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
        exit();
    
   }

?>
	