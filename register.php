<?php
/* Code inspired by "Chapter 18: Example - User Registration" in the book 	*/
/* PHP and MySQL for Dynamic Websites 4th Edition by Larry Ullman 			*/

// Registration for validation on the server side.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// An array containing all the error messages in JSON format
	$errorMessages = [];
	// An array containing all the success messages in JSON format
	$successMessages = [];

	// Need the database connection
	require('mysqli_connect.php');

	// Trim all the incoming data
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values
	$fn = $ln = $u = $e = $p = FALSE;

	$error = true;
	// Check the first name
	if (preg_match ('/^[a-zA-Z][a-zA-Z\-\'\s]{0,43}$/', $trimmed['fn'])) {
		$fn = mysqli_real_escape_string($dbc, $trimmed['fn']);
	} else {
		$errorMessages["fn"] = "<li>Enter a valid first name!</li>";
	}

	// Check the last name
	if (preg_match ('/^[a-zA-Z][a-zA-Z\-\'\s]{0,43}$/', $trimmed['ln'])) {
		$ln = mysqli_real_escape_string($dbc, $trimmed['ln']);
	} else {
		$errorMessages["ln"] = "<li>Enter a valid last name!</li>";
	}

	// Check for an email
	if (filter_var($trimmed['e'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($dbc, $trimmed['e']);
	} else {
		$errorMessages["e"] = "<li>Enter a valid email!</li>";
	}

	// Check the username
	if (preg_match ('/^[a-z][a-z0-9_\.]{0,24}$/i', $trimmed['u'])) {
		$u = mysqli_real_escape_string($dbc, $trimmed['u']);
	} else {
		$errorMessages["u"] = "<li>Enter a valid username!</li>";
	}

	// Check for a password and match against confirmed password
	if (preg_match ('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/', $trimmed['p1'])) {
		if($trimmed['p1'] == $trimmed['p2']) {
			$p = mysqli_real_escape_string($dbc, $trimmed['p1']);
		} else {
			$errorMessages["p2"] = "<li>Passwords don\'t match!</li>";
		}
	} else {
		$errorMessages["p1"] = "<li>Password is not valid!</li>";
	}
	
	if ($fn && $ln && $e && $u && $p) {	// If everything is OK
		$error = false;
		// Prepare the query and check if the email is not taken
		$q = "SELECT user_id FROM registered_users WHERE user_email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if(mysqli_num_rows($r) == 0) {	// the email is available for use.
			//Create the activation code
			$a = md5(uniqid(rand(), true));
			// A higher "cost" is more secure but consumes more processing power
			$cost = 10;

			// Create a random salt
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

			$salt = sprintf("$2a$%02d$", $cost) . $salt;

			// Hash the password with the salt
			$hash = crypt($p, $salt);

			// Add the user to the database
			$q = "INSERT INTO registered_users (user_first_name, user_last_name, username, password, salt, user_email, active, registration_date) VALUES ('$fn', '$ln', '$u', '$hash', '$salt', '$e', '$a', NOW())";
			$r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if(mysqli_affected_rows($dbc) == 1) { // If it ran OK.
				// Site URL (base for all redirections)
				define ('BASE_URL', 'http://music-archives.azurewebsites.net/');

				// Send an email.
				$body = "Thank you for registering at Music Archives. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['e'], 'Registration Confirmation', $body, 'From: admin@music-archives.com');

				// Success message
				$successMessages["success"] = "<p>Thank you for registering with Music Archives! A confirmation email has beed sent to your email address. Please click on the link in the email to activate your account.</p>";
			} else { // If it did not run OK
				$errorMessages["fail"] = "<li>You could not be registered due to a system error. We apologize for any inconvenience.</li>";
			}
		} else { // The email is not available
			$error = true;
			$errorMessages["emailTaken"] = "<li>That email address has already been registered.</li>";
		}
	} else { // If one of the data tests failed.
		$errorMessages["general"] = "<li>Please try Again.</li>";
	}

	if ($error) {
		echo json_encode($errorMessages);
	} else {
		echo json_encode($successMessages);
	}
	mysqli_close($dbc);
} // End of the main Submit conditional.

?>