<?php

/*
 * FileName: Customer.php
 * Author: Jason Waid
 * Version: 0.8
 * Date Modified: 11/01/2020
 * Purpose:
 * Object oriented representation of a customer
 * all database manipulation happens here
 *
 *
 */
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

    /*
     * Function: read
     * Purpose:
     * grabs all customers from the connected db
     * returns the objects
     */
    public function read()
    {
        $query = "SELECT * FROM customer";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);

        return $stmt;
    }

    /*
     * Function: create
     * Purpose:
     * creates a customer with the supplied parameters
     * returns bool on failure or success
     */
    function create($customer_name, $customer_email, $date_created, $customer_phone, $customer_fax)
    {
        $query = "INSERT INTO
                nylene.customer (customer_name, customer_email, date_created, customer_phone, customer_fax)
            VALUES(
              ?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);

        $customer_name = htmlspecialchars(strip_tags($customer_name));
        $customer_email = htmlspecialchars(strip_tags($customer_email));
        $date_created = htmlspecialchars(strip_tags($date_created));
        $customer_phone = htmlspecialchars(strip_tags($customer_phone));
        $customer_fax = htmlspecialchars(strip_tags($customer_fax));

        $stmt->bind_param("sssss", $customer_name, $customer_email, $date_created, $customer_phone, $customer_fax);

        if (! $stmt->execute()) {
            return false;
        }
        return true;
    }

    /*
     * Function Name: searchById
     * Purpose: Function finds a customer by customer_id and returns found objects
     *
     */
    function searchById($customer_id)
    {
        $query = "SELECT
                *
            FROM
			  nylene.customer WHERE customer_id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $customer_id = htmlspecialchars(strip_tags($customer_id));
        
        $stmt->bind_param("i", $customer_id);

        // execute query
        $stmt->execute();

        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);

        $stmt->fetch();
        
        // return objects
        return $this;
    }

    /*
     * Function Name: searchExact
     * Purpose: Function finds a customer by using exact parameters and returns found objects
     *
     */
    // TODO: add date_modified to code and DB
    function searchExact($customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax)
    {
        $query = "SELECT
                *
            FROM
			  nylene.customer WHERE 
   
        customer_id = ? AND
        customer_name = ? AND
        customer_email = ? AND
        customer_phone = ? AND
        customer_fax = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $customer_id = htmlspecialchars(strip_tags($customer_id));
        $customer_name = htmlspecialchars(strip_tags($customer_name));
        $customer_email = htmlspecialchars(strip_tags($customer_email));
        $customer_phone = htmlspecialchars(strip_tags($customer_phone));
        $customer_fax = htmlspecialchars(strip_tags($customer_fax));
        
        //bind parameters
        $stmt->bind_param("issss",$customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax);
        
        // execute query
        $stmt->execute();

        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);

        // return objects
        return $stmt;
    }

    /*
     * Function Name: search
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

            /* default: */
            // no params
        }

        // execute query
        $stmt->execute();

        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);

        // return objects
        return $stmt;
    }

    /*
     * Function Name: update
     * Purpose: Function updates the object
     *
     */
    //TODO: fix, execute() doesnt fail but it doesnt work. Doing it directly on the db works tho
    function update($customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax)
    {
        $query = "UPDATE nylene.customer
            SET
            customer_name = ?,
            customer_email = ?,
            customer_phone = ?,
            customer_fax = ?
            WHERE customer_id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // santize
        $customer_id = htmlspecialchars(strip_tags($customer_id));
        $customer_name = htmlspecialchars(strip_tags($customer_name));
        $customer_email = htmlspecialchars(strip_tags($customer_email));
        $customer_phone = htmlspecialchars(strip_tags($customer_phone));
        $customer_fax = htmlspecialchars(strip_tags($customer_fax));

        
        $stmt->bind_param("issss", $customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax);

        

        // execute query
        if (! $stmt->execute()) {
            return false;
        }

        // bind the results
        $stmt->bind_result($this->customer_id, $this->customer_name, $this->customer_email, $this->date_created, $this->customer_phone, $this->customer_fax);

        // return objects
        return $stmt;
    }

    /*
     * Function Name: getname
     * Purpose: Function returns the company_name of the object
     *
     */
    function getName()
    {
        return $this->customer_name;
    }

    /*
     * Function Name: getPhone
     * Purpose: Function returns the work_phone of the object
     *
     */
    function getPhone()
    {
        return $this->customer_phone;
    }

    /*
     * Function Name: getEmail
     * Purpose: Function returns the work_email of the object
     *
     */
    function getEmail()
    {
        return $this->customer_email;
    }
    
    /*
     * Function Name: getFax
     * Purpose: Function returns the fax number of the object
     *
     */
    function getFax()
    {
        return $this->customer_fax;
    }

    /*
     * Function Name: getCustomerId
     * Purpose: Function returns the customer_id of the object
     *
     */
    function getCustomerId()
    {
        return $this->customer_id;
    }
    
    /*
     * Function Name: getDateCreated
     * Purpose: Function returns date created of the object
     *
     */
    function getDateCreated(){
        return $this->date_created;
    }
    

    /*
     * Function Name: get
     * Purpose: Function returns the customer object
     *
     */
    function get()
    {
        return $this;
    }
}
?>