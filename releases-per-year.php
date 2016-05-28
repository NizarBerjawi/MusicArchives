<?php

	// Prepare the query to get the years and number of convicts */
$query = "SELECT * FROM releases_per_year";

	require('mysqli_connect.php'); // Get the database connection
	
	$r = mysqli_query($dbc, $query);	// Execute the Query
	$numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
	
	$outputArray = [];
	// Fetch the data from the database
	if ($numRows > 0) {
		while ($row = mysqli_fetch_assoc($r)) {
			array_push($outputArray, array('date' => $row['d'], 'records' => $row['t']));
		}
	}
	
	$outputString = json_encode($outputArray);
	echo $outputString;
	
	//Close database connection
	mysqli_close($dbc);

	?>