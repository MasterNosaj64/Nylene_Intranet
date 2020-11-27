 <html>
<?php

/* Name: MMform_database.php
 * Author: Karandeep Singh, modified by Kaitlyn Breker
 * Last Modified: November 27th, 2020
 * Purpose: insert into db
 */

// if a session is not started, start a session

    session_start();
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
            $fDate = strtotime($date_needed);
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