<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<?php
include 'Database/connect.php';
include 'Database/Employee.php';
include 'Database/Company.php';

$companies = new Company($conn);

$compResult = $companies->search("", "", "", "", "", "", "", "");

// Buffer of companies
$companyList = new SplDoublyLinkedList();

while ($compResult->fetch()) {
    $companyList->push($companies->get());
}
// Reverse to first node
$companyList->rewind();

echo $companyList->count() . " record(s) found";
?>
<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Name</td>
			<td>Website</td>
			<td>Email</td>
			<td>Street</td>
			<td>City</td>
			<td>State</td>
			<td>Assigned To</td>
			<td>Created By</td>
			<td>Menu</td>
		</tr>
	</thead>
	<?php 
	var_dump($companyList);
	for($companyList->rewind(); $companyList->valid();$companyList->next()){
	    $company = $companyList->current();
	    
	    echo "<tr>";
	    echo "<td>" . $company->getname() . "</td>";
	    echo "<td><a href=\"" . $company->website . "\">" . $company->website . "</a></td>";
	    echo "<td><a href =\"mailto: " . $company->company_email . "\">" . $company->company_email . "</a></td>";
	    echo "<td>" . $company->billing_address_street . "</td>";
	    echo "<td>" . $company->billing_address_city . "</td>";
	    echo "<td>" . $company->billing_address_state . "</td>";
	    echo "<td>" . $company->getAssignedTo() . "</td>";
	    echo "<td>" . $company->getCreatedBy() . "</td>";
	    echo "<td><form action=\"./editCompany.php\" method=\"post\">
		<input hidden name =\"company_id_edit\" value=\"" . $companies->company_id . "\"/>
		<input type=\"submit\" value=\"edit\"/>
	</form>
    <form action=\"./viewCompany.php\" method=\"post\">
		<input hidden name =\"company_id_view\" value=\"" . $companies->company_id . "\"/>
		<input type=\"submit\" value=\"view\"/>
	</form>
   </td>";
	    echo "</tr>";
	}
	    
	
	
	
	
	
	?>
		
	
	
</table></html>	