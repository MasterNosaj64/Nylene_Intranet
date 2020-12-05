<?php

/*
 * FileName: listBuffer.php
 * Version Number: 2.1
 * Date Modified: 12/04/2020
 * Author: Jason Waid(later madified by Madhav Sachdeva)
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
function create_Buffer($queryResult, $object )
{
    // pass the query result into the function and it will create a node for every row
    $buffer = new SplDoublyLinkedList();

    // set iteration
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);

	// set iteration behavior
    $buffer->setIteratorMode(SplDoublyLinkedList::IT_MODE_KEEP);


	$conn_Employee = getDBConnection();
	$employeeObj = new Employee($conn_Employee);
	
    // adds all objects to the list
    while ($queryResult->fetch()) {

		if ($_SESSION['role'] == 'admin') {//if signed in as admin
        // Serialize the current object to prepare it for storage
        // Then store it into the linked list
			$buffer->push(serialize($object->get()));
		}
		else if($_SESSION['role'] == 'supervisor'){//if signed in as supervisor
			$assignedTo=$object->getAssignedTo();
			$employee = $employeeObj->searchByID($assignedTo );
			
			
			if($assignedTo==$_SESSION['userid']){//show its own company
				$buffer->push(serialize($object->get()));
			}
			else if($employee->getReports_To()==$_SESSION['userid']){// show the companies assigned to the employee who reports to the user
				$buffer->push(serialize($object->get()));
			}
		}	
		else if($_SESSION['role'] == 'sales_rep'){//if signed in as sales rep
			$employee= $employeeObj->searchByID($_SESSION['userid']);// search the employee that is logged in at the moment
			$managerID = $employee->getReports_To(); //get the id the current employee reports to

			$assignedTo = $object->getAssignedTo();//get assigned employee id  of a company
			$employee = $employeeObj->searchByID($assignedTo); //get the employee data from assigned to as employee data
			if(($employee->getReports_To())==$managerID){ //see if the employee reports to same supervisor the user reports_to
				$buffer->push(serialize($object->get()));				
			}
		}	
		else if($_SESSION['role'] == 'ind_rep'){//if signed in as independent
			$assignedTo = $object->getAssignedTo();
			if($assignedTo == $_SESSION['userid']){//only show the company that is assigned to the user
				$buffer->push(serialize($object->get()));
			}
		}	
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
 * Function: nextBufferPage
 * Purpose:
 * navigates a list of companies and moved the iterator to the next 10 or closest existing index
 * returns the list
 */
function nextBufferPage(SplDoublyLinkedList $sessionBuffer)
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
 * Function: previousBufferPage
 * Purpose:
 * navigates a list of companies and moved the iterator to the previous 10 or closest existing index
 * returns the list
 */
