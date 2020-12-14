<?php
/*
 * FileName: getDBConnection.php
 * Author: Jason Waid
 * Date Modified: 12/13/2020
 * Purpose: Returns a connection to the database
 */

/*
 * Function: getDBConnection
 * Author: Jason Waid
 * Date Modified: 12/4/2020
 * Purpose: Returns a connection to the database
 */
function getDBConnection()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nylene";
    $conn = mysqli_connect($host, $username, $password, $dbname);
    date_default_timezone_set('America/Toronto');
    return $conn;
}


/*
 * Function: getEncriptionKey
 * Author: Isha Isha
 * Date Modified: 12/13/2020
 * Purpose: Returns a key from a given txt file
 */
function getEncriptionKey(){
    
    //Path to the file containing the key
    $myFile = "../key.txt";
    $file = fopen($myFile, "r");
    
    if ($file) {
        while (! feof($file)) {
            $key = fgets($file);
        }
        
        fclose($file);
    }
    
    return $key;
}

?>