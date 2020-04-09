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
	// create product
	function create(){
   


    // query to insert record
    $query = "INSERT INTO
                company
            SET
                website=:website, shipping_address_street=:shipping_address_street, 
				shipping_address_city=:shipping_address_city, shipping_address_state=:shipping_address_state, 
				shipping_address_postalcode=:shipping_address_postalcode, 
				shipping_address_country=:shipping_address_country, billing_address_street=:billing_address_street,
				billing_address_city=:billing_address_city, 
				billing_address_state=:billing_address_state, billing_address_postalcode=:billing_address_postalcode,
				billing_address_country=:billing_address_country, 
				description=:description, type=:type, industry=:industry, 
				assigned_to=:assigned_to, date_created=:date_created, date_modified=:date_modified, 
				created_by=:created_by, company_name=:company_name";

  

    $stmt = $this->conn->prepare($query);


    
    $this->website=htmlspecialchars(strip_tags($this->website));
    $this->shipping_address_street=htmlspecialchars(strip_tags($this->shipping_address_street));
    $this->shipping_address_city=htmlspecialchars(strip_tags($this->shipping_address_city));
    $this->shipping_address_state=htmlspecialchars(strip_tags($this->shipping_address_state));
	$this->shipping_address_postalcode=htmlspecialchars(strip_tags($this->shipping_address_postalcode));
    $this->shipping_address_country=htmlspecialchars(strip_tags($this->shipping_address_country));
    $this->billing_address_street=htmlspecialchars(strip_tags($this->billing_address_street));
    $this->billing_address_city=htmlspecialchars(strip_tags($this->billing_address_city));
    $this->billing_address_state=htmlspecialchars(strip_tags($this->billing_address_state));
	$this->billing_address_postalcode=htmlspecialchars(strip_tags($this->billing_address_postalcode));
    $this->billing_address_country=htmlspecialchars(strip_tags($this->billing_address_country));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->type=htmlspecialchars(strip_tags($this->type));
    $this->industry=htmlspecialchars(strip_tags($this->industry));
	$this->assigned_to=htmlspecialchars(strip_tags($this->assigned_to));
    $this->date_created=htmlspecialchars(strip_tags($this->date_created));
    $this->date_modified=htmlspecialchars(strip_tags($this->date_modified));
    $this->created_by=htmlspecialchars(strip_tags($this->created_by));
    $this->company_name=htmlspecialchars(strip_tags($this->company_name));



   
    $stmt->bindParam(":website", $this->website);
    $stmt->bindParam(":shipping_address_street", $this->shipping_address_street);
    $stmt->bindParam(":shipping_address_city", $this->shipping_address_city);
    $stmt->bindParam(":shipping_address_state", $this->shipping_address_state);
  
	$stmt->bindParam(":shipping_address_postalcode", $this->shipping_address_postalcode);
    $stmt->bindParam(":shipping_address_country", $this->shipping_address_country);
    $stmt->bindParam(":billing_address_street", $this->billing_address_street);
    $stmt->bindParam(":billing_address_city", $this->billing_address_city);
	$stmt->bindParam(":billing_address_state", $this->billing_address_state);
	
	$stmt->bindParam(":billing_address_postalcode", $this->billing_address_postalcode);
    $stmt->bindParam(":billing_address_country", $this->billing_address_country);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":type", $this->type);
    $stmt->bindParam(":industry", $this->industry);
  
	$stmt->bindParam(":assigned_to", $this->assigned_to);
    $stmt->bindParam(":date_created", $this->date_created);
    $stmt->bindParam(":date_modified", $this->date_modified);
    $stmt->bindParam(":created_by", $this->created_by);
    $stmt->bindParam(":company_name", $this->company_name);
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
	
}
?>
