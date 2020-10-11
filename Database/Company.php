<?php

class Company
{

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
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM company";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);
        
        return $stmt;
    }

    function create()
    {

        // query to insert record
        $query = "INSERT INTO
                company (website, shipping_address_street,shipping_address_city,shipping_address_state,shipping_address_postalcode,
				shipping_address_country,billing_address_street,billing_address_city,billing_address_state, billing_address_postalcode,
				billing_address_country,description,type,industry,assigned_to,date_created,date_modified, created_by, company_name)
            VALUES(
              ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);

        echo "0";
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->shipping_address_street = htmlspecialchars(strip_tags($this->shipping_address_street));
        $this->shipping_address_city = htmlspecialchars(strip_tags($this->shipping_address_city));
        $this->shipping_address_state = htmlspecialchars(strip_tags($this->shipping_address_state));
        $this->shipping_address_postalcode = htmlspecialchars(strip_tags($this->shipping_address_postalcode));
        $this->shipping_address_country = htmlspecialchars(strip_tags($this->shipping_address_country));
        $this->billing_address_street = htmlspecialchars(strip_tags($this->billing_address_street));
        $this->billing_address_city = htmlspecialchars(strip_tags($this->billing_address_city));
        $this->billing_address_state = htmlspecialchars(strip_tags($this->billing_address_state));
        $this->billing_address_postalcode = htmlspecialchars(strip_tags($this->billing_address_postalcode));
        $this->billing_address_country = htmlspecialchars(strip_tags($this->billing_address_country));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->industry = htmlspecialchars(strip_tags($this->industry));
        $this->assigned_to = htmlspecialchars(strip_tags($this->assigned_to));
        $this->date_created = htmlspecialchars(strip_tags($this->date_created));
        $this->date_modified = htmlspecialchars(strip_tags($this->date_modified));
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));

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
        if ($stmt->execute($this . website, $this . shipping_address_street, $this . shipping_address_city, $this . shipping_address_state, $this . shipping_address_postalcode, $this . shipping_address_country, $this . billing_address_street, $this . billing_address_city, $this . billing_address_state, $this . billing_address_postalcode, $this . billing_address_country, $this . description, $this . type, $this . industry, $this . assigned_to, $this . date_created, $this . date_modified, $this . created_by, $this . company_name)) {
            return true;
            echo "3";
        }

        return false;
    }

    // delete
    function delete()
    {

        // delete query
        $query = "DELETE FROM company WHERE company_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->company_id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    
    /*
     * Function Name: getname
     * Version: 0.6
     * Date Modified: 10/11/2020
     * Author: Jason Waid
     * Purpose: Function returns the company_name of the object
     *
     */
    function getname(){
        
        
        return $this->company_name;
    }
    
    function getAssignedTo(){
        return $this->assigned_to;
    }
    
    function getCreatedBy(){
        return $this->created_by;
    }
    
    /*
     * Function Name: search
     * Version: 0.6
     * Date Modified: 10/11/2020
     * Author: Jason Waid
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     *
     */
    function search($name, $website, $address, $city, $state, $country, $assigned_To, $created_By)
    {

        // number of string parameters
        $stringCount = 0;
        // number of integer parameters
        $intCount = 0;
        // String for keeping track of the parameter types
        $paramTypes = "";
        // The paramters to be added to the prepared SQL statement
        $params = array();

        // append query string, sanitize then apply % wildcard character to end of entered parmeter
        
        $query = "SELECT
                *
            FROM
			  nylene.company";

        if ($name != "") {
            $query .= " WHERE company_name LIKE ? ";
            $stringCount ++;
            $paramTypes .= "s";
            $name = htmlspecialchars(strip_tags($name));
            $name .= "%";
            array_push($params, $name);
        }

        if ($website != "http://") {
            if ($name == "") {
                $query .= " WHERE website LIKE ?";
            } else {
                $query .= " AND website LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $website = htmlspecialchars(strip_tags($website));
            $website .= "%";
            array_push($params, $website);
        }

        if ($address != "") {
            if ($name == "" && $website == "http://") {
                $query .= " WHERE billing_address_street LIKE ?";
            } else {
                $query .= " AND billing_address_street LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $address = htmlspecialchars(strip_tags($address));
            $address .= "%";
            array_push($params, $address);
        }

        if ($city != "") {
            if ($name == "" && $website == "http://" && $address == "") {
                $query .= " WHERE billing_address_city LIKE ?";
            } else {
                $query .= " AND billing_address_city LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $city = htmlspecialchars(strip_tags($city));
            $city .= "%";
            array_push($params, $city);
        }

        if ($state != "") {
            if ($name == "" && $website == "http://" && $address == "" && $city == "") {
                $query .= " WHERE billing_address_state LIKE ?";
            } else {
                $query .= " AND billing_address_state LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $state = htmlspecialchars(strip_tags($state));
            $state .= "%";
            array_push($params, $state);
        }

        if ($country != "") {
            if ($name == "" && $website == "http://" && $address == "" && $city == "" && $state == "") {
                $query .= " WHERE billing_address_country LIKE ?";
            } else {
                $query .= " AND billing_address_country LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $country = htmlspecialchars(strip_tags($country));
            $country .= "%";
            array_push($params, $country);
        }

        if ($assigned_To != "") {
            if ($name == "" && $website == "http://" && $address == "" && $city == "" && $state == "" && $country == "") {
                $query .= " WHERE assigned_to LIKE ?";
            } else {
                $query .= " AND assigned_to LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $assigned_To = htmlspecialchars(strip_tags($assigned_To));
            array_push($params, $assigned_To);
        }

        if ($created_By != "") {
            if ($name == "" && $website == "http://" && $address == "" && $city == "" && $state == "" && $country == "" && $assigned_To == "") {
                $query .= " WHERE created_by LIKE ?";
            } else {
                $query .= " AND created_by LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $created_By = htmlspecialchars(strip_tags($created_By));
            array_push($params, $created_By);
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // determine number of parameters
        // seperate counters were used for debugging
        $paramCount = $stringCount + $intCount;

        switch ($paramCount) {

            case 1:

                $stmt->bind_param($paramTypes, $params[0]);
                break;
            case 2:

                $stmt->bind_param($paramTypes, $params[0], $params[1]);
                break;
            case 3:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2]);
                break;
            case 4:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3]);
                break;
            case 5:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4]);
                break;
            case 6:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
                break;
            case 7:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6]);
                break;
            case 8:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7]);
                break;
                
           /*  default: */
                //no params
                
        }
        
        // execute query
        $stmt->execute();

        
        // bind the results
        $stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);
        
        
        
        
        // return objects
        return $stmt;
    }

    // update the product
    function update()
    {

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

        echo "0";
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->shipping_address_street = htmlspecialchars(strip_tags($this->shipping_address_street));
        $this->shipping_address_city = htmlspecialchars(strip_tags($this->shipping_address_city));
        $this->shipping_address_state = htmlspecialchars(strip_tags($this->shipping_address_state));
        $this->shipping_address_postalcode = htmlspecialchars(strip_tags($this->shipping_address_postalcode));
        $this->shipping_address_country = htmlspecialchars(strip_tags($this->shipping_address_country));
        $this->billing_address_street = htmlspecialchars(strip_tags($this->billing_address_street));
        $this->billing_address_city = htmlspecialchars(strip_tags($this->billing_address_city));
        $this->billing_address_state = htmlspecialchars(strip_tags($this->billing_address_state));
        $this->billing_address_postalcode = htmlspecialchars(strip_tags($this->billing_address_postalcode));
        $this->billing_address_country = htmlspecialchars(strip_tags($this->billing_address_country));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->industry = htmlspecialchars(strip_tags($this->industry));
        $this->assigned_to = htmlspecialchars(strip_tags($this->assigned_to));
        $this->date_created = htmlspecialchars(strip_tags($this->date_created));
        $this->date_modified = htmlspecialchars(strip_tags($this->date_modified));
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->company_id = htmlspecialchars(strip_tags($this->company_id));

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
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>