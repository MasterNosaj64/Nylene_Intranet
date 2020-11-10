<?php
include 'interaction.php';
include 'company.php';
include 'listBuffer.php';
include 'connect.php';

$interaction_Conn = getDBConnection();



/* $interactions = new Interaction($interaction_Conn);

$interactionData = $interactions->read();
 */

$companies = new Company($interaction_Conn);

$campanyData = $companies->read();

$buffer = create_Buffer($campanyData, $companies);

echo "<h1>unsorted</h1><br>";

for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {
    
    $currentInteractionNode = unserialize($buffer->current());
    
    echo $currentInteractionNode->getName();
    echo "<br>";
}

echo "<h1>sorted?</h1><br>";

$buffer = sort_Company_Name($buffer);

for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {
    
    $currentInteractionNode = unserialize($buffer->current());
    
    echo $currentInteractionNode->getName();;
    echo "<br>";
}