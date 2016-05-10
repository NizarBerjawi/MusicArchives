<?php 
/*    // A simple PHP script to connect to the Forum Database
    $servername = 'localhost';     // the hostname
    $username = 'nizar12';  // the username
    $password = 'admin12345';                 // database password
    $database = 'music_archives';            // database name*/
    
    // TESTING PURPOSES ONLY
    // A simple PHP script to connect to the Forum Database
    $servername = 'localhost';     // the hostname
    $username = 'root';  // the username
    $password = '';                 // database password
    $database = 'music_archives';            // database name

    // Create connection
    $dbc = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($dbc->connect_error) {
        die("Connection failed: " . $dbc->connect_error);
    }
    
    // Set the encoding
    mysqli_set_charset($dbc, 'utf8');
    ?>