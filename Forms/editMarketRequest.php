<?php 
/*
 * Name: editMMform.php
 * Author: Karandeep Singh
 * Purpose: View and edit Marketing Materials Request form.
 */
session_start();
	
     include '../NavPanel/navigation.php';
	include '../Database/connect.php';
        
    $conn = getDBConnection();

	//Check the connection
	if ($conn-> connect_error) {
	
		die("Connection failed: " . $conn-> connect_error);
	
	} else {
		      /*Selection statement for form*/
        $sql = "SELECT * FROM marketing_request_form 
								WHERE marketing_request_id =". $_POST['id'];
		$query = $conn->query($sql);								
		$row = mysqli_fetch_array($query);
        
             /*Assigning value to is_photography_needed for checkbox*/
        if ($row['is_photography_needed'] == 'Yes') {
        $checked = 1;
    } else {
        $checked = 0;
    }
		
		      /*Selection statement for customer passed from interaction*/
		$customerInformation	=  "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN marketing_request_form ON marketing_request_form.marketing_request_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 5 AND interaction_relational_form.form_id =". $_POST['id'];
		$customerResult = $conn->query($customerInformation); 
		$customerRow = mysqli_fetch_array($customerResult); 
		
		$conn->close();
	}
?>
<html>
<head> 
  <link rel="stylesheet" type="text/css" href = "../CSS/form.css">
    <title> Edit Marketing Materials Request Form</title>
</head>
<form  method="post" action="editMMform_Database.php"   name="editMarketRequest";>
    <table border="1" cellpadding="5" cellspacing="1" class="form-table"> 
        <tr>
                        <!--Requester Name -->
            <td id="Requester_Name"><b>Requester Name</b></td>
			<td colspan="2"><input type="text" name="Requester_Name" maxlength="250" style="width: 260px" required value="<?php echo $row['requester_name'];?>"></td>
            
                        <!--Market Segment -->
            <td id="Market_Segment"><b>Market Segment</b></td>
			<td colspan="2"><input type="text" name="Market_Segment" maxlength="250" style="width: 260px" required value="<?php echo $row['market_segment'];?>"></td>
</tr> 
                <tr>    
                        <!--Sales Territory-->
                    <td id="Sales_Territory"><b>Sales Territory</b></td>
			         <td colspan="2"><input type="text" name="Sales_Territory" maxlength="250" style="width: 260px" value="<?php echo $row['sales_territory'];?>"></td>
                    
                        <!--Email -->
                    <td id="Email"><b>Email</b></td>
			<td colspan="2"><input type="text" name="Email" maxlength="250" style="width: 260px" required value="<?php echo $row['email'];?>"></td>
        </tr>
          <tr>
	                   <!--Phone -->
              <td id="Phone"><b>Phone</b></td>
			<td colspan="2"><input type="text" name="Phone" maxlength="250" style="width: 260px" value="<?php echo $row['phone'];?>"></td>

                        <!--Date Needed -->
              <td id="Date"><b>Date</b></td>
			<td colspan="2"><input type="text" name="Date" maxlength="250" style="width: 260px" readonly
				value="<?php echo $row['request_date'];?>"></td> </tr>
    </table>
     <table border="1" cellpadding="5" cellspacing="1" class="form-table">
