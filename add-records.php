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
	$a = $t = $r = $g = $l = FALSE;

	$error = true;
	// Artist name, record title, and label can be any character including numbers
	if (!empty($trimmed['a']) && strcmp($trimmed['a'], "-- Select --") !== 0) {
        $a = mysqli_real_escape_string($dbc, $trimmed['a']);
    } else {
       $errorMessages['a'] = "<li>Please select an artist!</li>";
   }
   
   if (!empty($trimmed['t'])) {
    $t = mysqli_real_escape_string($dbc, $trimmed['t']);
} else {
   $errorMessages['t'] = "<li>Enter a valid record title!</li>";
}

if (!empty($trimmed['l'])) {
    $l = mysqli_real_escape_string($dbc, $trimmed['l']);
} else {
   $errorMessages['l'] = "<li>Enter a valid label!</li>";
}

	// Check the genre 
if (preg_match ('/^[a-zA-Z][a-zA-Z\-\'\s]{0,43}$/', $trimmed['g'])) {
  $g = mysqli_real_escape_string($dbc, $trimmed['g']);
} else {
  $errorMessages["g"] = "<li>Enter a valid genre!</li>";
}

    // Check the release date 
if (preg_match ('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $trimmed['r'])) {
   $time = strtotime($trimmed['r']);
   $date = date('Y-m-d',$time);
   
   $time = date_create_from_format("d/m/Y", $trimmed['r']);
   $date = $time->format('Y-m-d');


   if ( checkdate (date('m', $date), date('d', $date) ,date('Y', $date)) ){
    $r = mysqli_real_escape_string($dbc, $date);
} else {
    $errorMessages["r"] = "<li>Enter a valid release date!</li>";
}
} else {
  $errorMessages["r"] = "<li>Enter a valid release date!</li>";
}

	if ($a && $t && $l && $g && $r) {	// If everything is OK
		$error = false;
		// Prepare the query to check if the genre is already in the database
		$genreQuery = "SELECT genre_id FROM genres WHERE genre = '$g'";
		$r1 = mysqli_query ($dbc, $genreQuery) or trigger_error("Query: $genreQuery\n<br />MySQL Error: " . mysqli_error($dbc));
		// Prepare the query to check if the label is already in the database
		$labelQuery = "SELECT label_id FROM labels WHERE label_name = '$l'";
		$r2 = mysqli_query ($dbc, $labelQuery) or trigger_error("Query: $labelQuery\n<br />MySQL Error: " . mysqli_error($dbc));
        // Prepare the query to check if the artist is in the database
        $artistQuery = "SELECT artist_id FROM artists WHERE artist_name = '$a'";
        $r3 = mysqli_query ($dbc, $artistQuery) or trigger_error("Query: $artistQuery\n<br />MySQL Error: " . mysqli_error($dbc));
		// Prepare the query to check if the record is already in the databasee
        $recordQuery = "SELECT record_id FROM records WHERE record_title = '$t'";
        $r4 = mysqli_query ($dbc, $recordQuery) or trigger_error("Query: $recordQuery\n<br />MySQL Error: " . mysqli_error($dbc));		
        
        // Check if the record is already in the database
        if (mysqli_num_rows($r4) == 0) {
            // Check if the selected artist is still in the database
            if (mysqli_num_rows($r3) > 0) {
                // get the artist id
                $row = mysqli_fetch_assoc($r3);
                $artistID = $row['artist_id'];
                
                
        		if(mysqli_num_rows($r1) == 0 && mysqli_num_rows($r2) == 0) { // the genre and the label are not in the database
                    // Add the new genre the database
                    $genreQuery = "INSERT INTO genres (genre) VALUES ('$g')";
                    $r1 = mysqli_query($dbc, $genreQuery) or trigger_error("Query: $genreQuery\n<br />MySQL Error: " . mysqli_error($dbc));
        			$genreID = mysqli_insert_id($dbc); // The id of the genre just added
        			$affected1 = mysqli_affected_rows($dbc);
        			
        			// Add the label to the database
        			$labelQuery = "INSERT INTO labels (label_name) VALUES ('$l')";
        			$r2 = mysqli_query($dbc, $labelQuery) or trigger_error("Query: $labelQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                    $labelID = mysqli_insert_id($dbc); // The id of the label just added
                    $affected2 = mysqli_affected_rows($dbc);
                    // Add the record details to the database
                    $recordQuery = "INSERT INTO records (record_title, release_date, genre_id, artist_id, label_id) VALUES ('$t', '$r', '$genreID', '$artistID', '$labelID')";
                    $r3 = mysqli_query($dbc, $recordQuery) or trigger_error("Query: $recordQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                    $affected3 = mysqli_affected_rows($dbc);
                    
                    // The number of affected rows from the previous 3 INSERTs. It should always be 3.
                    $affected = $affected1 + $affected2 + $affected3;
                    
        			if($affected == 3) { // If it ran OK.
        				// Success message
        				$successMessages["success"] = "<li>The record, genre, and label were added successfully.</li>";
        			} else { // If it did not run OK
        				$errorMessages["fail"] = "<li>The record could not be added. Please try again later.</li>";
        			}
        		} else if (mysqli_num_rows($r1) > 0 && mysqli_num_rows($r2) == 0) { // genre is in the database, label is not
        		    // get the genre_id
                   $row = mysqli_fetch_assoc($r1);
                   $genreID = $row['genre_id'];
                   
                    // Add the label to the database
                   $labelQuery = "INSERT INTO labels (label_name) VALUES ('$l')";
                   $r1 = mysqli_query($dbc, $labelQuery) or trigger_error("Query: $labelQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                    $labelID = mysqli_insert_id($dbc); // The id of the label just added
                    $affected1 = mysqli_affected_rows($dbc);
                    
                    // Add the record details to the database
                    $recordQuery = "INSERT INTO records (record_title, release_date, genre_id, artist_id, label_id) VALUES ('$t', '$r', '$genreID', '$artistID', '$labelID')";
                    $r2 = mysqli_query($dbc, $recordQuery) or trigger_error("Query: $recordQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                    $affected2 = mysqli_affected_rows($dbc);
                    
                    // The number of affected rows from the previous 2 INSERTs. It should always be 2.
                    $affected = $affected1 + $affected2;
                    
        			if($affected == 2) { // If it ran OK.
        				// Success message
        				$successMessages["success"] = "<li>The record and label were added successfully.</li>";
        			} else { // If it did not run OK
        				$errorMessages["fail"] = "<li>The record could not be added. Please try again later.</li>";
        			}
        	    } else if (mysqli_num_rows($r1) == 0 && mysqli_num_rows($r2) > 0) { // genre is not in the database, label is
                    // get the label_id
                   $row = mysqli_fetch_assoc($r2);
                   $labelID = $row['label_id'];
                   
                    // Add the new genre the database
                   $genreQuery = "INSERT INTO genres (genre) VALUES ('$g')";
                   $r1 = mysqli_query($dbc, $genreQuery) or trigger_error("Query: $genreQuery\n<br />MySQL Error: " . mysqli_error($dbc));
        			$genreID = mysqli_insert_id($dbc); // The id of the genre just added
        			$affected1 = mysqli_affected_rows($dbc);
                    
        	        // Add the record details to the database
                    $recordQuery = "INSERT INTO records (record_title, release_date, genre_id, artist_id, label_id) VALUES ('$t', '$r', '$genreID', '$artistID', '$labelID')";
                    $r2 = mysqli_query($dbc, $recordQuery) or trigger_error("Query: $recordQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                    $affected2 = mysqli_affected_rows($dbc);
                    
                    // The number of affected rows from the previous 2 INSERTs. It should always be 2.
                    $affected = $affected1 + $affected2;
                    
        			if($affected == 2) { // If it ran OK.
        				// Success message
        				$successMessages["success"] = "<li>The record and genre were added successfully.</li>";
        			} else { // If it did not run OK
        				$errorMessages["fail"] = "<li>The record could not be added. Please try again later.</li>";
        			}
        	    } else if (mysqli_num_rows($r1) > 0 && mysqli_num_rows($r2) > 0) { // both genre and label are already in the database
        		    // get the genre_id
                   $row = mysqli_fetch_assoc($r1);
                   $genreID = $row['genre_id'];
                   
        		    // get the label_id
                   $row = mysqli_fetch_assoc($r2);
                   $labelID = $row['label_id'];
                   

                    // Add the record details to the database
                   $recordQuery = "INSERT INTO records (record_title, release_date, genre_id, artist_id, label_id) VALUES ('$t', '$r', '$genreID', '$artistID', '$labelID')";
                   $r1 = mysqli_query($dbc, $recordQuery) or trigger_error("Query: $recordQuery\n<br />MySQL Error: " . mysqli_error($dbc));
                   $affected1 = mysqli_affected_rows($dbc);
                   
        			if($affected1 == 1) { // If it ran OK.
        				// Success message
        				$successMessages["success"] = "<li>The record was added successfully.</li>";
        			} else { // If it did not run OK
        				$errorMessages["fail"] = "<li>The record could not be added. Please try again later.</li>";
        			}
        		}
            } else {
                $error = true;
                $errorMessages["fail"] = "<li>That artist is not in the database anymore. Please refresh your page and try again.</li>";
            }
        } else {
          $error = true;
          $errorMessages["fail"] = "<li>That record is already in the database. You can update a record in the update tab.</li>";            
      }
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