<?php
/*
 * FileName: updateInteractionDB.php
 * Version Number: 1.1
 * Author: Kaitlyn Breker
 * Date Modified: Nov 22, 2020
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
    if (isset($_SESSION['company_id'])) {
        if (isset($_POST['submit'])) {
           
            /*Variables that can be edited*/
            $interaction_id = $_POST['interaction_id'];
            $comments = $_POST['comments'];
            $status = $_POST['status'];
            $follow_up_type = $_POST['follow_up_type'];
            $follow_up_date = $_POST['follow_up_date'];
            
            $newInteraction = new Interaction($conn_Interaction);
            
            /*if the old form type changed from manual, none or intercation to  follow_up_type == form*/
            //find form date and update db
            
            /*Modify interaction*/
            $editInteraction = $newInteraction->modify($interaction_id, $comments, $status, $follow_up_type, $follow_up_date);
            
            if ($editInteraction == false) {
                echo "Modifying interaction failed";
            }
            
            echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Interactions/companyHistory.php\" />";
            exit();
        
        } else {
            echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Interactions/companyHistory.php\" />";
            exit();
        }
    } else {

        echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/Homepage.php\" />";
        exit();
    }
}
?>
