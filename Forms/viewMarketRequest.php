
<?php 
/*
 * Name: viewMMForm.php
 * Author: Karandeep Singh
 * Purpose: View Marketing Materials Requet form. Displays all the information filled in the form.
 */
session_start();
	
     include '../NavPanel/navigation.php';
	include '../Database/connect.php';
        
    $conn = getDBConnection();

	//Check the connection
	if ($conn-> connect_error) {
	
		die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
		
		$sql = "SELECT * FROM marketing_request_form 
								WHERE marketing_request_id =". $_POST['id'];
		$query = $conn->query($sql);								
		$row = mysqli_fetch_array($query);
		
		
		$marketingInformation	=  "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN marketing_request_form ON marketing_request_form.marketing_request_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 5 AND interaction_relational_form.form_id =". $_POST['id'];
		$marketingResult = $conn->query($marketingInformation); 
		$marketingRow = mysqli_fetch_array($marketingResult); 
		
		$conn->close();
	}
?>

<html>
<head> 
  <link rel="stylesheet" type="text/css" href = "../CSS/form.css">
    <title> View Marketing Materials Request Form</title>
</head>
<form  method="post" action="MMform_Database.php"   name="MMForm";>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table"> 
                
	<tr>

        <td id="Requester_name">Requester Name</td>
			<td colspan="2"><input type="text" name="Requester_name" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['requester_name'];?>"></td>

	<td id="Market_Segment">Market Segment</td>
			<td colspan="2"><input type="text" name="Market_Segment" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['market_segment'];?>"></td>
</tr> 
                <tr>
	<td id="Sales_Territory">Sales Territory</td>
			<td colspan="2"><input type="text" name="Sales_Territory" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['sales_territory'];?>"></td>
                    
        	<td id="Email">Email</td>
			<td colspan="2"><input type="text" name="Email" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['email'];?>"></td>
        </tr>

                <tr>
	
        	<td id="Phone">Phone</td>
			<td colspan="2"><input type="text" name="Phone" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['phone'];?>"></td>

        	<td id="Date">Date</td>
			<td colspan="2"><input type="text" name="Date" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['request_date'];?>"></td> </tr>
    </table>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table">
<tr>
	
    <td id="column_heading" colspan="2" border="0" style="text-align: left;"><b>Project Background</b></td>
			</tr></table>
    <table border="1" cellpadding="5" cellspacing="0" class="form-table">
<tr> <td colspan ="2" id="Name_of_Project">Name of Project</td>
			<td colspan="2"><input type="text" name="Name_of_Project" maxlength="250" style="width: 500px" readonly
				value="<?php echo $row['name_project_or_piece'];?>"></td>
 </tr>
       


   <td> <table>    
    <td id="type_of_project">Type of Project or Piece</b><br>if known<br>If multiple communication are needed,choose all that apply.</td>
			<td ><input type="text" name="type_of_project" maxlength="250" style="width: 260" readonly
				value="<?php echo $row['type_of_project'];?>"></td>
    </table></td>
   
    <tr> <td id="project_content">Project Content</td>
			<td colspan="2"><input type="text" name="project_content" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['is_project_new'];?>"></td>
 </tr>
    
    <tr> <td id="target">Target Audience</td>
			<td colspan="2"><input type="text" name="target" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['target_audiance'];?>"></td>
 </tr>
         <tr> <td id="Info">
        <b>Audience Persona Information</b><br/><ul>
        <li>Personal Demographics</li>
        <li>Level of Seniority</li>
        <li>Pain points/Challenges</li>
        <li>Goals and Values</li>
        <li>Questions they ask</li>
        <li>Where they get information</li>
        <li>Expected buying Experience</li>
        <li>Common Objections</li>
        </ul>
             </td>
             <td colspan="2"><input type="text" name="Info" rows="11" width="1000px" cols="70" readonly value="<?php echo $row['audiance_personal_info']?>"></td>

        <br/>
        <br/>
        <br/>
        <br/>
    <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="purpose">Purpose</tr>
			<tr><td colspan="2"><input type="text" name="purpose" rows="6" cols="120" readonly
        value="<?php echo $row['purpose'];?>"></td>
        </tr> </table>

        
       <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="key_messages">Key Messages</tr>
			<tr><td colspan="2"><input type ="text" name="key_messages" rows="6" cols="120" readonly
        value="<?php echo $row['key_message'];?>"></td>
        </tr> </table>

          <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="support">Supporting Information</tr>
			<tr><td colspan="2"><input type ="text" name="support" rows="6" cols="120" readonly
        value="<?php echo $row['supporting_info'];?>"></td>
        </tr> </table>
<!--
     <table cellpadding="5" cellspacing="1" class="form-table">
       <tr id="column_heading" colspan="2" border="0" style="text-align: left;">
        <b>Photography Needed?</b> 
    <input type="checkbox"  name="photography[]" value="yes">
    <i><label for="photography">yes</label></i>
    
    <input type="checkbox" name="photography[]" value="no">
-->
            <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="is_photography_needed">Photography Needed?
			<td colspan="2"><input type="text" name="is_photography_needed" maxlength="250" style="width: 260px" readonly
        value="<?php echo $row['is_photography_needed'];?>"></td>
        </tr> 
             
     
<tr id="needed_photography">
			<tr><td colspan="2"><input type="text" name="needed_phtography" rows="6" cols="120" readonly
        value="<?php echo $row['needed_photography'];?>"></td>
        </tr> </table>
        
        <table border="1" style="text-align: left;" class="form-table"><tr><td ><b>Estimated Quantity:</b></td>      
            <td>   <input type="text" name="estimate" maxlength="300" style="width:260px" readonly value="<?php echo $row['estimated_quantity'];?>"></td>
 <td><i>If applicable.</i></td> </tr>
        
        <tr><td ><b>Means of Delivery:</b></td> <td >
            <input type="text" name="means_of_delivery" maxlength= "300" style="width:260px" readonly value="<?php echo $row['means_of_delivery'];?>"></td>
 <td>Anticipated plan for delivering the piece, tradiotional mailing, blogging,<br/> e-mailing, handing out of events, etc.</td></tr>
            
           <tr><td ><b>Date Needed:</b></td> <td >
                     <input type="date" name="date_needed" maxlength= "300" style="width:260px" readonly value="<?php echo $row['date_needed'];?>"></td> <td>A minimum of 4-8 weeks may be required for many printed materials requests.<br/> The scope of some requests, especially new projects or items to be mailed, may require more time.</td></tr>  
            
              <tr><td ><b>Available Budget:</b></td>  <td>
                  <input type="text" name="budget" maxlength= "300" style="width:260px" readonly value="<?php echo $row['available_budget'];?>"></td>
 <td>To cover printing, photography or other vendor charges.</td></tr> 
            
            
              <tr><td ><b>Cost Counter #:</b></td> <td >
                  <input type="text" name="cost" maxlength= "300" style="width:260px" readonly value="<?php echo $row['cost_center_number'];?>"></td>
<td>If applicable</td></tr> 
        </table>
       


</form>
</html>

