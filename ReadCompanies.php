<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'Database.php';
include_once 'Company.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$company = new Company($db);
$stmt = $company->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    
    $companies_arr=array();
    $companies_arr[$num]=array();
  
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $company_item=array(
		/*    public $company_id;
    public $website;
  
    public $shipping_address_street;
	public $shipping_address_city;
	public $shipping_address_state;
	public $shipping_address_postalcode;
	public $shipping_address_country;
	public $billing_address_street;
	public $billing_address_city;
	public $billing_address_state;
	public $billing_address_postalcode;
	public billing_address_country;
	public $description; 
	public $type; 
	public $industry; 
	public $assigned_to; 
	public $date_created; 
	public $date_modified; 
	public $created_by; 
	public $company_name; 
		*/
            "company_id" => $company_id,
            "website" => $website,
            "description" => $description,
            "shipping_address_street" => $shipping_address_street,
            "shipping_address_city" => $shipping_address_city,
			"shipping_address_postalcode" => $shipping_address_postalcode,
            "shipping_address_state" => $shipping_address_state,
			"shipping_address_country" => $shipping_address_country,
			"billing_address_street" => $billing_address_street,
            "billing_address_city" => $billing_address_city,
			"billing_address_state" => $billing_address_state,
            "billing_address_country" => $billing_address_country,
			"billing_address_postalcode" => $billing_address_postalcode,
			"industry" => $industry,
            "assigned_to" => $assigned_to,
			"date_created" => $date_created,
            "date_modified" => $date_modified,
			"created_by" => $created_by,
			"company_name" => $company_name,
            "type" => $type
        );
  
        array_push($companies_arr[$num], $company_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($companies_arr);
}
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

  ?>
