	<?php 

	session_start();

    $_SESSION = array(); // Destroy the variables
    session_unset(); 
    session_destroy(); // Destroy the session itself
    setcookie (session_name(), '', time()-3600); // Destroy the cookie
	header("Location:".$_SERVER['HTTP_REFERER']); // Redirect the user
	?>