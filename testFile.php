<?php
include 'Database/connect.php';
echo "this is just a empty test file for debugging purposes\n";

echo "Employee test\n";
include 'Database/Employee.php';
include 'Database/Company.php';

$companies = new Company($conn);

$compName = $companies->search("", "", "", "", "", "", "", "");

while ($compName->fetch()) {
    echo "Company: ".$companies->getname()."\n";
    $employees = new Employee(getDBConnection());

    $searchName = $employees->search($companies->getCreatedBy(), "", "", "", "", "", "", "", "", "", "", "");
    $searchName->fetch();
        echo "Employee name is: ".$employees->getName()."\n ";
    
    
    
}
/* $employees = new Employee($conn);

$searchName = $employees->search(1, "", "", "", "", "", "", "", "", "", "", "");

while ($searchName->fetch()) {
    echo "Employee name is: ".$employees->getName()."\n ";
} */



?>

