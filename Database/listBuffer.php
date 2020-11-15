<?php

/*
 * FileName: listBuffer.php
 * Version Number: 2.0
 * Date Modified: 11/15/2020
 * Author: Jason Waid
 * Purpose:
 * Provide pages a list of objects and alow the user to navigate/sort the list
 * refered to as the list buffer
 * 
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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_DateCreated
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_DateCreated(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if ($obj1->getDateCreated() < $obj2->getDateCreated()) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Interactions_Customer
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Interactions_Customer($sessionBuffer)
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

            if (strcmp(strtolower($customer1->getName()), strtolower($customer2->getName())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Interactions_Reason
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Interactions_Reason($sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getReason()), strtolower($obj2->getReason())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortASC_Interactions_Notes
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Interactions_Notes($sessionBuffer)
{
    $n = $sessionBuffer->count();

    $sortedItems = 0;

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getComments()), strtolower($obj2->getComments())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_CreatedBy
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_CreatedBy($sessionBuffer)
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

            if (strcmp(strtolower($employee1->getName()), strtolower($employee2->getName())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
                $sortedItems ++;
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Name
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Name(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getName()), strtolower($obj2->getName())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_CustomerPhone
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_CustomerPhone(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getPhone()), strtolower($obj2->getPhone())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_CustomerFax
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_CustomerFax(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getFax()), strtolower($obj2->getFax())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Email
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Email(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getEmail()), strtolower($obj2->getEmail())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Street
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Street(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower(preg_replace('/[0-9]+/', '', $obj1->getBillingAddressStreet())), strtolower(preg_replace('/[0-9]+/', '', $obj2->getBillingAddressStreet()))) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_City
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_City(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getBillingAddressCity()), strtolower($obj2->getBillingAddressCity())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_State
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_State(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getBillingAddressState()), strtolower($obj2->getBillingAddressState())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

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

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: sortDESC_Website
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Website(SplDoublyLinkedList $sessionBuffer)
{
    $n = $sessionBuffer->count();

    for ($i = 0; $i < $n; $i ++) {

        for ($j = 0; $j < $n - $i - 1; $j ++) {

            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));

            if (strcmp(strtolower($obj1->getWebsite()), strtolower($obj2->getWebsite())) < 0) {

                $sessionBuffer->offsetSet($j, serialize($obj2));
                $sessionBuffer->offsetSet($j + 1, serialize($obj1));
            }
        }
    }

    $sessionBuffer->rewind();

    return $sessionBuffer;
}

/*
 * function: getSortingCompany
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function getSortingCompany(SplDoublyLinkedList $sessionBuffer)
{
    if (isset($_GET['sort'])) {

        $sortPreference = $_GET['sort'];

        $_SESSION['offset'] = 0;
        
        switch ($sortPreference) {

            case '-1':

                return sortDESC_Name($sessionBuffer);
                break;

            case '1':

                return sortASC_Name($sessionBuffer);
                break;

            case '-2':

                return sortDESC_Website($sessionBuffer);
                break;

            case '2':

                return sortASC_Website($sessionBuffer);
                break;

            case '-3':

                return sortDESC_Email($sessionBuffer);
                break;

            case '3':

                return sortASC_Email($sessionBuffer);
                break;

            case '-4':

                return sortDESC_Street($sessionBuffer);
                break;

            case '4':

                return sortASC_Street($sessionBuffer);
                break;

            case '-5':

                return sortDESC_City($sessionBuffer);
                break;

            case '5':

                return sortASC_City($sessionBuffer);
                break;

            case '-6':

                return sortDESC_State($sessionBuffer);
                break;

            case '6':

                return sortASC_State($sessionBuffer);
                break;

            case '-7':
            case '7':
            case '-8':
            case '8':
                return sortASC_CreatedBy($sessionBuffer);
                break;

            default:
                // unknown sorting preference
                return $sessionBuffer;
        }
    } else {
        // no sorting preference
        return $sessionBuffer;
    }
}

/*
 * function: printHeadersCompany
 * Param: $sortType
 * Param Type: Int
 * Return Type: n/a
 */
function printHeadersCompany(int $sortType)
{
    switch ($sortType) {

        case '-1':

            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='1'>&#8681   Name   &#8681</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '1':

            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-1'>&#8679   Name   &#8679</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-2':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='2'>&#8681   Website   &#8681</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '2':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-2'>&#8679   Website   &#8679</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-3':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='3'>&#8681   Email   &#8681</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '3':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-3'>&#8679   Email   &#8679</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-4':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='4'>&#8681   Street   &#8681</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '4':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-4'>&#8679   Street   &#8679</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-5':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='5'>&#8681   City   &#8681</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '5':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-5'>&#8679   City   &#8679</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-6':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='6'>&#8681   State   &#8681</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '6':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-6'>&#8679   State   &#8679</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-7':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='7'>&#8681   Assigned To   &#8681</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '7':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-7'>&#8679   Assigned To   &#8679</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }
            
            break;

        case '-8':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='8'>";
                echo "&#8681   Created By   &#8681";
                echo "</td>";
            }
            
            
            break;

        case '8':

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-8'>";
                echo "&#8679   Created By   &#8679";
                echo "</td>";
            }
            
            
            break;

        default:

            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Website</td>";
            echo "<td class='ColSort' data-colnum='3'>Email</td>";
            echo "<td class='ColSort' data-colnum='4'>Street</td>";
            echo "<td class='ColSort' data-colnum='5'>City</td>";
            echo "<td class='ColSort' data-colnum='6'>State</td>";
            echo "<td class='ColSort' data-colnum='7'>Assigned To</td>";
            
            // &#8679 = ASC || &#8681 = DESC
            if ($_SESSION["role"] == "admin") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }

            break;
    }
        
    echo "<td>Menu</td>";
}

?>