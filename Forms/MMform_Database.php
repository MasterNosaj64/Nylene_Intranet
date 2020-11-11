<?php
// if a session is not started, start a session
if (! session_id()) {
    session_start();
    include '../Database/connect.php';
}
$conn = getDBConnection();
// if connection is established,

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
}else{ echo "failed post";}//

?>
