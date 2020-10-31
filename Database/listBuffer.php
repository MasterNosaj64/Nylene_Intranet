<?php

// test file for doubly linked list logic

/*
 * Creates a buffer of objects
 * Used for containing a list and navigation of objects in list
 * Object expected are: Company, Customer, Employee & Interaction
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
    //$buffer->serialize();

    // store buffer into session
    $_SESSION['buffer'] = $buffer;

    // Set the initial offset
    $_SESSION['offset'] = 0;

    // prepare buffer for printing after sotred into session
    //$buffer->unserialize($buffer);

    return $buffer;
}

/*
 * navigates list to next 10
 */
function next10($sessionBuffer)
{
    //$buffer = unserialize($sessionBuffer);
    $buffer = $sessionBuffer;
    $counter = 0;
    
    for($buffer->rewind(); $buffer->valid(); $buffer->next()){
        
        if($counter == $_SESSION['offset']){
            break;
        }
        
        $counter++;
        
    }
    
    return $buffer;
    
}

/*
 * navigates list to previous 10
 */
function previous10($sessionBuffer)
{
    
    //$buffer = unserialize($sessionBuffer);
    $buffer = $sessionBuffer;
    $counter = 0;
    
    for($buffer->rewind(); $buffer->valid(); $buffer->next()){
        
        if($counter == $_SESSION['offset']){
            break;
        }
        
        $counter++;
        
    }
    
    return $buffer;
    
    
}

?>