
<?php 
session_start();
	

    include '../navigation.php';
	include '../Database/connect.php';

	
	
	$conn = getDBConnection();
	
	//Check the connection
	if ($conn-> connect_error) {
	
		die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
		
		$sql = "SELECT * FROM marketing_request_form 
								WHERE marketing_request_id = ". $_SESSION['id'];
		$query = $conn->query($sql);								
		$row = mysqli_fetch_array($query);
		
		
		$marketingInformation	=  "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN marketing_request_form ON marketing_request_form.marketing_request_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 4 AND interaction_relational_form.form_id = ". $_SESSION['id'];
		$marketingResult = $dbConnection->query($marketingInformation); 
		$row = mysqli_fetch_array($marketingResult); 
		
		$conn->close();
	}
?>
<?php
session_start();
 include '../navigation.php';
?>

<!DOCTYPE html>
<html>
<head> 
  <link rel="stylesheet" type="text/css" href = "../CSS/form.css">
    <title>Marketing Materials Request Form</title>
</head>
<form  method="post" action="MMform_Database.php"   name="MMForm";>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table">
                
	<tr>
	<td style="width: 50%">
	<label for="Requester_Name">
	<b>Requester Name</b></label>
	<input name="Requester_Name" type="text" maxlength="250" style="width: 260px" />
	</td>

	<td style="width: 50%">
	<label for="Market_Segment">
	<b>Market Segment</b></label>
	<input name="Market_Segment" type="text" maxlength="250" style="width: 260px" />
	</td>
</tr> 
                <tr>
	<td style="width: 50%">
	<label for="Sales_Territory">
	<b>Sales Territory</b></label>
	<input name="Sales_Territory" type="text" maxlength="250" style="width: 260px" />
	</td>
        	<td style="width: 50%">
	<label for="Email">
	<b>Email</b></label>
	<input name="Email" type="text" maxlength="250" style="width: 260px" />
	</td>
        </tr>

                <tr>
	
        	<td style="width: 50%">
	<label for="Phone">
	<b>Phone</b></label>
	<input name="Phone" type="text" maxlength="250" style="width: 260px" />
	</td>

        	<td style="width: 50%">
	<label for="Date">
	<b>Today's Date</b></label>
	<input name="Date" type="text" maxlength="250" style="width: 260px" />
	</td> </tr>
    </table>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table">
<tr>
	
    <td id="column_heading" colspan="2" border="0" style="text-align: left;"><b>Project Background</b></td>
			</tr></table>
    <table border="1" cellpadding="5" cellspacing="0" class="form-table">
<tr> <td colspan = "2">
<label for="Name_of_Project"><b>Name of Project or Piece </b></label>
<input name="Name_of_Project" type="text" maxlength="500" style="width: 535px" />
</td>  
 </tr>
<tr> <td border="1">
   <label for="type_of_project"></label> <b>Type of Project or Piece</b><br>if known<br>If multiple communication are needed,choose all that apply.
    <input name="type_of_project">
           </td>
    <td><table><tr><td border="1">
<input type="checkbox"  name="type_of_project[]" value="brochure">
  <label for="brochure">Brochure</label>
        </td><td>
    <input type="checkbox"  name="type_of_project[]" value="ppt">
  <label for="ppt">PowerPoint Presentation</label>
        </td></tr><tr><td>
    <input type="checkbox"  name="type_of_project[]" value="Fact_Sheet">
  <label for="Fact_Sheet">Fact Sheet</label>
    </td><td>
    <input type="checkbox"  name="type_of_project[]" value="video">
  <label for="video">Video</label>
    </td></tr><tr><td>
    <input type="checkbox"  name="type_of_project[]" value="mail">
  <label for="mail">Direct Mail</label>
    </td><td>
    <input type="checkbox"  name="type_of_project[]" value="web">
  <label for="web">Web(specify)</label>
    
    <input type="checkbox"  name="type_of_project[]" value="Page">
    <i><label for="Page">Page</label></i>
    
    <input type="checkbox"  name="type_of_project[]" value="Section">
    <i><label for="Section">Section</label></i>
    
    <input type="checkbox"  name="type_of_project[]" value="Blog">
    <i><label for="Blog">Blog</label></i>
    
    <input type="checkbox"  name="type_of_project[]" value="Landing_Page">
    <i><label for="Landing_Page">Landing Page</label></i>
    
    <input type="checkbox"  name="type_of_project[]" value="Update">
    <i><label for="Update">Update</label></i>
    
    <input type="checkbox"  name="type_of_project[]" value="graphic">
    <i><label for="graphic">Graphic</label></i>
    </td></tr><tr><td>
    <input type="checkbox"  name="type_of_project[]" value="Tradeshow">
    <label for="Tradeshow">Tradeshow</label>
    </td><td>
    <input type="checkbox"  name="type_of_project[]" value="item">
    <label for="item">Promotional item/Giveaway</label>
    </td></tr><tr><td>
    <input type="checkbox"  name="type_of_project[]" value="print">
    <label for="print">Print Aid</label>
    </td><td>
    <input type="checkbox"  name="type_of_project[]" value="other">
    <label for="other">Other (Please specify)</label>
    </td></tr><tr><td>
    <input type="checkbox"  name="type_of_project[]" value="release">
    <label for="release">Press Release/E-blast</label>
        </td>  <td><textarea name="type_of_project" rows="1" column="100"></textarea></td></tr>
      
        
        
        
        </table></td>
    
    <tr> <td border="1">
            <label for="project_content"><b>Is this project:</b></label></td>
            <input name="project_content">
            <td><table class="form-table"><tr>
                <input type="checkbox" id="new" name="project_content[]" value="new">
                <label for="new">New</label></tr><br/>
                <tr><input type="checkbox" id="update" name="project_content[]" value="update">
                <label for="update_info">Update from a previous piece.<br/>If updated from a previous piece,provide the title, reference number, or webpage link below:<br/>
                <textarea name="update_info" rows="1" column="500"></textarea></label></tr></table>
        </td></tr></table>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table">
