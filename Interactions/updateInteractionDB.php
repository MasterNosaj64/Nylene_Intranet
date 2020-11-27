<?php
    /*
     * FileName: updateInteractionDB.php
     * Author: Kaitlyn Breker
     * Date Modified: Nov 27th, 2020
     * Purpose: Update database with new interaction information.
     */
    date_default_timezone_set('America/Toronto');
    session_start();
    
    $_SESSION["navToAddInteractionPage"] = true;
    
    include '../NavPanel/navigation.php';
    include '../Database/connect.php';
    include '../Database/Customer.php';
    include '../Database/Company.php';
    include '../Database/Interaction.php';
    
    $conn_Customer = getDBConnection();
    $conn_Company = getDBConnection();
    $conn_Interaction = getDBConnection();
    $conn_Form = getDBConnection();
    
    /*Indicate a connect failure if customer, company fail*/
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
                
                /*If the follow_up_type is indicated as form, update date from related form*/
                if ($follow_up_type == 'form'){
                    
                    /*Query form id from the interaction-form relational table*/
                    $selectFormInteractionQuery = "SELECT * FROM interaction_relational_form WHERE interaction_id = " . $interaction_id;
                    $FormInteractionResult = $conn_Form->query($selectFormInteractionQuery);
                    $FormInteraction = mysqli_fetch_array($FormInteractionResult);
                   
                    if ($FormInteraction != null){
                        
                        /*Assign form id*/
                        $formID = $FormInteraction['form_id'];
                        
                        /*Select the date from the form (sample_req_date, quote_date, request_date, credit_date*/
                        if ($FormInteraction['form_type'] == 1) {
                            /*Sample Form*/
                            $selectDateFormQuery = "SELECT * FROM sample_form
                                                        WHERE sample_form_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['sample_req_date'];
                            }
                            
                        } else if ($FormInteraction['form_type'] == 2) {
                            /*Light Truck Load*/
                            $selectDateFormQuery = "SELECT * FROM ltl_quote
                                                        WHERE ltl_quote_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['quote_date'];
                            }
                            
                        } else if ($FormInteraction['form_type'] == 3) {
                            /*Truckload*/
                            $selectDateFormQuery = "SELECT * FROM tl_quote
                                                        WHERE tl_quote_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['quote_date'];
                            }
                            
                        } else if ($FormInteraction['form_type'] == 4) {
                            /*Distributor*/
                            $selectDateFormQuery = "SELECT * FROM distributor_quote_form
                                                        WHERE distributor_quote_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['quote_date'];
                            } 
                        
                        } else if ($FormInteraction['form_type'] == 5) {
                            /*Marketing Request*/
                            $selectDateFormQuery = "SELECT * FROM marketing_request_form
                                                        WHERE marketing_request_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['date_needed'];
                            }
                            
                        } else if ($FormInteraction['form_type'] == 6) {
                            /*Business Credit Application*/
                            $selectDateFormQuery = "SELECT * FROM credit_application_business_form
                                                        WHERE credit_application_business_id = ". $formID;
                            $selectDateFormResult = $conn_Form->query($selectDateFormQuery);
                            $selectDate = mysqli_fetch_array($selectDateFormResult);
                            
                            if ($selectDate != null){
                                $formDate = $selectDate['credit_date'];
                            }
                        }
                    }
                    
                    /*Assign follow up date from form*/
                    $fDate = strtotime($formDate);
                    $followDate = date("Y/m/d", $fDate);
                    $followUpDate = date_create($followDate);
                    date_modify($followUpDate, "+30 days");
                    $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
                    $follow_up_date = $followUpDateFormatted;
                }
                
                /*Create a new interaction object*/
                $newInteraction = new Interaction($conn_Interaction);
                
                /*Modify interaction with new parameters*/
                $editInteraction = $newInteraction->modify($interaction_id, $comments, $status, $follow_up_type, $follow_up_date);
                
                if ($editInteraction == false) {
                    echo "Modifying interaction failed";
                }
                
                /*Close connections*/
                $conn_Form->close();
                $conn_Interaction->close();
                $conn_Company->close();
                $conn_Customer->close();
    
                
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
