<?php
// This page activates the user's account.

	// Need the database connection
$page_title = 'Activate Your Account';

    // The header template
include ('templates/header.html');

    // If $x and $y don't exist or are not of the proper format, redirect the user
if (isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32 )) {
        // Update the database
    require('mysqli_connect.php');
    
    $q = "UPDATE registered_users SET active=NULL WHERE (user_email='" . mysqli_real_escape_string($dbc, $_GET['x']) . "') LIMIT 1";
    $r = mysqli_query($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
    
        // Print a customized message:
    if (mysqli_affected_rows($dbc) == 1) {
        echo "<h3>Your account is now active. You may now log in.</h3>";
    } else {
        echo '<p>Your account could not be activated. Please re-check the link or contact the system administrator.</p>';
    }
    
    mysqli_close($dbc);
    } else { // Redirect
    	// Site URL (base for all redirections)
      define ('BASE_URL', 'http://infs3202-sdz9e.uqcloud.net/');
      // For local Testing purposes:
      //define ('BASE_URL', 'http://localhost/MusicArchives/');
      
        $url = BASE_URL . 'index.php'; // Define the URL.
        ob_end_clean(); // Delete the buffer
        header("Location: $url");
        exit(); // Quit the script
    } // End of main IF-ELSE.
    
    include ('templates/footer.html');
    ?>