<tr>
	
    <td id="column_heading" colspan="2" border="0" style="text-align: left;"><b>Target Audiences:</b></td>
			</tr></table>
    
    <table border="1" cellpadding="5" cellspacing="0" class="form-table">
        <tr> <td border="1">
    <label for="target"><b>Choose all that apply</b>
        </label>
            <input name="target"></td>
    <td><table><tr><td border="1">
<input type="checkbox" id="prospective_customers" name="target[]" value="prospective_customers">
  <label for="prospective_customers">Prospective Customers</label>
        </td><td>
    <input type="checkbox" id="Engineers" name="target[]" value="Engineers">
  <label for="Engineers">Engineers</label>
        </td></tr><tr><td>
    <input type="checkbox" id="buyers" name="target[]" value="buyers">
  <label for="buyers">Procurement Managers/Buyers</label>
    </td><td>
    <input type="checkbox" id="current" name="target[]" value="current">
  <label for="current">Current Customers</label>
    </td></tr><tr><td>
    <input type="checkbox" id="plant_managers" name="tagret[]" value="plant_managers">
  <label for="plant_managers">Plant/MRO Managers</label>
    </td>
    <td> <input type="checkbox" id="other" name="target[]" value="other">
    <label for="Other">Other (Please specify)</label><textarea name="target" rows="1" column="100"></textarea></td></tr>
        </table></td></tr>
        
         <tr> <td border="1">
    <label for="Info"><b>Audience Persona Information</b><br/><ul>
        <li>Personal Demographics</li>
        <li>Level of Seniority</li>
        <li>Pain points/Challenges</li>
        <li>Goals and Values</li>
        <li>Questions they ask</li>
        <li>Where they get information</li>
        <li>Expected buying Experience</li>
        <li>Common Objections</li>
        </ul>
        </label>
             </td>
             <td><textarea name="Info" rows="11" width="1000px" cols="70"></textarea></td></tr>
        <br/>
        <br/>
        <br/>
        <br/>
    <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="column_heading" colspan="2" border="0" style="text-align: left;">
	
    <!--<td id="column_heading" colspan="2" border="0" style="text-align: left;">--><b>Purpose</b><br/>
			</tr>
        <tr><td><textarea name="purpose" rows="6" cols="120"></textarea></td></tr></table>
        
        <table cellpadding="5" cellspacing="1" class="form-table">
<tr id="column_heading" colspan="2" border="0" style="text-align: left;">
        <b>Key Messages</b><br/>
     
			</tr>
        <tr><td><textarea name="key_messages" rows="6" cols="120"></textarea></td></tr></table>
         <table cellpadding="5" cellspacing="1" class="form-table">
        <tr id="column_heading" colspan="2" border="0" style="text-align: left;">
        <b>Supporting Information:</b><br/>
			</tr>
        <tr><td><textarea name="support" rows="6" cols="120"></textarea></td></tr></table>
     <table cellpadding="5" cellspacing="1" class="form-table">
       <tr id="column_heading" colspan="2" border="0" style="text-align: left;">
        <b>Photography Needed?</b> 
    <input type="checkbox"  name="photography[]" value="yes">
    <i><label for="photography">yes</label></i>
    
    <input type="checkbox" name="photography[]" value="no">
    <i><label for="photography">no</label></i><br/>
			</tr>
        <tr><td ><textarea name="photography" rows="6" cols="120"></textarea></td></tr></table>
        
        <table border="1" style="text-align: left;" class="form-table"><tr><td ><b>Estimated Quantity:</b></td> <td ><input type="text" name="estimate" maxlength="300" style="width:260px"></td> <td><i>If applicable.</i></td> </tr>
        
        <tr><td ><b>Means of Delivery:</b></td> <td ><input type="text" name="delivery" maxlength="300" style="width:260px"></td> <td>Anticipated plan for delivering the piece, tradiotional mailing, blogging,<br/> e-mailing, handing out of events, etc.</td></tr>
            
           <tr><td ><b>Date Needed:</b></td> <td ><input type="text" name="date_needed" maxlength="300" style="width:260px"></td> <td>A minimum of 4-8 weeks may be required for many printed materials requests.<br/> The scope of some requests, especially new projects or items to be mailed, may require more time.</td></tr>  
              <tr><td ><b>Available Budget:</b></td> <td ><input type="text" name="budget" maxlength="300" style="width:260px"></td> <td>To cover printing, photography or other vendor charges.</td></tr> 
            
            
              <tr><td ><b>Cost Counter #:</b></td> <td ><input type="text" name="cost" maxlength="300" style="width:260px"></td> <td>If applicable</td></tr> 
        </table>
       
</form>
</html>

</form>
</html>

