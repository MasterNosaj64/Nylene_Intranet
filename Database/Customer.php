<?php

class Customer
{

    // database connection and table name
    private $conn;

    private $table_name = "customer";

    // object properties
    public $customer_id;

    public $customer_name;

    public $customer_email;

    public $date_created;

    public $customer_phone;

    public $customer_fax;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM customer";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);
        
        return $stmt;
    }

    function create()
    {

    }

    // delete
    function delete()
    {

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
        return $this->customer_name;
    }
    
    function getPhone(){
        return $this->customer_phone;
    }
    
    function getEmail(){
        return $this->customer_email;
    }
    
    function getCustomerId(){
        return $this->customer_id;
    }
    
    function get(){
        return $this;
    }
    
    /*
     * Function Name: search
     * Version: 0.6
     * Date Modified: 10/11/2020
     * Author: Jason Waid
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     *
     */
    function search($customer_id, $customer_name, $customer_email, $date_created, $customer_phone, $customer_fax)
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
			  nylene.customer";

        if ($customer_id != "") {
            $query .= " WHERE company_id LIKE ? ";
            $intCount ++;
            $paramTypes .= "i";
            $customer_id = htmlspecialchars(strip_tags($customer_id));
            array_push($params, $customer_id);
        }

        if ($customer_name != "") {
            if ($customer_id == "") {
                $query .= " WHERE customer_name LIKE ?";
            } else {
                $query .= " AND customer_name LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $customer_name = htmlspecialchars(strip_tags($customer_name));
            $customer_name .= "%";
            array_push($params, $customer_name);
        }

        if ($customer_email != "") {
            if ($customer_id == "" && $customer_name == "") {
                $query .= " WHERE customer_email LIKE ?";
            } else {
                $query .= " AND customer_email LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $customer_email = htmlspecialchars(strip_tags($customer_email));
            $customer_email .= "%";
            array_push($params, $customer_email);
        }

        if ($date_created != "") {
            if ($customer_id == "" && $customer_name == "" && $customer_email == "") {
                $query .= " WHERE date_created LIKE ?";
            } else {
                $query .= " AND date_created LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $date_created = htmlspecialchars(strip_tags($date_created));
            array_push($params, $date_created);
        }

        if ($customer_phone != "") {
            if ($customer_id == "" && $customer_name == "" && $customer_email == "" && $date_created == "") {
                $query .= " WHERE customer_phone LIKE ?";
            } else {
                $query .= " AND customer_phone LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $customer_phone = htmlspecialchars(strip_tags($customer_phone));
            $customer_phone .= "%";
            array_push($params, $customer_phone);
        }

        if ($customer_fax != "") {
            if ($customer_id == "" && $customer_name == "" && $customer_email == "" && $date_created == "" && $customer_phone == "") {
                $query .= " WHERE customer_fax LIKE ?";
            } else {
                $query .= " AND customer_fax LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $customer_fax = htmlspecialchars(strip_tags($customer_fax));
            $customer_fax .= "%";
            array_push($params, $customer_fax);
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
                
           /*  default: */
                //no params
                
        }
        
        // execute query
        $stmt->execute();

        
        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);
        
        
        
        
        // return objects
        return $stmt;
    }

    // update the product
    function update()
    {

    }
}
?>