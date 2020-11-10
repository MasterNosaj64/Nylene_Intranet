<?php

/*
 * FileName: listBuffer.php
 * Version Number: 1.1
 * Date Modified: 11/01/2020
 * Author: Jason Waid
 * Purpose:
 * Provide pages a list of objects and alow the user to navigate the list
 * refered to as the list buffer
 */

/*
 * Function: create_Buffer
 * Purpose:
 * Creates a buffer of objects
 * Object expected are: Company, Customer, Employee & Interaction
 * returns the list
 */
function create_Buffer($queryResult, $object)
{
    // pass the query result into the function and it will create a node for every row
    $buffer = new SplDoublyLinkedList();

    // set iteration
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);

    // set iteration behavior
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_KEEP);

    // adds all objects to the list
    while ($queryResult->fetch()) {

        // Serialize the current object to prepare it for storage
        // Then store it into the linked list
        $buffer->push(serialize($object->get()));
    }

    // rewinds buffer to begining of list
    $buffer->rewind();

    // prepare buffer for storage
    // $buffer->serialize();

    // store buffer into session
    $_SESSION['buffer'] = $buffer;

    // Set the initial offset
    $_SESSION['offset'] = 0;

    // prepare buffer for printing after sotred into session
    // $buffer->unserialize($buffer);

    return $buffer;
}

/*
 * Function: next10
 * Purpose:
 * navigates a list of companies and moved the iterator to the next 10 or closest existing index
 * returns the list
 */
function next10(SplDoublyLinkedList $sessionBuffer)
{
    // $buffer = unserialize($sessionBuffer);
    $buffer = $sessionBuffer;
    $counter = 0;

    for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {

        if ($counter == $_SESSION['offset']) {
            break;
        }

        $counter ++;
    }

    return $buffer;
}

/*
 * Function: previous10
 * Purpose:
 * navigates a list of companies and moved the iterator to the previous 10 or closest existing index
 * returns the list
 */
function previous10(SplDoublyLinkedList $sessionBuffer)
{

    // $buffer = unserialize($sessionBuffer);
    $buffer = $sessionBuffer;
    $counter = 0;

    for ($buffer->rewind(); $buffer->valid(); $buffer->next()) {

        if ($counter == $_SESSION['offset']) {
            break;
        }

        $counter ++;
    }

    return $buffer;
}

/*
 * Function: create_Customer_Buffer
 * Purpose:
 * Creates a buffer of Customer objects
 * Object expected are: Customer
 * returns the list
 */
function create_Customer_Buffer($customerIDs)
{

    // pass the query result into the function and it will create a node for every row
    $buffer = new SplDoublyLinkedList();

    // set iteration
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);

    // set iteration behavior
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_KEEP);

    // adds all objects to the list
    while ($cx = mysqli_fetch_array($customerIDs)) {

        $dbConnection = getDBConnection();

        if ($dbConnection->connect_error) {
            die("A connection failed: Company: " . $dbConnection->connect_error);
        }

        $customer = new Customer($dbConnection);

        $customerData = $customer->searchById($cx['customer_id']);
        $customerData->fetch();

        $buffer->push(serialize($customer->get()));

        $dbConnection->close();
    }

    // rewinds buffer to begining of list
    $buffer->rewind();

    // prepare buffer for storage
    // $buffer->serialize();

    // store buffer into session
    $_SESSION['buffer'] = $buffer;

    // Set the initial offset
    $_SESSION['offset'] = 0;

    // prepare buffer for printing after sotred into session
    // $buffer->unserialize($buffer);

    return $buffer;
}


function sort_Interactions_Date(SplDoublyLinkedList $sessionBuffer){
    
    
    if($sessionBuffer->isEmpty()){
        return $sessionBuffer;
    }
    $index = 0;
    $sortedObjects = 0;
    $sortedSessionBuffer = new SplDoublyLinkedList;
    
    if($sessionBuffer->count() > 1){

        do{
        
            //get first object
            $obj1 = unserialize($sessionBuffer->bottom());
            
            echo "new bottom {$obj1->getDateCreated()}";
            
            
        for ($sessionBuffer->rewind(); $sessionBuffer->valid(); $sessionBuffer->next()) {
            
            $obj2 = unserialize($sessionBuffer->current());
           
            if($obj1->getDateCreated() > $obj2->getDateCreated()){
               
                $obj1 = $obj2->get();
                $index = $sessionBuffer->key();
                
            }
               
        }
        
        $sortedSessionBuffer->unshift(serialize($obj2->get()));
        $sortedObjects++;
        
        $sessionBuffer->offsetUnset($index);
        
        
        }while($sortedObjects != $sessionBuffer->count());

    }
    else
    {
        
        return $sessionBuffer;
    }
       
    return $sortedSessionBuffer;
    
}

function sort_Interactions_Customer($sessionBuffer){
    
    
    
}


function sort_Interactions_Reason($sessionBuffer){
    
    
    
}

function sort_Interactions_Notes($sessionBuffer){
    
    
    
}

function sort_Interactions_CreatedBy($sessionBuffer){
    
    
    
}



function sort_Company_Name(SplDoublyLinkedList $sessionBuffer){
    
    
    if($sessionBuffer->isEmpty()){
        return $sessionBuffer;
    }
    $index = 0;
    $sortedObjects = 0;
    $sortedSessionBuffer = new SplDoublyLinkedList;
    
    if($sessionBuffer->count() > 1){
        
        do{
            
            //get first object
            $obj1 = unserialize($sessionBuffer->bottom());
            
            echo "new bottom {$obj1->getName()}";
            
            
            for ($sessionBuffer->rewind(); $sessionBuffer->valid(); $sessionBuffer->next()) {
                
                $obj2 = unserialize($sessionBuffer->current());
                
                if($obj1->getName() > $obj2->getName()){
                    
                    $obj1 = $obj2->get();
                    $index = $sessionBuffer->key();
                    
                }
                
            }
            
            $sortedSessionBuffer->unshift(serialize($obj2->get()));
            $sortedObjects++;
            
            $sessionBuffer->offsetUnset($index);
            
            
        }while($sortedObjects != $sessionBuffer->count());
        
    }
    else
    {
        
        return $sessionBuffer;
    }
    
    return $sortedSessionBuffer;
    
}





?>