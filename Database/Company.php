<?php

/*
 * FileName: Company.php
 * Author: Jason Waid
 * Version: 0.6
 * Date Modified: 10/12/2020
 * Purpose:
 * Object oriented representation of a company
 * all database manipulation happens here
 *
 *
 */
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

    public $company_email;

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

    /*
     * Function: read
     * Purpose:
     * grabs all companies from the connected db
     * returns the objects
     */
    public function read()
    {
        $query = "SELECT * FROM company";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);

        return $stmt;
    }

    /*
     * Function: create
     * Purpose:
     * creates a company with the supplied parameters
     * returns bool on failure or success
     */
    function create($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by)
    {

        // query to insert record
        $query = "INSERT INTO
                nylene.company (company_name, website, shipping_address_street,shipping_address_city,shipping_address_state,shipping_address_postalcode,
				shipping_address_country,billing_address_street,billing_address_city,billing_address_state, billing_address_postalcode,
				billing_address_country,description,type,industry, company_email, assigned_to, date_created, created_by)
            VALUES(
              ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);

        $company_name = htmlspecialchars(strip_tags($company_name));
        $website = htmlspecialchars(strip_tags($website));
        $billing_address_street = htmlspecialchars(strip_tags($billing_address_street));
        $billing_address_city = htmlspecialchars(strip_tags($billing_address_city));
        $billing_address_state = htmlspecialchars(strip_tags($billing_address_state));
        $billing_address_postalcode = htmlspecialchars(strip_tags($billing_address_postalcode));
        $billing_address_country = htmlspecialchars(strip_tags($billing_address_country));
        $shipping_address_street = htmlspecialchars(strip_tags($shipping_address_street));
        $shipping_address_city = htmlspecialchars(strip_tags($shipping_address_city));
        $shipping_address_state = htmlspecialchars(strip_tags($shipping_address_state));
        $shipping_address_postalcode = htmlspecialchars(strip_tags($shipping_address_postalcode));
        $shipping_address_country = htmlspecialchars(strip_tags($shipping_address_country));
        $description = htmlspecialchars(strip_tags($description));
        $type = htmlspecialchars(strip_tags($type));
        $industry = htmlspecialchars(strip_tags($industry));
        $company_email = htmlspecialchars(strip_tags($company_email));
        $assigned_to = htmlspecialchars(strip_tags($assigned_to));
        $date_created = htmlspecialchars(strip_tags($date_created));
        $created_by = htmlspecialchars(strip_tags($created_by));

        $stmt->bind_param("ssssssssssssssssisi", $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by);

        if (! $stmt->execute()) {
            return false;
        }
        return true;
    }

    /*
     * Function Name: searchId
     * Purpose: A simpler version of search that only searches using the company_id
     */
    function searchId($company_id)
    {
        $query = "SELECT
                *
            FROM
			  nylene.company WHERE company_id = ?";

        $stmt = $this->conn->prepare($query);

        $company_id = htmlspecialchars(strip_tags($company_id));

        $stmt->bind_param("i", $company_id);

        // execute query
        if (! $stmt->execute()) {
            return false;
        }

        // bind the results
        $stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);

        $stmt->fetch();

        // return objects
        return $this;
    }

    /*
     * Function Name: searchInclude
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     */
    function searchInclude($name, $website, $address, $city, $state, $country, $assigned_To, $created_By)
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

            /* default: */
            // no params
        }

        // execute query
        if (! $stmt->execute()) {
            return false;
        }

        // bind the results
        $stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);

        // return objects
        return $stmt;
    }

    /*
     * Function Name: searchExact
     * Purpose: Function searches the database for an exact match and returns the count of exact matches
     */
    function searchExact($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email)
    {
        $query = "SELECT
                1
                FROM
			nylene.company WHERE 
            company_name = ? AND
            website = ? AND
            billing_address_street = ? AND
            billing_address_city = ? AND
            billing_address_postalcode = ? AND
            billing_address_state = ? AND
            billing_address_country = ? AND
            shipping_address_street = ? AND
            shipping_address_city = ? AND
            shipping_address_state = ? AND
            shipping_address_postalcode = ? AND
            shipping_address_country = ? AND
            description = ? AND
            type = ? AND
            industry = ? AND
            company_email = ?
            LIMIT 1";
        
        
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $company_name = htmlspecialchars(strip_tags($company_name));
        $website = htmlspecialchars(strip_tags($website));
        $billing_address_street = htmlspecialchars(strip_tags($billing_address_street));
        $billing_address_city = htmlspecialchars(strip_tags($billing_address_city));
        $billing_address_state = htmlspecialchars(strip_tags($billing_address_state));
        $billing_address_postalcode = htmlspecialchars(strip_tags($billing_address_postalcode));
        $billing_address_country = htmlspecialchars(strip_tags($billing_address_country));
        $shipping_address_street = htmlspecialchars(strip_tags($shipping_address_street));
        $shipping_address_city = htmlspecialchars(strip_tags($shipping_address_city));
        $shipping_address_state = htmlspecialchars(strip_tags($shipping_address_state));
        $shipping_address_postalcode = htmlspecialchars(strip_tags($shipping_address_postalcode));
        $shipping_address_country = htmlspecialchars(strip_tags($shipping_address_country));
        $description = htmlspecialchars(strip_tags($description));
        $type = htmlspecialchars(strip_tags($type));
        $industry = htmlspecialchars(strip_tags($industry));
        $company_email = htmlspecialchars(strip_tags($company_email));

        // bind the parameters to the query
        $stmt->bind_param("ssssssssssssssss", $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email);
        
        // execute query
        $stmt->execute();

        // bind the results
        //$stmt->bind_result($this->company_id, $this->company_name, $this->website, $this->billing_address_street, $this->billing_address_city, $this->billing_address_state, $this->billing_address_postalcode, $this->billing_address_country, $this->shipping_address_street, $this->shipping_address_city, $this->shipping_address_state, $this->shipping_address_postalcode, $this->shipping_address_country, $this->description, $this->type, $this->industry, $this->company_email, $this->assigned_to, $this->date_created, $this->date_modified, $this->created_by);

        $count = $stmt->fetch();
        $stmt->close();
        
        // return count
        return $count;
    }

    // update the product
    function update($company_id, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $date_modified)
    {

        // update query
        $query = "UPDATE
                nylene.company
            SET
               
            company_name = ?, 
            website = ?, 
            billing_address_street = ?, 
            billing_address_city = ?,
            billing_address_postalcode = ?,
            billing_address_state = ?,
            billing_address_country = ?,
            shipping_address_street = ?,
            shipping_address_city = ?,
            shipping_address_state = ?,
            shipping_address_postalcode = ?,
            shipping_address_country = ?,
            description = ?,
            type = ?,
            industry = ?,
            company_email = ?,
            date_modified = ?
	        WHERE
	        company_id = ?";

        $stmt = $this->conn->prepare($query);

        $company_id = htmlspecialchars(strip_tags($company_id));
        $company_name = htmlspecialchars(strip_tags($company_name));
        $website = htmlspecialchars(strip_tags($website));
        $billing_address_street = htmlspecialchars(strip_tags($billing_address_street));
        $billing_address_city = htmlspecialchars(strip_tags($billing_address_city));
        $billing_address_state = htmlspecialchars(strip_tags($billing_address_state));
        $billing_address_postalcode = htmlspecialchars(strip_tags($billing_address_postalcode));
        $billing_address_country = htmlspecialchars(strip_tags($billing_address_country));
        $shipping_address_street = htmlspecialchars(strip_tags($shipping_address_street));
        $shipping_address_city = htmlspecialchars(strip_tags($shipping_address_city));
        $shipping_address_state = htmlspecialchars(strip_tags($shipping_address_state));
        $shipping_address_postalcode = htmlspecialchars(strip_tags($shipping_address_postalcode));
        $shipping_address_country = htmlspecialchars(strip_tags($shipping_address_country));
        $description = htmlspecialchars(strip_tags($description));
        $type = htmlspecialchars(strip_tags($type));
        $industry = htmlspecialchars(strip_tags($industry));
        $company_email = htmlspecialchars(strip_tags($company_email));
        $date_modified = htmlspecialchars(strip_tags($date_modified));

        $stmt->bind_param("sssssssssssssssssi", $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $date_modified, $company_id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /*
     * Function Name: getname
     * Purpose: Function returns the company_name property of the object
     *
     */
    function getName()
    {
        return $this->company_name;
    }

    /*
     * Function Name: getAssignedTo
     * Purpose: Function returns the assigned_to property of the object
     *
     */
    function getAssignedTo()
    {
        return $this->assigned_to;
    }

    /*
     * Function Name: getCreatedBy
     * Purpose: Function returns the created_by property of the object
     *
     */
    function getCreatedBy()
    {
        return $this->created_by;
    }

    /*
     * Function Name: getCompanyId
     * Purpose: Function returns the company_id property of the object
     *
     */
    function getCompanyId()
    {
        return $this->company_id;
    }

    /*
     * Function Name: get
     * Purpose: Function returns the object
     *
     */
    function get()
    {
        return $this;
    }

    /*
     * Function Name: getDescription
     * Purpose: Function returns the description
     *
     */
    function getDescription()
    {
        return $this->description;
    }

    /*
     * Function Name: getWebsite
     * Purpose: Function returns the website
     *
     */
    function getWebsite()
    {
        return $this->website;
    }

    /*
     * Function Name: getIndustry
     * Purpose: Function returns the industry
     *
     */
    function getIndustry()
    {
        return $this->industry;
    }

    /*
     * Function Name: getEmail
     * Purpose: Function returns the company email
     *
     */
    function getEmail()
    {
        return $this->company_email;
    }

    /*
     * Function Name: getType
     * Purpose: Function returns the type
     *
     */
    function getType()
    {
        return $this->type;
    }

    /*
     * Function Name: getBillingAddress
     * Purpose: Function returns the billing address
     *
     */
    function getBillingAddress()
    {
        return $this->billing_address_street . ', ' . $this->billing_address_city . ', ' . $this->billing_address_state . ', ' . $this->billing_address_country . ', ' . $this->billing_address_country;
    }

    /*
     * Function Name: getBillingAddressStreet
     * Purpose: Function returns the billing address street
     *
     */
    function getBillingAddressStreet()
    {
        return $this->billing_address_street;
    }

    /*
     * Function Name: getBillingAddressCity
     * Purpose: Function returns the billing address city
     *
     */
    function getBillingAddressCity()
    {
        return $this->billing_address_city;
    }

    /*
     * Function Name: getBillingAddressState
     * Purpose: Function returns the billing address state
     *
     */
    function getBillingAddressState()
    {
        return $this->billing_address_state;
    }

    /*
     * Function Name: getBillingAddressPostalCode
     * Purpose: Function returns the billing address postal code
     *
     */
    function getBillingAddressPostalCode()
    {
        return $this->billing_address_postalcode;
    }

    /*
     * Function Name: getBillingAddressCounty
     * Purpose: Function returns the billing address country
     *
     */
    function getBillingAddressCountry()
    {
        return $this->billing_address_country;
    }

    /*
     * Function Name: getShippingAddressStreet
     * Purpose: Function returns the shipping address street
     *
     */
    function getShippingAddressStreet()
    {
        return $this->shipping_address_street;
    }

    /*
     * Function Name: getShippingAddressCity
     * Purpose: Function returns the shipping address city
     *
     */
    function getShippingAddressCity()
    {
        return $this->shipping_address_city;
    }

    /*
     * Function Name: getShippingAddressState
     * Purpose: Function returns the shipping address state
     *
     */
    function getShippingAddressState()
    {
        return $this->shipping_address_state;
    }

    /*
     * Function Name: getShippingAddressPostalCode
     * Purpose: Function returns the Shipping address postal code
     *
     */
    function getShippingAddressPostalCode()
    {
        return $this->shipping_address_postalcode;
    }

    /*
     * Function Name: getShippingAddressCounty
     * Purpose: Function returns the Shipping address country
     *
     */
    function getShippingAddressCountry()
    {
        return $this->shipping_address_country;
    }

    public function _toString()
    {
        return "company id is: {$this->company_id}";
    }
}
?>