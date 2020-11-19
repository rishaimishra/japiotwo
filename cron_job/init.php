<?php
    $teamDBServer = 'localhost';
    $teamUser = "root";
    $teamPass = "root";
    $teamPort = 3306;
    
    $appServer = "localhost";
    $appUser = "root";
    $appPassword = "root";
    $appDbname = "japio";

    // Create connection
    $appConn = new mysqli($appServer, $appUser, $appPassword, $appDbname);
    // Check connection
    if ($appConn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else{
        //echo "yes";
        
    }

?>