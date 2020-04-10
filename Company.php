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
	
	function create(){
   


    // query to insert record
    $query = "INSERT INTO
                company (website, shipping_address_street,shipping_address_city,shipping_address_state,shipping_address_postalcode,
				shipping_address_country,billing_address_street,billing_address_city,billing_address_state, billing_address_postalcode,
				billing_address_country,description,type,industry,assigned_to,date_created,date_modified, created_by, company_name)
            VALUES(
              ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

  

    $stmt = $this->conn->prepare($query);


    echo"0";
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


echo "1";
   
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
	echo "2";
    // if($stmt->execute($this->website,)){
	// 	return true;
	// 	echo "3";
    // }
  
    return false;
      
}
// delete 
function delete(){
  
    // delete query
    $query = "DELETE FROM company WHERE company_id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->company_id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
function search($keywords){
  
	/*
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
	*/
    // select all query
    $query = "SELECT
                *
            FROM
			  company
            WHERE
			company_id  LIKE ? OR website LIKE ? OR shipping_address_street LIKE ?OR shipping_address_city LIKE ?
			OR shipping_address_state LIKE ?
			OR shipping_address_postalcode LIKE ?
			OR shipping_address_country LIKE ?
			OR billing_address_street LIKE ?
			OR billing_address_city LIKE ?
			OR billing_address_state LIKE ?
			OR billing_address_postalcode LIKE ?
			OR billing_address_country LIKE ?
			OR description LIKE ?
			OR type LIKE ?
			OR industry LIKE ?
			OR assigned_to LIKE ?
			OR date_created LIKE ?
			OR date_modified LIKE ?
			OR created_by LIKE ?
			OR company_name LIKE ?";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
  
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
	$stmt->bindParam(3, $keywords);
	$stmt->bindParam(4, $keywords);
    $stmt->bindParam(5, $keywords);
	$stmt->bindParam(6, $keywords);
	$stmt->bindParam(7, $keywords);
    $stmt->bindParam(8, $keywords);
	$stmt->bindParam(9, $keywords);
	$stmt->bindParam(10, $keywords);
    $stmt->bindParam(11, $keywords);
	$stmt->bindParam(12, $keywords);
	$stmt->bindParam(13, $keywords);
    $stmt->bindParam(14, $keywords);
	$stmt->bindParam(15, $keywords);
	
	$stmt->bindParam(16, $keywords);
    $stmt->bindParam(17, $keywords);
	$stmt->bindParam(18, $keywords);
	$stmt->bindParam(19, $keywords);
    $stmt->bindParam(20, $keywords);

	
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// update the product
function update(){
  
    // update query
    $query = "UPDATE
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
	   created_by=:created_by, company_name=:company_name;
	   WHERE
	   company_id = :company_id";



$stmt = $this->conn->prepare($query);


echo"0";
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
$this->company_id=htmlspecialchars(strip_tags($this->company_id));


echo "1";

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
$stmt->bindParam(":company_id", $this->company_id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
	
}
?>