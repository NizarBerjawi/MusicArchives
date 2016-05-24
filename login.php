<?php

$page_title = 'Login';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); // Start the session
    require('mysqli_connect.php'); // Get the database connection
    // An array containing all the error messages in JSON format
    $errorMessages = [];
    
	$errorMessages["error"] = true;
    // Validate the email address
    if (!empty($_POST["e"])) {
        $e = mysqli_real_escape_string($dbc, $_POST["e"]);
    } else {
        $e = FALSE;
        $errorMessages["e"] = '<li>You forgot to enter you email address!</li>';
    }
        
    // Validate the password
    if (!empty($_POST["p"])) {
        $p = mysqli_real_escape_string($dbc, $_POST["p"]);
    } else {
        $p = FALSE;
        $errorMessages["p"] = '<li>You forgot to enter a password!</li>';
    }
    
    if($e && $p) { // If everything is OK
        $errorMessages["error"] = false;
        // Query the database
        $q = "SELECT user_id, username, password, salt, active, user_level FROM registered_users WHERE (user_email=?) AND active IS NULL";

        $stmt = $dbc->stmt_init();
        $stmt->prepare($q);
        $stmt->bind_Param('s', $e);

        // Execute prepared statement
        $stmt->execute();
        
        // Get the result
	    $r = $stmt->get_result();
	    $row = $r->fetch_array();
	    
	    $user_id = $row['user_id'];
	    $username = $row['username'];
	    $active = $row['active'];
	    $user_level = $row['user_level'];
	    $hash = $row['password'];
	    $salt = $row['salt'];
	    
	    // close statement
	    $stmt->close();
	    
	    // hash_equals is only compatible with (PHP 5 >= 5.6.0, PHP 7)
        // this function creates a new has_equals function if the default is not available
        if(!function_exists('hash_equals')) {
            function hash_equals($str1, $str2) {
                if(strlen($str1) != strlen($str2)) {
                    return false;
                } else {
                    $res = $str1 ^ $str2;
                    $ret = 0;
                    for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                        return !$ret;
                }
            }
        }
        
        if ($user_id) {
            // Hashing the password with its hash as the salt returns the same hash
            if (hash_equals($hash, crypt($p, $hash))) { // Password match
                $errorMessages["error"] = false; // no errors where found
                
                    // Register the values in a SESSION
           	        $_SESSION['user_id'] = $user_id;
        	        $_SESSION['username'] = $username;
        	        $_SESSION['email'] = $e;
        	        $_SESSION['password'] = $p;
        	        $_SESSION['active'] = $active;
        	        $_SESSION['user_level'] = $user_level;
        
                    mysqli_free_result($r);
        	        mysqli_close($dbc);
                
                if (strcmp($user_level, '0') == 0) { // If the user is a regular user
                    $errorMessages["admin"] = false;
                } else {
                    $errorMessages["admin"] = true;
                }
            } else {
                $errorMessages["error"] = true;
                $errorMessages["wp"] = '<li>You entered the wrong password</li>';
            }
        } else {
                $errorMessages["error"] = true;
    	        $errorMessages["r"] = '<li>Either you haven\'t registered or you haven\'t activated your account!</li>';
        }
    }
    
 	echo json_encode($errorMessages);
} // end of SUBMIT conditional

?>