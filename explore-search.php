<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the search field
	// If the user doesn't select any filters, then ALL the results will show
	if (!(empty($_POST['g']) && empty($_POST['y']) && empty($_POST['c']) && empty($_POST['l']))) {
		
		// An array of arrays, each containing the selected options of a specific filters
		$filters = array('genre' => $_POST['g'], 'date' => $_POST['y'], 'country' => $_POST['c'], 'label_name' => $_POST['l']);

		$q = "SELECT * FROM record_releases where ";
		buildQuery($filters, $q);
	} else {
		// Initial query and attributes
	    $q = "SELECT * FROM record_releases;";
	}
	
	// require the database connection
	require("mysqli_connect.php");
    
    $query = mysqli_query($dbc, $q); // Execute the Query
    $numrows = mysqli_num_rows($query);     // The number of rows retrieved by the query 
    
    $outputArray = [];
    // Fetch the data from the database
    if ($numrows > 0) {
    	while ($row = mysqli_fetch_assoc($query)) {
    		array_push($outputArray, array(
    			$row['record_title'],
    			$row['artist_name'],
    			$row['date'],
    			$row['genre'],
    			$row['label_name'],
    			$row['country']
    			)
    		);
    	}
    }
    
    $outputString = json_encode($outputArray);
	echo $outputString;
	
    //Close database connection
    mysqli_close($dbc);
}

// A utility method to build the required query based on the selected filter criteria
function buildQuery($filters, &$query) {
	$j = 0; 
	foreach ($filters as $key => $array) {
		$j++;
		if (strcmp($key,"date") == 0) {
			$query .= "date_format(" . $key . ",'%Y') in (";
		} else {
			$query .= $key . " in (";
		}
		$i = 0;
		foreach($array as $filter) {
			$i++;
			if ($i == 1) {
				$query .= "'" . $filter . "'";
			} else {
				$query .= ', ' . "'" . $filter . "'";
			}
		}
		if ($j == count($filters)) {
			$query .= ")";
		} else {
			$query .= ") AND ";
		}
	}
}

?>