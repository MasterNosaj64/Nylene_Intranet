<?php
include_once 'database/Company.php';

// test file for doubly linked list logic

/*
 * Creates a buffer of objects
 * Used for containing a list and navigation of objects in list
 */
function create_Buffer($queryResult, Company $object)
{
    // pass the query result into the function and it will create a node for every row
    $buffer = new SplDoublyLinkedList();
    $i = 0;
    // adds all objects to the list
    while ($queryResult->fetch()) {
        
        //Serialize the current object to prepare it for storage
        //Then store it into the linked list
        $buffer->push(serialize($object->get()));
    }

    // rewinds cursor to begining of list
    $buffer->rewind();

    return $buffer;
}

/*
 * navigates list to next 10
 */
function next10()
{}

/*
 * navigates list to previous 10
 */
function previous10()
{}

?>