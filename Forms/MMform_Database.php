<?php
//if a session is not started, start a session
    if (!session_id()){
        session_start();
       include '../Database/connect.php';
    }
$conn = getDBConnection();
//if connection is established, 
if($conn){
    if(isset($_POST['Submit'])){
  
//$Requester_Name=$_POST['Requester_Name'];
$Market_Segment=$_POST['Market_Segment'];
$Sales_Territory=$_POST['Sales_Territory'];
$Email=$_POST['Email'];
$Phone=$_POST['Phone'];
$Date=$_POST['Date'];
$Name_of_Project=$_POST['Name_of_Project'];
$type_of_project=$_POST['type_of_project'];
    $project_content=$_POST['project_content'];
    $update_info=$_POST['update_info'];
    $target=$_POST['target'];
    $Info=$_POST['Info'];
    $purpose=$_POST['purpose'];
    $key_messages=$_POST['key_messages'];
    $support=$_POST['support'];
    $photography=$_POST['photography'];
    $estimate=$_POST['estimate'];
    $delivery=$_POST['delivery'];
    $date_needed=$_POST['date_needed'];
    $budget=$_POST['budget'];
    $cost=$_POST['cost'];


 $db=mysqli_select_db($conn, $dbname );
    //echo '<h1>Connected to MySQL</h1>';
//for($i=0;$i<sizeof ($type_of_project);$i++){
    //$query=mysqli_query($connect,"INSERT INTO marketing_request_form(type_of_project) VALUES ('$type_of_project')");
//}
    $query=mysqli_query($conn,"INSERT INTO marketing_request_form(market_segment, sales_territory,email,phone,request_date, name_project_or_piece,type_of_project, is_project_new, if_piece_new, target_audiance, audiance_personal_info, purpose, key_message, supporting_info, is_photography_needed, estimated_quantity, means_of_delivery, date_needed, available_budget, cost_center_number ) VALUES ('$Market_Segment', '$Sales_Territory','$Email','$Phone','$Date', '$Name_of_Project','$type_of_project','$project_content','$update_info','$target','$Info','$purpose','$key_messages','$support','$photography','$estimate','$delivery','$date_needed','$budget','$cost')");
	if ($query) {
			header('Location: ../Interactions/companyHistory.php');

	}
	else{ 
        echo (mysqli_error($conn)) ;
		echo "           fail";
    }

}else{ echo "failed post";}}//
else{
    echo ("failed;");
}


?>
