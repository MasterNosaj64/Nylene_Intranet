<?php
/*
 * FileName: updateInteractionDB.php
 * Version Number: 1.0
 * Author: Kaitlyn Breker
 * Date Modified: Nov 21, 2020
 * Purpose: Update database with new interaction information.
 */
date_default_timezone_set('America/Toronto');
session_start();

// the following variables are used in navigation.php
// View navigation.php for more information
$_SESSION["navToAddInteractionPage"] = true;

include '../NavPanel/navigation.php';
include '../Database/connect.php';
include '../Database/Customer.php';
include '../Database/Company.php';
include '../Database/Interaction.php';

$conn_Customer = getDBConnection();
$conn_Company = getDBConnection();
$conn_Interaction = getDBConnection();

// Handler for if the database connection fails
if ($conn_Customer->connect_error || $conn_Company->connect_error) {
    
    die("Connection failed: " . $conn_Customer->connect_error . " || " . $conn_Company->connect_error);
    
} else {
    
}
?>
