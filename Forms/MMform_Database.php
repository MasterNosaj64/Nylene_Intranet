<html>
<?php
// if a session is not started, start a session

    session_start();
    include '../Database/connect.php';

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
                                                            is_project_new,
                                                            if_piece_new,
                                                            target_audiance,
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
                                                            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    
    $Requester_Name = htmlspecialchars(strip_tags($_POST['Requester_Name']));
    $Market_Segment = htmlspecialchars(strip_tags($_POST['Market_Segment']));
    $Sales_Territory = htmlspecialchars(strip_tags($_POST['Sales_Territory']));
    $Email = htmlspecialchars(strip_tags($_POST['Email']));
    $Phone = htmlspecialchars(strip_tags($_POST['Phone']));
    $Date = htmlspecialchars(strip_tags($_POST['Date']));
    $Name_of_Project = htmlspecialchars(strip_tags($_POST['Name_of_Project']));
   $type_of_project = ($_POST['type_of_project']);
    for ($i=0; $i<count($_POST['type_of_project']);$i++){
        $type_of_project= $_POST['type_of_project'];
        if ($type_of_project='brochure'){
            $type_of_project='Brochure';
        }elseif($type_of_project='ppt'){
            $type_of_project='PowerPoint Presentation';
            }elseif ($type_of_project='Fact_Sheet'){
            $type_of_project='Fact Sheet';
        }elseif ($type_of_project='video'){
            $type_of_project='Video';
        }elseif ($type_of_project='mail'){
            $type_of_project='Direct Mail';
        }elseif ($type_of_project='web'){
            $type_of_project='Web';
        }elseif ($type_of_project='Page'){
            $type_of_project='Page';
        }elseif ($type_of_project='Section'){
            $type_of_project='Section';
        }elseif ($type_of_project='Blog'){
            $type_of_project='Blog';
        }elseif ($type_of_project='Landing_Page'){
            $type_of_project='Landing Page';
        }elseif ($type_of_project='Update'){
            $type_of_project='Update';
        }elseif ($type_of_project='graphic'){
            $type_of_project='Graphic';
        }elseif ($type_of_project='Tradeshow'){
            $type_of_project='Tradeshow';
        }elseif ($type_of_project='item'){
            $type_of_project='Promotional Item/Giveaway';
        }elseif ($type_of_project='print'){
            $type_of_project='Print Aid';
        }elseif ($type_of_project='other'){
            $type_of_project='Other';
        }elseif ($type_of_project='release'){
            $type_of_project='Press Release/E-Blast';
        }
        if ($type_of_project){
            $insert= "INSERT into marketing_request_form(type_of_project) values ('$type_of_project')";
        }
    }
    
    $project_content = htmlspecialchars(strip_tags($_POST['project_content']));
    $update_info = htmlspecialchars(strip_tags($_POST['update_info']));
    $target = htmlspecialchars(strip_tags($_POST['target']));
    $Info = htmlspecialchars(strip_tags($_POST['Info']));
    $purpose = htmlspecialchars(strip_tags($_POST['purpose']));
    $key_messages = htmlspecialchars(strip_tags($_POST['key_messages']));
    $support = htmlspecialchars(strip_tags($_POST['support']));
  //  $is_photography_needed = htmlspecialchars(strip_tags($_POST['is_photography_needed']));
    $needed_photography = htmlspecialchars(strip_tags($_POST['needed_photography']));
    $estimate = htmlspecialchars(strip_tags($_POST['estimate']));
    $delivery = htmlspecialchars(strip_tags($_POST['delivery']));
    $date_needed = htmlspecialchars(strip_tags($_POST['date_needed']));
    $budget = htmlspecialchars(strip_tags($_POST['budget']));
    $cost = htmlspecialchars(strip_tags($_POST['cost']));
     $stmt->bind_param("ssssssssssssssssssssss", $Requester_Name, $Market_Segment, $Sales_Territory, $Email, $Phone, $Date, $Name_of_Project, $type_of_project, $project_content, $update_info,  $target, $Info, $purpose,  $key_messages, $support, $is_photography_needed, $needed_photography, $estimate, $delivery, $date_needed, $budget, $cost);
    
     $stmt -> execute();
    
     $getFormId = "SELECT marketing_request_id FROM marketing_request_form ORDER BY marketing_request_id DESC";
        $formId = $conn->query($getFormId);
        $id_form = mysqli_fetch_array($formId);
    
     $stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
                                     interaction_id,
                                     form_id, form_type)
                                      VALUES (?,?,?)");

        $stmt2 -> bind_param("iii", $interactionNum, $formId, $formType);
    
    $interactionNum = $interaction_id;
        $formId = $id_form['marketing_request_id'];
        $formType = 5;
        
        $stmt2 -> execute();
     
        $stmt->close();
        $stmt2->close();
        $conn->close();
        
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
        exit();
   }

?>
</html>
/*
if ($conn) {
    if (isset($_POST['Submit'])) {
        $interaction_id = $_SESSION['interaction_id'];
        $Requester_Name = $_POST['Requester_Name'];
        $Market_Segment = $_POST['Market_Segment'];
        $Sales_Territory = $_POST['Sales_Territory'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $Date = $_POST['Date'];
        $Name_of_Project = $_POST['Name_of_Project'];
        $type_of_project = $_POST['type_of_project'];
        $project_content = $_POST['project_content'];
        $update_info = $_POST['update_info'];
        $target = $_POST['target'];
        $Info = $_POST['Info'];
        $purpose = $_POST['purpose'];
        $key_messages = $_POST['key_messages'];
        $support = $_POST['support'];
        $is_photography_needed = $_POST['is_photography_needed'];
        $photography_needed = $_POST['needed_photography'];
        $estimate = $_POST['estimate'];
        $delivery = $_POST['delivery'];
        $date_needed = $_POST['date_needed'];
        $budget = $_POST['budget'];
        $cost = $_POST['cost'];

        /*
         * if(isset($_POST['type_of_project'])){
         * $t1=implode(',', $_POST['type_of_project']);
         */
    }
    // $in_ch=mysqli_query($conn,"insert into marketing_request_form(type_of_project) values ('$t1')");

    $db = mysqli_select_db($conn, $dbname);

    $query = mysqli_query($conn, "INSERT INTO marketing_request_form(requester_name,market_segment, sales_territory,email,phone,request_date,
                                  name_project_or_piece,is_project_new, if_piece_new, target_audiance, audiance_personal_info, purpose, key_message, 
                                  supporting_info, is_photography_needed, needed_photography, estimated_quantity, means_of_delivery, date_needed, 
                                  available_budget, cost_center_number ) 
                                  VALUES ('$Requester_Name','$Market_Segment', '$Sales_Territory','$Email','$Phone','$Date', '$Name_of_Project','$project_content',
                                  '$update_info','$target','$Info','$purpose','$key_messages','$support','$is_photography_needed','$needed_photography','$estimate',
                                  '$delivery','$date_needed','$budget','$cost')");

    $getFormId = "SELECT marketing_request_id FROM marketing_request_form ORDER BY marketing_request_id DESC";
    $formId = $conn->query($getFormId);
    $id_form = mysqli_fetch_array($formId);

    $insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['marketing_request_id'] . ", '5')";

    if ($conn->query($insert_into_interaction_relational_manager_table) === TRUE) {
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
else{ echo "failed post";}//

?>
*/