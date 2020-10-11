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
    if($stmt->execute($this.website,$this.shipping_address_street,$this.shipping_address_city,$this.shipping_address_state,$this.shipping_address_postalcode,$this.shipping_address_country,$this.billing_address_street,$this.billing_address_city,$this.billing_address_state,$this.billing_address_postalcode,$this.billing_address_country,$this.description,$this.type,$this.industry,$this.assigned_to,$this.date_created,$this.date_modified,$this.created_by,$this.company_name)){
		return true;
		echo "3";
    }
  
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
function search($name, $website, $address, $city, $state, $country, $assigned_To, $created_By){
  
    
    //Build the query depending on the variables passed
    
    $query = "SELECT
                *
            FROM
			  nylene.company
            WHERE";
    
    if($name != ""){
        $query += " company_name LIKE ? ";
    }
    
    if($website != "http://"){
        if($name == "" ){
            $query += " website LIKE ?";
        }
        else{
            $query += " AND website LIKE ?";
        }
    }
        
    if($address != ""){
        if($name == "" && $website == "http://"){
            $query += " billing_address_street LIKE ?";
        }
        else{
            $query += " AND billing_address_street LIKE ?";
        }
    }
    
    if($city != ""){
        if($name == "" && $website == "http://" && $address == ""){
            $query += " billing_address_city LIKE ?";
        }
        else{
            $query += " AND billing_address_city LIKE ?";
        }
    }
    
    if($state != ""){
        if($name == "" && $website == "http://" && $address == "" && $city == ""){
            $query += " billing_address_state LIKE ?";
        }
        else{
            $query += " AND billing_address_state LIKE ?";
        }
    }
    
    if($country != ""){
        if($name == "" && $website == "http://" && $address == "" && $city == "" && $state == ""){
            $query += " billing_address_country LIKE ?";
        }
        else{
            $query += " AND billing_address_country LIKE ?";
        }
    }
    
    if($assigned_To != ""){
        if($name == "" && $website == "http://" && $address == "" && $city == "" && $state == "" && $country == ""){
            $query += " assigned_to LIKE ?";
        }
        else{
            $query += " AND assigned_to LIKE ?";
        }
    }
    
    if($created_By != ""){
        if($name == "" && $website == "http://" && $address == "" && $city == "" && $state == "" && $country == "" && $assigned_To == ""){
            $query += " created_by LIKE ?";
        }
        else{
            $query += " AND created_by LIKE ?";
        }
    }
    
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // sanitize
    $name=htmlspecialchars(strip_tags($name));
    $website=htmlspecialchars(strip_tags($website));
    $address=htmlspecialchars(strip_tags($address));
    $city=htmlspecialchars(strip_tags($city));
    $state=htmlspecialchars(strip_tags($state));
    $country=htmlspecialchars(strip_tags($country));
    $assigned_To=htmlspecialchars(strip_tags($assigned_To));
    $created_By=htmlspecialchars(strip_tags($created_By));
    
    $name = $name."%";
    $website = $website."%";
    $address = $address."%";
    $city = $city."%";
    $state = $state."%";
    $country = $country."%";

  
    
    $stmt->bindParam(ssssssii, $name, $website, $address, $city, $state, $country, $assigned_To, $created_By);
    /* $stmt->bindParam(2, $website);
    $stmt->bindParam(3, $address);
    $stmt->bindParam(4, $city);
    $stmt->bindParam(5, $state);
    $stmt->bindParam(6, $country);
    $stmt->bindParam(7, $assigned_To);
    $stmt->bindParam(8, $created_By); */
   /*$stmt->bindParam(9, $keywords);
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
    $stmt->bindParam(20, $keywords); */

	
  
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