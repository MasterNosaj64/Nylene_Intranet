<?php
  /* Name: MMForm.php
     * Author: Karandeep Singh
     * Purpose: Input for Marketing Materials Request Form. Requester information, and Project information.
     */
// starts the session
session_start();
 include '../NavPanel/navigation.php';
include '../Database/connect.php';
	
	$conn = getDBConnection();
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
		/*Selection statement for current employee*/
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee 
								WHERE employee_id = " . $_SESSION['userid'];
		$result = $conn->query($userInformation); 
		$row = mysqli_fetch_array($result);
		
		/*Selection statement for customer passed from interaction*/
		$customerSelect = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['customer_id'];
		$customerInfo = $conn->query($customerSelect);
		$customerRow = mysqli_fetch_array($customerInfo);

		/*Selection statement for company passed from interaction*/
		$companySelect = "SELECT * FROM company WHERE company_id = " . $_SESSION['company_id'];
		$companyInfo = $conn->query($companySelect);
		$companyRow = mysqli_fetch_array($companyInfo);
		
		$conn->close();
	}
?>


<html>
<head> 
    
  <link rel="stylesheet" type="text/css" href = "../CSS/form.css">
    <title>Marketing Materials Request Form</title>
</head>
    
<form  method="post" action="MMform_Database.php";>
    
<script type="text/javascript">
    //checks if the fields are not blank
    /*
    
function ValidateForm(frm) {
if (frm.Requester_Name.value == "") { alert(' Requesters name is required.'); frm.Requester_Name.focus(); return false; }
if (frm.Marketing_Segment.value == "") { alert('Marketing Segment is required.'); frm.Marketing_Segment.focus(); return false; }
if (frm.Email_Address.value == "") { alert('Email address is required.'); frm.Email_Address.focus(); return false; }
if (frm.Email_Address.value.indexOf("@") < 1 || frm.Email_Address.value.indexOf(".") < 1) { alert('Please enter a valid email address.'); frm.Email_Address.focus(); return false; }
return true; }
    */
</script>

    <table border="1" cellpadding="5" cellspacing="1" class="form-table">          
	<tr>
        <td style="width :50%"><label for="Requester_Name"> <b>Requester Name*</b> </label></td>
    			<td ><input type="text" id="Requester_Name" name="Requester_Name" maxlength="250" style="width: 260px" required> </td>
	

        <td ><label for="Market_Segment"> <b>Market Segment*</b> </label></td>
    			<td ><input type="text" id="Market_Segment" name="Market_Segment" maxlength="250" style="width: 260px" required></td>
</tr> 
      
                <tr>
                    <td ><label for="Sales_Territory"> <b>Sales Territory </b></label></td>
    			<td ><input type="text" id="Sales_Territory" name="Sales_Territory" maxlength="250" style="width: 260px"></td>
                    
        	 <td ><label for="Email"> <b>Email* </b></label></td>
    			<td ><input type="text" id="Email" name="Email" maxlength="250" style="width: 260px" required></td>
        </tr>

                <tr>
	
        	 <td ><label for="Phone"> <b>Phone</b></label></td>
    			<td ><input type="text" id="Phone" name="Phone" maxlength="250" style="width: 260px"></td>
       
        <td ><label for="Date"> <b>Today's Date </b></label></td>
    			<td ><input type="date" id="Date" name="Date" maxlength="250" style="width: 260px"></td> </tr>
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
<input type="checkbox"  name="brochure" value="1">
  <label for="brochure">Brochure</label>
        </td><td>
       
    <input type="checkbox"  name="ppt" value="1">
  <label for="ppt">PowerPoint Presentation</label>
        </td></tr><tr><td>
       
    <input type="checkbox"  name="fact_sheet" value="1">
  <label for="fact_sheet">Fact Sheet</label>
    </td><td>
       
    <input type="checkbox"  name="video" value="1">
  <label for="video">Video</label>
    </td></tr><tr><td>
       
    <input type="checkbox"  name="direct_mail" value="1">
  <label for="direct_mail">Direct Mail</label>
    </td><td>
      
    <input type="checkbox"  name="web" value="1">
  <label for="web">Web(specify)</label>
   
    <input type="checkbox"  name="page" value="1">
    <i><label for="page">Page</label></i>
  
    <input type="checkbox"  name="section" value="1">
    <i><label for="section">Section</label></i>
    
    <input type="checkbox"  name="blog" value="1">
    <i><label for="blog">Blog</label></i>

    <input type="checkbox"  name="landing_page" value="1">
    <i><label for="landing_page">Landing Page</label></i>
   
    <input type="checkbox"  name="updt" value="1">
    <i><label for="update">Update</label></i>
   
    <input type="checkbox"  name="graphic" value="1">
    <i><label for="graphic">Graphic</label></i>
    </td></tr><tr><td>
     
    <input type="checkbox"  name="tradeshow" value="1">
    <label for="tradeshow">Tradeshow</label>
    </td><td>
     
    <input type="checkbox"  name="promotional_item" value="1">
    <label for="promotional_item">Promotional item/Giveaway</label>
    </td></tr><tr><td>
     
    <input type="checkbox"  name="print_aid" value="1">
    <label for="print_aid">Print Aid</label>
    </td><td>
      
    <input type="checkbox"  name="other_type_of_project" value="1">
    <label for="other_type_of_project">Other (Please specify)</label>
        <textarea name="type_of_project" rows="1" column="100"></textarea>
    </td></tr><tr><td>
        
    <input type="checkbox"  name="press_release" value="1">
    <label for="press_release">Press Release/E-blast</label>
        </td> </tr> 
        </table></td>
    
    <tr> <td border="1">
      
            <label for="project_content"><b>Is this project:</b></label></td>
            <input name="project_content" id="project_content">
            <td><table class="form-table"><tr>
              
                <input type="radio" id="new" name="project_content" value="new">
                <label for="new">New</label></tr><br/>
             
                <tr><input type="radio" id="update" name="project_content" value="update">
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
    <td><table><tr><td border="1">
      
