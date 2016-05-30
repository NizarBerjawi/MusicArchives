<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get all the genres
    $genresQuery = "SELECT DISTINCT genre FROM genres";
    $artistsQuery = "SELECT DISTINCT artist_name FROM artists";
    $labelsQuery = "SELECT DISTINCT label_name FROM labels";
    $countriesQuery = "SELECT DISTINCT country FROM artists";
    $recordsQuery = "SELECT DISTINCT record_title FROM records";
    
    require('mysqli_connect.php');
    
    // A utility function that executes the queries, gets the results and stores the result as
    // key => value pairs. Each value is an array of results.
    function executeQuery($databaseConnection, $query, $field, &$array) {
	    $query = mysqli_query($databaseConnection, $query); // Execute the query
	    
	    $numrows = mysqli_num_rows($query);     // The number of rows retrieved by the query  
	    
        // Fetch the data from the database
        if ($numrows > 0) {
        	while ($row = mysqli_fetch_assoc($query)) {
                if($array[$field]) {
                    array_push($array[$field], $row[$field]);
                } else {
                   $array[$field] = array($row[$field]);
               }
           }
       }
   }
   
   $outputArray = [];
   executeQuery($dbc, $genresQuery, "genre", $outputArray);
   executeQuery($dbc, $artistsQuery, "artist_name", $outputArray);
   executeQuery($dbc, $labelsQuery, "label_name", $outputArray);
   executeQuery($dbc, $countriesQuery, "country", $outputArray);
   executeQuery($dbc, $recordsQuery, "record_title", $outputArray);
   
   $outputString = json_encode($outputArray);
   echo $outputString;

    //Close database connection
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