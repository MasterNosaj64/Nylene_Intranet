<?php
 
//Logic for Searching companies by keyword
function search($keywords){
    
    
    // select all query
    $query = "SELECT
                *
            FROM
			  nylene.company
            WHERE
            company_name LIKE ?
			OR website LIKE ?
			OR billing_address_street LIKE ?
			OR billing_address_city LIKE ?
			OR billing_address_state LIKE ?
			OR billing_address_postalcode LIKE ?
			OR billing_address_country LIKE ?
			OR assigned_to LIKE ?
			OR created_by LIKE ?";
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    
    // sanitize
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
    
    
    
    // execute query
    $stmt->execute();
    
    return $stmt;
}

