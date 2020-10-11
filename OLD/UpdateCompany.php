<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../Database/Database.php';
include_once '../Company.Customer/Company.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare Company object
$Company = new Company($db);
  
// get id of Company 
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of Company to be edited
$Company->company_id = $data->company_id;
  
// set Company property values
$Company->website=	$data->website;
$Company->shipping_address_street= $data->shipping_address_street;
$Company->shipping_address_city=$data->shipping_address_city;
$Company->shipping_address_state=$data->shipping_address_state;
$Company->shipping_address_postalcode=$data->shipping_address_postalcode;
$Company->shipping_address_country=	$data->shipping_address_country;
$Company->billing_address_street=$data->billing_address_street;
$Company->billing_address_city=$data->billing_address_city;
$Company->billing_address_state=$data->billing_address_state;
$Company->billing_address_postalcode=	$data->billing_address_postalcode;
$Company->billing_address_country=	$data->billing_address_country;
$Company->description= 	$data->description; 
$Company->type= $data->type; 
$Company->industry= $data->industry; 
$Company->assigned_to= $data->assigned_to; 
$Company->date_created= date('Y-m-d');; 
 
$Company->created_by= 	"PostMan"; 
$Company->company_name= $data->company_name; 
  
// update the Company
if($Company->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Company was updated."));
}
  
// if unable to update the Company, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update Company."));
}
?>