<?php

$page_title = 'Update Admin';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// An array containing all the error messages in JSON format
	$errorMessages = [];
	// An array containing all the success messages in JSON format
	$successMessages = [];

	$error = true;
	// Need the database connection
	require('mysqli_connect.php');

	// Trim all the incoming data
	$trimmed = array_map('trim', $_POST);
	$checked = mysqli_real_escape_string($dbc, $trimmed['c']);
	$username = mysqli_real_escape_string($dbc, $trimmed['u']);
	
	if (strcmp("true", $checked) == 0 ) {
		$checked = '1';
	} else {
		$checked = '0';
	}

	$q = "UPDATE registered_users SET user_level='" . $checked . "' WHERE username ='" . $username . "'";;
	$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	$affected = mysqli_affected_rows($dbc);
	
    if($affected == 1) { // If it ran OK.
    	$error = false;
        // Success message
    	$successMessages["success"] = "<li>The user level was updated successfully.</li>";
	} else { // If it did not run OK
		$errorMessages["fail"] = "<li>You didn't make any changes!</li>";
	}
	
	if ($error) {
		echo json_encode($errorMessages);
	} else {
		echo json_encode($successMessages);
	}
	mysqli_close($dbc);
} else { // Redirect
    	// Site URL (base for all redirections)
	define ('BASE_URL', 'http://music-archives.azurewebsites.net/');
	
        $url = BASE_URL . 'index.php'; // Define the URL.
        ob_end_clean(); // Delete the buffer
        header("Location: $url");
        exit(); // Quit the script
    }


    ?>