<?php
include 'interaction.php';
include 'company.php';
include 'listBuffer.php';
include 'connect.php';
include 'Employee.php';
include 'customer.php';

$interaction_Conn = getDBConnection();



/* $interactions = new Interaction($interaction_Conn);

$interactionData = $interactions->read(); */


$companies = new Customer($interaction_Conn);

$companyData = $companies->read();

$buffer = create_Buffer($companyData, $companies);

echo "<h1>unsorted</h1><br>";

for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {
    
    $currentInteractionNode = unserialize($buffer->current());
   // $conn = getDBConnection();
    //$customer = new Company($conn);
   // $customer->searchById($currentInteractionNode->getCustomerId());
    echo $currentInteractionNode->getFax();
    echo "<br>";
   // $conn->close();
}

echo "<h1>sorted?</h1><br>";

$buffer = sortASC_CustomerFax($buffer);

for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {
    
    $currentInteractionNode = unserialize($buffer->current());
   // $conn = getDBConnection();
   // $customer = new Company($conn);
   // $customer->searchById($currentInteractionNode->getCustomerId());
    echo $currentInteractionNode->getFax();
    echo "<br>";
    //$conn->close();
}