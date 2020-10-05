
<?php

    if (!session_id()){
        session_start();
       // include '../Database/connect.php';
    }

    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_DATABASE = "nylene";

    $connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD,$DB_DATABASE);
if($connect){
    if(isset($_POST['Submit'])){
  
$Requester_Name=$_POST['Requester_Name'];
$Market_Segment=$_POST['Market_Segment'];
$Sales_Territory=$_POST['Sales_Territory'];
$Email=$_POST['Email'];
$Phone=$_POST['Phone'];
$Date=$_POST['Date'];
$Name_of_Project=$_POST['Name_of_Project'];
$type_of_project=$_POST['type_of_project'];
//$brochure=$_POST['brochure'];
//$ppt=$_POST['ppt'];
//$Fact_Sheet=$_POST['Fact_Sheet'];
//$video=$_POST['video'];
//$mail=$_POST['mail'];
//$web=$_POST['web'];
  //  $Page=$_POST['Page'];
//    $Section=$_POST['Section'];
  //  $Blog=$_POST['Blog'];
    //$Landing_Page=$_POST['Landing_Page'];
    //$Update=$_POST['Update'];
    //$graphic=$_POST['graphic'];
    //$Tradeshow=$_POST['Tradeshow'];
    //$item=$_POST['item'];
    //$print=$_POST['print'];
    //$other=$_POST['other'];
    //$release=$_POST['release'];
    //$other_type=$_POST['other_type'];
    $project_content=$_POST['project_content'];
    $new=$_POST['new'];
    $update=$_POST['update'];
    $update_project=$_POST['update_project'];
    $target=$_POST['target'];
    $prospective_customers=$_POST['prospective_customers'];
    $Engineers=$_POST['Engineers'];
    $buyers=$_POST['buyers'];
    $current=$_POST['current'];
    $plant_managers=$_POST['plant_managers'];
    $Other=$_POST['Other'];
    $customer_type=$_POST['customer_type'];
    $Info=$_POST['Info'];
    $info_text=$_POST['info_text'];
    $photography=$_POST['photography'];
    $purpose=$_POST['purpose'];
    $key_messages=$_POST['key_messages'];
    $support=$_POST['support'];
    $photo=$_POST['photo'];
    $estimate=$_POST['estimate'];
    $delivery=$_POST['delivery'];
    $date_needed=$_POST['date_needed'];
    $budget=$_POST['budget'];
    $cost=$_POST['cost'];


 $db=mysqli_select_db($connect,$DB_DATABASE);
    //echo '<h1>Connected to MySQL</h1>';
//for($i=0;$i<sizeof ($type_of_project);$i++){
    //$query=mysqli_query($connect,"INSERT INTO marketing_request_form(type_of_project) VALUES ('$type_of_project')");
//}
    $query=mysqli_query($connect,"INSERT INTO marketing_request_form(Requester_Name, Market_Segment, Sales_Territory,Email,Phone,Name_of_Project,type_of_project, project_content, new, update, update_project, target, prospective_customers, Engineers, buyers, current, plant_managers, Other, customer_type, Info, info_text, photography, key_messages, support, photo, estimate, delivery, date_needed, budget, cost ) VALUES ('$Requester_Name', '$Market_Segment', '$Sales_Territory','$Email','$Phone','$Name_of_Project','$type_of_project','$project_content','$new','$update','$update_project','$target','$prospective_customers','$Engineers','$buyers','$current','$plant_managers','$Other','$customer_type','$Info','$info_text','$photography','$key_messages,'$support','$photo','$estimate','$delivery','$date_needed','$budget','$cost')");
	if ($query) {
			header('Location: ../Home/Homepage.php');

	}
	else{ 
        echo (mysqli_error($connect)) ;
		echo "           fail";
    }

}else{ echo "failed post";}}//
else{
    echo ("failed;");
}


?>
