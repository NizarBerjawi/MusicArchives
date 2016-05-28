<?php

$page_title = 'Manage Admin';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// An array containing all the error messages in JSON format
	$errorMessages = [];
	// An array containing all the success messages in JSON format
	$successMessages = [];

	// Need the database connection
	require('mysqli_connect.php');

	// Trim all the incoming data
	$trimmed = array_map('trim', $_POST);
	$username = mysqli_real_escape_string($dbc, $trimmed['u']);
	
	$q = "SELECT user_first_name, user_last_name, user_email, registration_date, user_level FROM registered_users WHERE username='" . $username . "'";
	$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
    $numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
    $outputArray = [];

	// Fetch the data from the database
    if ($numRows > 0) {
    	while ($row = mysqli_fetch_assoc($r)) {
    		$outputArray['fn'] = $row['user_first_name'];
    		$outputArray['ln'] = $row['user_last_name'];
    		$outputArray['e'] = $row['user_email'];
    		$outputArray['rd'] = $row['registration_date'];
    		$outputArray['ul'] = $row['user_level'];
    	}
    } else {
    	$outputArray['error'] = "<li>Username is not in the database</li>";
    }
    
    echo json_encode($outputArray);
} else { // Redirect
    	// Site URL (base for all redirections)
	define ('BASE_URL', 'http://music-archives.azurewebsites.net/');
	
        $url = BASE_URL . 'index.php'; // Define the URL.
        ob_end_clean(); // Delete the buffer
        header("Location: $url");
        exit(); // Quit the script
    }


    ?>