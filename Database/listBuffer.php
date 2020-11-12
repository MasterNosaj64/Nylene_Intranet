<?php

/*
 * FileName: listBuffer.php
 * Version Number: 1.5
 * Date Modified: 11/11/2020
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

        $customer->searchById($cx['customer_id']);
        // $customerData->fetch();

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

/*
 * function: sortASC_DateCreated
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_DateCreated(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if ($obj1->getDateCreated() > $obj2->getDateCreated()) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    return $sessionBuffer;
}

/*
 * function: sortASC_Interactions_Customer
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Interactions_Customer($sessionBuffer)
{
    $dbConnection = getDBConnection();

    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $dbConnection = getDBConnection();
            $customer1 = new Customer($dbConnection);

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $customer1->searchById($obj1->getCustomerId());
            $dbConnection->close();

            $dbConnection = getDBConnection();
            $customer2 = new Customer($dbConnection);

            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            $customer2->searchById($obj2->getCustomerId());
            $dbConnection->close();

            if (strcmp(strtolower($customer1->getName()), strtolower($customer2->getName())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    return $sessionBuffer;
}

/*
 * function: sortASC_Interactions_Reason
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Interactions_Reason($sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getReason()), strtolower($obj2->getReason())) > 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    return $sessionBuffer;
}

/*
 * function: sortASC_Interactions_Notes
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Interactions_Notes($sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getComments()), strtolower($obj2->getComments())) > 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    return $sessionBuffer;
}

/*
 * function: sortASC_CreatedBy
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_CreatedBy($sessionBuffer)
{
    $dbConnection = getDBConnection();

    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $dbConnection = getDBConnection();
            $employee1 = new Employee($dbConnection);

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $employee1->searchById($obj1->getCreatedBy());
            $dbConnection->close();

            $dbConnection = getDBConnection();
            $employee2 = new Employee($dbConnection);

            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            $employee2->searchById($obj2->getCreatedBy());
            $dbConnection->close();

            if (strcmp(strtolower($employee1->getName()), strtolower($employee2->getName())) > 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    return $sessionBuffer;
}

/*
 * function: sortASC_Name
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Name(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getName()), strtolower($obj2->getName())) > 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    return $sessionBuffer;
}


/*
 * function: sortASC_Phone
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_CustomerPhone(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getPhone()), strtolower($obj2->getPhone())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

/*
 * function: sortASC_Fax
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_CustomerFax(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getFax()), strtolower($obj2->getFax())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}



/*
 * function: sortASC_Email
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Email(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getEmail()), strtolower($obj2->getEmail())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

/*
 * function: sortASC_Street
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Street(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower(preg_replace('/[0-9]+/', '', $obj1->getBillingAddressStreet())), strtolower(preg_replace('/[0-9]+/', '', $obj2->getBillingAddressStreet()))) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

/*
 * function: sortASC_City
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_City(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getBillingAddressCity()), strtolower($obj2->getBillingAddressCity())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

/*
 * function: sortASC_State
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_State(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getBillingAddressState()), strtolower($obj2->getBillingAddressState())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

/*
 * function: sortASC_Website
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Website(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getWebsite()), strtolower($obj2->getWebsite())) > 0) {
                
                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }
    
    return $sessionBuffer;
}

?>