<input type="checkbox"  name="prospective_customers" value="1">
  <label for="prospective_customers">Prospective Customers</label>
        </td><td>
       
    <input type="checkbox" name="Engineers"  value="1">
  <label for="Engineers">Engineers</label>
        </td></tr><tr><td>
      
    <input type="checkbox" name="procurement_managers"  value="1">
  <label for="procurement_managers">Procurement Managers/Buyers</label>
    </td><td>
       
    <input type="checkbox" name="current_customers"  value="1">
  <label for="current_customers">Current Customers</label>
    </td></tr><tr><td>
   
    <input type="checkbox" name="plant_managers" value="1">
  <label for="plant_managers">Plant/MRO Managers</label>
    </td>
     
    <td> <input type="checkbox" name="other_audience"  value="1">
    <label for="other_audience">Other (Please specify)</label><textarea name="other_audience" rows="1" column="100"></textarea></td></tr>
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
    <input type="radio"  name="is_photography_needed" value="Yes">
    <i><label for="Yes">Yes</label></i>
    
    <input type="radio"  name="is_photography_needed" value="No">
    <i><label for="No">No</label></i><br/>
			</tr>
        <tr><td ><textarea name="needed_photography" rows="6" cols="120"></textarea></td></tr></table>
        
        <table border="1" style="text-align: left;" class="form-table"><tr><td ><b>Estimated Quantity:</b></td> <td ><input type="text" name="estimate" maxlength="300" style="width:260px"></td> <td><i>If applicable.</i></td> </tr>
      
            
        <tr><td ><b>Means of Delivery:</b></td> <td ><input type="text" name="delivery" maxlength="300" style="width:260px"></td> <td>Anticipated plan for delivering the piece, tradiotional mailing, blogging,<br/> e-mailing, handing out of events, etc.</td></tr>
           
            
           <tr><td ><b>Date Needed:</b></td> <td ><input type="date" name="date_needed" maxlength="300" style="width:260px"></td> <td>A minimum of 4-8 weeks may be required for many printed materials requests.<br/> The scope of some requests, especially new projects or items to be mailed, may require more time.</td></tr> 
           
            
              <tr><td ><b>Available Budget:</b></td> <td ><input type="text" name="budget" maxlength="300" style="width:260px"></td> <td>To cover printing, photography or other vendor charges.</td></tr> 
            
            
              <tr><td ><b>Cost Counter #:</b></td> <td ><input type="text" name="cost" maxlength="300" style="width:260px"></td> <td>If applicable</td></tr> 
        </table>
        <table cellpadding="5" cellspacing="1" class="form-table">
        
			<tr>
				<td><input type="Submit" name="Submit" value="Submit"></td>
				<td><input type="reset" value="Reset"></td>
			</tr>
		</table>
</form>
</html>
