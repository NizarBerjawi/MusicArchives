<?php 
    // A simple PHP script to connect to the Database on the Azure
    $servername = 'au-cdbr-azure-east-a.cloudapp.net:3306';      // the hostname
    $username = 'b6ba47aa5c90aa';           // the username
    $password = '848e3fe6'; // database password
    $database = 'music_archives';   // database name
    $port = 3306; 


    // A simple PHP script to connect to the Database on the zone
/*    $servername = 'localhost';      // the hostname
    $username = 'user12';           // the username
    $password = 'EbWZnwsrBtmYz9zM'; // database password
    $database = 'music-archives';   // database name
    $port = 3306; */


    // A simple PHP script to connect to the Cloud9 MySQL Database
/*    $servername = '127.0.0.1';      // the hostname
    $username = 'nizar12';          // the username
    $password = '';                 // database password
    $database = 'music_archives';   // database name
    $port = 3306;                   // The port number. Always 3306.*/

    // Create connection
    $dbc = new mysqli($servername, $username, $password, $database, $port);
    
    // Check connection
    if ($dbc->connect_error) {
        die("Connection failed: " . $dbc->connect_error);
    }
    ?>



    