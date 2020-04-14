<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once 'Database.php';
  
// instantiate company object
include_once 'Company.php';
  
$database = new Database();
$db = $database->getConnection();
  
$Company = new Company($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->website) &&
    !empty($data->billing_address_street) &&
    !empty($data->billing_address_city) &&
    !empty($data->billing_address_state)&&
    !empty($data->billing_address_postalcode) &&
    !empty($data->billing_address_country) &&
    !empty($data->shipping_address_country) &&
    !empty($data->shipping_address_postalcode) &&
    !empty($data->shipping_address_state) &&
    !empty($data->shipping_address_city)&&
    !empty($data->shipping_address_street) &&
    !empty($data->description) &&
    !empty($data->type)&&
    !empty($data->industry) &&
    !empty($data->assigned_to) &&
	!empty($data->company_name)
){
  
    // set company property values
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
	

  
    // create the company
    if($Company->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Company was created."));
    }
  
    // if unable to create the Company, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create Company."));
    }
    }

  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create Company. Data is incomplete."));
}
?>