function previousBufferPage(SplDoublyLinkedList $sessionBuffer)
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
 * Purpose: Sorts a given buffer by DateCreated in Ascending Order
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
 * function: sortDESC_DateCreated
 * Purpose: Sorts a given buffer by DateCreated in Descending Order
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
 * function: sortASC_Interactions_Customer
 * Purpose: Sorts a given interaction buffer by Customer in Ascending Order
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
 * Purpose: Sorts a given interaction buffer by Customer in Descending Order
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
 * Purpose: Sorts a given interaction buffer by Reason in Ascending Order
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
 * Purpose: Sorts a given interaction buffer by Reason in Descending Order
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
 * Purpose: Sorts a given interaction buffer by Notes in Ascending Order
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
 * function: sortDESC_Interactions_Notes
 * Purpose: Sorts a given interaction buffer by Notes in Descending Order
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
 * function: sortASC_Interactions_Status
 * Purpose: Sorts a given interaction buffer by Status in Ascending Order
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortASC_Interactions_Status($sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    $sortedItems = 0;
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getStatus()), strtolower($obj2->getStatus())) > 0) {
                
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
 * function: sortDESC_Interactions_Status
 * Purpose: Sorts a given interaction buffer by Status in Descending Order
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function sortDESC_Interactions_Status($sessionBuffer)
{
    $n = $sessionBuffer->count();
    
    $sortedItems = 0;
    
    for ($i = 0; $i < $n; $i ++) {
        
        for ($j = 0; $j < $n - $i - 1; $j ++) {
            
            $obj1 = unserialize($sessionBuffer->offsetGet($j));
            $obj2 = unserialize($sessionBuffer->offsetGet($j + 1));
            
            if (strcmp(strtolower($obj1->getStatus()), strtolower($obj2->getStatus())) < 0) {
                
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
 * Purpose: Sorts a given buffer by CreatedBy in Ascending Order
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
 * Purpose: Sorts a given buffer by CreatedBy in Descending Order
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
 * Purpose: Sorts a given buffer by Name in Ascending Order
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
 * Purpose: Sorts a given buffer by Name in Descending Order
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
 * function: sortASC_CustomerPhone
 * Purpose: Sorts a given customer buffer by phone in Ascending Order
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
 * Purpose: Sorts a given customer buffer by phone in Descending Order
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
 * function: sortASC_CustomerFax
 * Purpose: Sorts a given customer buffer by fax in Ascending Order
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
 * Purpose: Sorts a given customer buffer by fax in Descending Order
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
 * Purpose: Sorts a given buffer by email in Ascending Order
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
 * Purpose: Sorts a given buffer by email in Descending Order
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
 * Purpose: Sorts a given company buffer by street in Ascending Order
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
 * Purpose: Sorts a given company buffer by street in Descending Order
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
 * Purpose: Sorts a given company buffer by city in Ascending Order
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
 * Purpose: Sorts a given company buffer by city in Descending Order
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
 * Purpose: Sorts a given company buffer by state in Ascending Order
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
 * Purpose: Sorts a given company buffer by state in Descending Order
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
 * Purpose: Sorts a given company buffer by website in Ascending Order
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
 * Purpose: Sorts a given company buffer by website in Descending Order
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
 * Purpose: Get's the sorting preference for the company buffer
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
 * Purpose: Prints the table headers for the company table
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
            if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"|| $_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
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
            if ($_SESSION["role"] == "admin"||$_SESSION["role"] == "supervisor") {
                echo "<td class='ColSort' data-colnum='8'>";
                echo "Created By";
                echo "</td>";
            }

            break;
    }
        
    echo "<td>Menu</td>";
}

/*
 * function: getSortingCustomer
 * Purpose: Gets the sorting preference for the customer buffer
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function getSortingCustomer(SplDoublyLinkedList $sessionBuffer)
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
                
                return sortDESC_Email($sessionBuffer);
                break;
                
            case '2':
                
                return sortASC_Email($sessionBuffer);
                break;
                
            case '-3':
                
                return sortDESC_CustomerPhone($sessionBuffer);
                break;
                
            case '3':
                
                return sortASC_CustomerPhone($sessionBuffer);
                break;
                
            case '-4':
                
                return sortDESC_CustomerFax($sessionBuffer);
                break;
                
            case '4':
                
                return sortASC_CustomerFax($sessionBuffer);
                break;
                
            case '-5':
                
                return sortDESC_DateCreated($sessionBuffer);
                break;
                
            case '5':
                
                return sortASC_DateCreated($sessionBuffer);
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
 * function: printHeadersCustomer
 * Purpose: Prints the table headers for the customer buffer
 * Param: $sortType
 * Param Type: Int
 * Return Type: n/a
 */
function printHeadersCustomer(int $sortType)
{
    switch ($sortType) {
        
        case '-1':
            
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='1'>&#8681   Name   &#8681</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '1':
            
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-1'>&#8679   Name   &#8679</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
         
            break;
            
        case '-2':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='2'>&#8681   Email   &#8681</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '2':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-2'>&#8679   Email   &#8679</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '-3':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='3'>&#8681   Phone   &#8681</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
             
            break;
            
        case '3':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-3'>&#8679   Phone   &#8679</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '-4':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='4'>&#8681   Fax   &#8681</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '4':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-4'>&#8679   Fax   &#8679</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
            
        case '-5':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='5'>&#8681   Date Created   &#8681</td>";
            
            break;
            
        case '5':
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-5'>&#8679   Date Created   &#8679</td>";
            
            break;
              
        default:
            
            echo "<td class='ColSort' data-colnum='1'>Name</td>";
            echo "<td class='ColSort' data-colnum='2'>Email</td>";
            echo "<td class='ColSort' data-colnum='3'>Phone</td>";
            echo "<td class='ColSort' data-colnum='4'>Fax</td>";
            echo "<td class='ColSort' data-colnum='5'>Date Created</td>";
            
            break;
    }
    
    echo "<td>Menu</td>";
}


/*
 * function: getSortingInteraction
 * Purpose: Gets the sorting preference for the Interaction buffer
 * Param: sessionBuffer
 * Param Type: SplDoublyLinkedList
 * Return Type: SplDoublyLinkedList
 */
function getSortingInteraction(SplDoublyLinkedList $sessionBuffer)
{
    if (isset($_GET['sort'])) {
        
        $sortPreference = $_GET['sort'];
        
        $_SESSION['offset'] = 0;
        
        switch ($sortPreference) {
            
            case '-1':
                
                return sortDESC_DateCreated($sessionBuffer);
                break;
                
            case '1':
                
                return sortASC_DateCreated($sessionBuffer);
                break;
                
            case '-2':
                
                return sortDESC_Interactions_Customer($sessionBuffer);
                break;
                
            case '2':
                
                return sortASC_Interactions_Customer($sessionBuffer);
                break;
                
            case '-3':
                
                return sortDESC_Interactions_Reason($sessionBuffer);
                break;
                
            case '3':
                
                return sortASC_Interactions_Reason($sessionBuffer);
                break;
                
            case '-4':
                
                return sortDESC_Interactions_Notes($sessionBuffer);
                break;
                
            case '4':
                
                return sortASC_Interactions_Notes($sessionBuffer);
                break;
            
            case '-5':
                
                return sortDESC_Interactions_Status($sessionBuffer);
                break;
                
            case '5':
                
                return sortASC_Interactions_Status($sessionBuffer);
                break;
                
            case '-6':
                
                return sortDESC_CreatedBy($sessionBuffer);
                break;
                
            case '6':
                
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
 * function: printHeadersInteraction
 * Purpose: Prints the table headers for the interaction table
 * Param: $sortType
 * Param Type: Int
 * Return Type: n/a
 */
function printHeadersInteraction(int $sortType)
{
    switch ($sortType) {
        
        case '-1':
            
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='1'>&#8681   Date   &#8681</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '1':
            
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-1'>&#8679   Date   &#8679</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '-2':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='2'>&#8681   Customer   &#8681</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '2':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-2'>&#8679   Customer   &#8679</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '-3':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='3'>&#8681   Reason   &#8681</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '3':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-3'>&#8679   Reason   &#8679</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '-4':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='4'>&#8681   Notes   &#8681</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '4':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-4'>&#8679   Notes   &#8679</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
        
        case '-5':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='5'>&#8681   Status   &#8681</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
        case '5':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-5'>&#8679   Status   &#8679</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
            
            
        case '-6':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='6'>&#8681   Author   &#8681</td>";
            
            break;
            
        case '6':
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td bgcolor='#D3D3D3' style='color:black' class='ColSort' data-colnum='-6'>&#8679   Author   &#8679</td>";
            
            break;
            
        default:
            
            echo "<td class='ColSort' data-colnum='1'>Date</td>";
            echo "<td class='ColSort' data-colnum='2'>Customer</td>";
            echo "<td class='ColSort' data-colnum='3'>Reason</td>";
            echo "<td class='ColSort' data-colnum='4'>Notes</td>";
            echo "<td class='ColSort' data-colnum='5'>Status</td>";
            echo "<td class='ColSort' data-colnum='6'>Author</td>";
            
            break;
    }
    
    echo "<td>Menu</td>";
}
?>