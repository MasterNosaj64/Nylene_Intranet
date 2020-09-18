<?php

/*
 Sets up the PDO database connection
 */
function setConnectionInfo() {
    
    
    $connString = "mysql:host=localhost;dbname=nylene";
    $user = "root";
    $password = "";
    
    $pdo = new PDO($connString,$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}


?>