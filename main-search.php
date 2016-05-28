<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the search field

	if (!empty($_POST['i'])) {

		// Protect against XSS attacks
		$searchInput = htmlspecialchars(strip_tags($_POST['i']));		// The user's search terms
	    $terms = explode(" ", $searchInput);    						// Parse the search query
	    $attributes = [];                       						// The attributes to be searched.    

	    // Initial query and attributes
	    $query = "SELECT a.artist_name, country, `year`, genre, total_albums FROM artists as a, genres as g, total_artist_records as v WHERE a.genre_id = g.genre_id AND a.artist_id = v.artist_id AND (";

	    $attributes = array("a.artist_name", "country", "year", "genre", "total_albums");

	    // A utility method to build the required query based on the attributes and the search terms
	    function buildQuery($attributes, $terms, &$query) {
	    	$i = 0;
	    	foreach($terms as $term) {
	    		$i++;

	    		if ($i == 1) {
	    			$j = 0;
	    			foreach($attributes as $attribute) {
	    				$j++;
	    				if ($j == 1) {
	    					$query .= $attribute . " LIKE '%$term%' ";
	    				}
	    				else {
	    					$query .= "OR " . $attribute . " LIKE '%$term%' ";
	    				}
	    			}
	    		}
	    		else {
	    			$j = 0;
	    			foreach($attributes as $attribute) {
	    				$j++;
	    				if ($j == 1) { 
	    					$query .= "OR " . $attribute . " LIKE '%$term%' ";
	    				}
	    				else {
	    					$query .= "OR " . $attribute . " LIKE '%$term%'";
	    				}
	    			}
	    		}
	    	}
	    	$query .= ")";
	    }

	    // Build the query using the terms and required attributes
	    buildQuery($attributes, $terms, $query);
	    // Connect to database
	    require('mysqli_connect.php');

	    $query = mysqli_query($dbc, $query); // Execute the Query
	    $numrows = mysqli_num_rows($query);     // The number of rows retrieved by the query  


	    $outputArray = [];
	    // Fetch the data from the database
	    if ($numrows > 0) {
	    	while ($row = mysqli_fetch_assoc($query)) {
	    		array_push($outputArray, array(
	    			$row['artist_name'],
	    			$row['country'],
	    			$row['year'],
	    			$row['genre'],
	    			$row['total_albums']
	    			)
	    		);
	    	}
	    }
	    
	    $outputString = json_encode($outputArray);
	    echo $outputString;

	    //Close database connection
	    mysqli_close($dbc);
	}
} else { // Redirect
    	// Site URL (base for all redirections)
	define ('BASE_URL', 'http://music-archives.azurewebsites.net/');
	
        $url = BASE_URL . 'index.php'; // Define the URL.
        ob_end_clean(); // Delete the buffer
        header("Location: $url");
        exit(); // Quit the script
    }

    ?>

