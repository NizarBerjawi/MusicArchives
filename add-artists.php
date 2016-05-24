<?php

// Add/update Artist validation.
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
	$a = $c = $y = $g = FALSE;

	$error = true;
	// Artist name can be any character and can have numbers
	$a = mysqli_real_escape_string($dbc, $trimmed['a']);

	// Check the country name
	if (preg_match ('/^[a-zA-Z][a-zA-Z\-\'\s]{0,43}$/', $trimmed['c'])) {
		$c = mysqli_real_escape_string($dbc, $trimmed['c']);
	} else {
		$errorMessages["c"] = "<li>Enter a valid country!</li>";
	}
	
	// Check the genre 
	if (preg_match ('/^[a-zA-Z][a-zA-Z\-\'\s]{0,43}$/', $trimmed['g'])) {
		$g = mysqli_real_escape_string($dbc, $trimmed['g']);
	} else {
		$errorMessages["g"] = "<li>Enter a valid genre!</li>";
	}
	
    // Check the year
	if (empty($trimmed['y']) || !is_numeric($trimmed['y']) || (floatval($trimmed['y']) > date("Y")) || (floatval($trimmed['y']) % 1 != 0)) {
		$errorMessages["y"] = "<li>Enter a valid year!</li>";
	} else {
		$y = mysqli_real_escape_string($dbc, $trimmed['y']);
	}
	
	if ($a && $c && $y && $g) {	// If everything is OK
		$error = false;
		// Prepare the query to check if the genre is already in the database
		$genreQuery = "SELECT genre_id FROM genres WHERE genre = '$g'";
		$r1 = mysqli_query ($dbc, $genreQuery) or trigger_error("Query: $genreQuery\n<br />MySQL Error: " . mysqli_error($dbc));
		// Prepare the query to check if the artist is already in the database
		$nameQuery = "SELECT artist_id FROM artists WHERE artist_name = '$a'";
		$r2 = mysqli_query ($dbc, $nameQuery) or trigger_error("Query: $nameQuery\n<br />MySQL Error: " . mysqli_error($dbc));

		if(mysqli_num_rows($r1) == 0 && mysqli_num_rows($r2) == 0) {	// the artist and genre are not in the database
            // Add the new genre the database
			$genreQuery = "INSERT INTO genres (genre) VALUES ('$g')";
			$r1 = mysqli_query($dbc, $genreQuery) or trigger_error("Query: $genreQuery\n<br />MySQL Error: " . mysqli_error($dbc));
			$id = mysqli_insert_id($dbc); // The id of the genre just added
			$affected = mysqli_affected_rows($dbc);
			
			// Add the artist to the database with the new genre id
			$q = "INSERT INTO artists (artist_name, country, year, genre_id) VALUES ('$a', '$c', '$y', '$id')";
			$r2 = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
            // The number of affected rows from the previous 2 INSERTs. It should always be 2.
			$affected = $affected + mysqli_affected_rows($dbc);
			
			if($affected == 2) { // If it ran OK.
				// Success message
				$successMessages["success"] = "<li>Artist and genre have been added.</li>";
			} else { // If it did not run OK
				$errorMessages["fail"] = "<li>The artist could not be added. Please try again later.</li>";
			}
		} else if (mysqli_num_rows($r1) > 0 && mysqli_num_rows($r2) == 0) { // genre is in the database and artist is not
		    // get the genre_id
			$row = mysqli_fetch_assoc($r1);
			$id = $row['genre_id'];
            // Add the artist to the database with the genre id
			$q = "INSERT INTO artists (artist_name, country, year, genre_id) VALUES ('$a', '$c', '$y', '$id')";
			$r2 = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK
			    // Success message
				$successMessages["success"] = "<li>Artist has been added.</li>";
			} else { // If it did not run OK
				$errorMessages["fail"] = "<li>The artist could not be added. Please try again later.</li>";
			}
		} else {
			$error = true;
			$errorMessages["fail"] = "<li>That artist is already in the database. You can update in the update tab.</li>";
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