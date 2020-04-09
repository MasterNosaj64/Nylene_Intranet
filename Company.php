<?php
class Company{
  
    // database connection and table name
    private $conn;
    private $table_name = "company";
  
    // object properties
    public $company_id;
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
	public $billing_address_country;
	public $description; 
	public $type; 
	public $industry; 
	public $assigned_to; 
	public $date_created; 
	public $date_modified; 
	public $created_by; 
	public $company_name; 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
	}


	public function read(){
	$query = "SELECT * FROM company";

	$stmt = $this->conn->prepare($query);
	
	$stmt->execute();
	return $stmt;
	}
	
}
?>