<thead><tr>
	
    <td id="column_heading" colspan="2" border="0" style="text-align: left;"><b>Project Background</b></td>
    </tr></thead></table>
                        <!--Name of Project -->
     <table border="1" cellpadding="5" cellspacing="0" class="form-table">
         <tr> <td colspan ="2" id="Name_of_Project"><b>Name of Project</b>
			<input type="text" name="Name_of_Project" maxlength="250" style="width: 260px" value="<?php echo $row['name_project_or_piece'];?>"></td>
 </tr>
                        <!--Type of Project-->
          <td id="type_of_project"><b>Type of Project or Piece</b><br>if known<br>If multiple communication are needed,choose all that apply.
			<input type="text" name="type_of_project" maxlength="250" style="width: 260" value="<?php echo $row['type_of_project'];?>"></td>
         
          <td><table><tr><td border="1">
                        <!--Checkbox for Brochure -->
                <input type="checkbox"  name="brochure" value=1 <?php if($row['brochure'] == 1) {echo "checked";} ?>>
                <label for="brochure">Brochure</label>
        </td>
             
             <td border="1">
                        <!--Checkbox for Powerpoint Presentation -->
                <input type="checkbox"  name="ppt" value=1 <?php if($row['ppt'] == 1) {echo "checked";} ?>>
                <label for="ppt">PowerPoint Presentation</label>
             </td></tr>
             
           <tr>  <td border="1">
                        <!--Checkbox for Fact Sheet -->
                <input type="checkbox"  name="fact_sheet" value=1 <?php if($row['fact_sheet'] == 1) {echo "checked";} ?>>
                <label for="fact_sheet">Fact Sheet</label>
             </td>
             
             <td border="1">
                        <!--Checkbox for Cideo -->
                <input type="checkbox"  name="video" value=1 <?php if($row['video'] == 1) {echo "checked";} ?>>
                <label for="video">Video</label>
               </td></tr>
             
           <tr>  <td border="1">
                        <!--Checkbox for Direct Mail -->
                <input type="checkbox"  name="direct_mail" value=1 <?php if($row['direct_mail'] == 1) {echo "checked";} ?>>
                <label for="direct_mail">Direct Mail</label>
        </td>
             
             <td border="1">
                        <!--Checkbox for Web -->
                <input type="checkbox"  name="web" value=1 <?php if($row['web'] == 1) {echo "checked";} ?>>
                <label for="web">Web(specify)</label>
      
             
                        <!--Checkbox for Page -->
                 <input type="checkbox"  name="page" value=1 <?php if($row['page'] == 1) {echo "checked";} ?>>
                 <label for="page"><i>Page</i></label>
       
                        <!--Checkbox for Section -->
                <input type="checkbox"  name="section" value=1 <?php if($row['section'] == 1) {echo "checked";} ?>>
                 <label for="section"><i>Section</i></label>
        
                        <!--Checkbox for Blog -->
                <input type="checkbox"  name="blog" value=1 <?php if($row['blog'] == 1) {echo "checked";} ?>>
                 <label for="blog"><i>Blog</i></label>
                   
                        <!--Checkbox for Landing Page -->
                 <input type="checkbox"  name="landing_page" value=1 <?php if($row['landing_page'] == 1) {echo "checked";} ?>>
                 <label for="landing_page"><i>Landing Page</i></label>
       
                        <!--Checkbox for Update -->
                <input type="checkbox"  name="updt" value=1 <?php if($row['updt'] == 1) {echo "checked";} ?>>
                 <label for="updt"><i>Update</i></label>
       
                        <!--Checkbox for Graphic -->
                <input type="checkbox"  name="graphic" value=1 <?php if($row['graphic'] == 1) {echo "checked";} ?>>
                 <label for="graphic"><i>Graphic</i></label>
                </td>
             
           <tr> <td border="1">
                        <!--Checkbox for Tradeshow -->
               <input type="checkbox"  name="tradeshow" value=1 <?php if($row['tradeshow'] == 1) {echo "checked";} ?>>
                <label for="tradeshow">Tradeshow</label>
        </td>
             
             <td border="1">
                        <!--Checkbox for Promotional Item/Giveaway -->
                 <input type="checkbox"  name="promotional_item" value=1 <?php if($row['promotional_item'] == 1) {echo "checked";} ?>>
                <label for="promotional_item">Promotional Item/Giveaway</label>
               </td></tr>
             
            <tr><td border="1">
                        <!--Checkbox for Prirnt Aid -->
                <input type="checkbox"  name="print_aid" value=1 <?php if($row['print_aid'] == 1) {echo "checked";} ?>>
                <label for="print_aid">Print Aid</label>
        </td>
             
             <td border="1">
                        <!--Checkbox for Press Release -->
                <input type="checkbox"  name="press_release" value=1 <?php if($row['press_release'] == 1) {echo "checked";} ?>>
                <label for="press_release">Press Release/E-Blast</label>
                </td></tr>
                        <!--Checkbox for Other --> 
           <td> <input type="checkbox" name="other_type_of_project"  value =1 <?php if($row['other_type_of_project'] == 1) {echo "checked";} ?>>
               <label for="other_type_of_project">Other (Please specify)</label>
                        <!--Textbox for Other -->
               <input type="text"  name="other_type_of_project" rows="1" column="100" value="<?php echo $row['other_type_of_project']?>"></td></table></td>
         
                        <!--Radio button for Project Content -->
         <tr> <td id="project_content"><b>Is this Project:</b></td>
        			<td><table class="form-table"><tr><?php if ($checked){ ?>
        		<input type="radio" name="project_content" value="Yes" checked>
                        <label for="new"> New </label> </tr> <tr>
                        <input type="radio" name="project_content" value="No"> <label for="update"> Update </label></tr>
        			<?php } else { ?>
        			<tr><input type="radio" name="project_content" value="Yes">
                        <label for="new"> New </label></tr><tr>
                        <input type="radio" name="project_content" value="No" checked> <label for="update"> Update
                        </label>
        			<?php } ?>
                          <td colspan="2"><input type="text" name="update_info" maxlength="250" style="width: 260px" value="<?php echo $row['if_piece_new'];?>"></td></tr></table></td>
         </tr></table>
   
    <table border="1" cellpadding="5" cellspacing="1" class="form-table">
    <thead><tr>
	
    <td id="column_heading" colspan="2" border="0" style="text-align: left;"><b>Target Audiences</b></td>
        </tr></thead></table>
    
         <table border="1" cellpadding="5" cellspacing="0" class="form-table">
        <tr> <td border="1">
    <label for="target"><b>Choose all that apply</b>
        </label>
            <td><table><tr><td border="1">
                
                        <!--Checkbox for Prospective Customers -->
            <input type="checkbox"  name="prospective_customers" value=1 <?php if($row['prospective_customers'] == 1) {echo "checked";} ?>>
            <label for="prospective_customers">Prospective Customers</label>
        </td>
                
                <td border="1">
                        <!--Checkbox for Engineers -->
                    <input type="checkbox"  name="engineers" value=1 <?php if($row['engineers'] == 1) {echo "checked";} ?>>
                    <label for="engineers">Engineers</label>
                </td></tr>
                
    
                <tr><td border="1">
                        <!--Checkbox for Procurement Managers -->
                    <input type="checkbox"  name="procurement_managers" value=1 <?php if($row['procurement_managers'] == 1) {echo "checked";} ?>>
                    <label for="procurement_managers">Procurement Managers/Buyers</label>
        </td>
                
                <td border="1">
                        <!--Checkbox for Current Customers -->
                    <input type="checkbox"  name="current_customers" value=1 <?php if($row['current_customers'] == 1) {echo "checked";} ?>>
                    <label for="current_customers">Current Customers</label>
                    </td></tr>
                
              <tr>  <td border="1">
                        <!--Checkbox for Plant Managers/MRO -->
                  <input type="checkbox"  name="plant_managers" value=1 <?php if($row['plant_managers'] == 1) {echo "checked";} ?>>
                    <label for="plant_managers">Plant/MRO Managers</label>
        </td>
                        <!--Checkbox for Other -->
                <td> <input type="checkbox" name="other_audience"  value =1 <?php if($row['other_audience'] == 1) {echo "checked";} ?>>
                    <label for="other_audience">Other (Please specify)</label>
                    
                        <!--Other -->
                    <input type="text" name="other_audience" rows="1" column="100" value="<?php echo $row['other_audience']?>"></td></tr>
        </table></td></tr>
             
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
                        <!--Audience Personal Information -->
         <td colspan="2"><textarea name="Info" rows="11" width="1000px" cols="70" value="<?php echo $row['audiance_personal_info']?>"></textarea></td>

        <br/>
        <br/>
        <br/>
        <br/>
         
                        <!--Purpose -->
          <table cellpadding="5" cellspacing="1" class="form-table"><thead>
              <tr id="purpose"><td id="column_heading"  border="0" style="text-align: left;"><b>Purpose</b></td></tr></thead>
              <tr><td colspan="2"><textarea name="purpose" rows="6" cols="120" value="<?php echo $row['purpose'];?>"></textarea></td>
        </tr> </table>

                        <!--Key Messages -->
       <table cellpadding="5" cellspacing="1" class="form-table"><thead>
           <tr id="key_messages"><td id="column_heading"  border="0" style="text-align: left;"><b>Key Messages</b></td></tr></thead>
           <tr><td colspan="2"><textarea name="key_messages" rows="6" cols="120" value="<?php echo $row['key_message'];?>"></textarea></td>
        </tr> </table>

                        <!--Supporting Information -->
          <table cellpadding="5" cellspacing="1" class="form-table"><thead>
              <tr id="support"><td id="column_heading"  border="0" style="text-align: left;"><b>Supporting Information</b></td></tr></thead>
              <tr><td colspan="2"><textarea name="support" rows="6" cols="120" value="<?php echo $row['supporting_info'];?>"></textarea></td>
        </tr> </table>
         
                        <!--Radio Button for Needed Phorography? -->
         <table cellpadding="5" cellspacing="1" class="form-table">
        <thead><tr> <td id="column_heading"  border="0" style="text-align: left;"><b>Needed Photography?</b>
        			<?php if ($checked){ ?>
        			<input type="radio" name="is_photography_needed" value="Yes"
					checked> <label for="Yes"> Yes </label> <input type="radio"
					name="is_photography_needed" value="No"> <label for="No"> No </label>
        			<?php } else { ?>
        			<input type="radio" name="is_photography_needed" value="Yes">
					<label for="Yes"> Yes </label> <input type="radio"
					name="is_photography_needed" value="No" checked> <label for="No"> No
        
				</label>
        			<?php } ?> </td>
            </tr></thead></table>
             
                    <!--Needed Photography -->
        <table cellpadding="5" cellspacing="1" class="form-table">
            <tr id="needed_photography">
            <tr><td colspan="2"><textarea name="needed_photography" rows="6" cols="120" value="<?php echo $row['needed_photography'];?>"></textarea></td>
        </tr> </table>
             
                    <!--Estimated Quantity -->
     <table border="1" style="text-align: left;" class="form-table"><tr><td ><b>Estimated Quantity:</b></td>      
            <td>   <input type="text" name="estimate" maxlength="300" style="width:260px" value="<?php echo $row['estimated_quantity'];?>"></td>
 <td><i>If applicable.</i></td> </tr>
        
                    <!--Means of Delivery-->
        <tr><td ><b>Means of Delivery:</b></td> <td >
            <input type="text" name="delivery" maxlength= "300" style="width:260px" value="<?php echo $row['means_of_delivery'];?>"></td>
 <td>Anticipated plan for delivering the piece, tradiotional mailing, blogging,<br/> e-mailing, handing out of events, etc.</td></tr>
            
                    <!--Date Needed -->
           <tr><td ><b>Date Needed:</b></td> <td >
                     <input type="date" name="date_needed" maxlength= "300" style="width:260px" value="<?php echo $row['date_needed'];?>"></td> <td>A minimum of 4-8 weeks may be required for many printed materials requests.<br/> The scope of some requests, especially new projects or items to be mailed, may require more time.</td></tr>  
            
                    <!--Available Budget -->
              <tr><td ><b>Available Budget:</b></td>  <td>
                  <input type="text" name="budget" maxlength= "300" style="width:260px" value="<?php echo $row['available_budget'];?>"></td>
 <td>To cover printing, photography or other vendor charges.</td></tr> 
            
                    <!--Cost -->
              <tr><td ><b>Cost Counter #:</b></td> <td >
                  <input type="text" name="cost" maxlength= "300" style="width:260px" value="<?php echo $row['cost_center_number'];?>"></td>
<td>If applicable</td></tr> 
        </table>
    
    <tr>
                    <td colspan="3"> <input type="submit" style="width:100%"> </td>
                    <td colspan="3"> <input type="reset" style="width:100%"><input hidden type="number" id="marketing_request_id" name="marketing_request_id" value="<?php echo $row['marketing_request_id'];?>"> </td>
             </tr> 
    </table>
</html>   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

