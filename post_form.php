<?php
// This page shows the form for posting messages
// It's included by other pages, never called directly

// Only display this form if the user is logged in
if(isset($_SESSION['email']) && isset($_SESSION['password'])) {

	
	// If on read.php
	if (isset($tid) && $tid) {
		// Display the form
		echo '<form id="thread-reply" action="post.php" method="post">';
		// Add the thread ID as a hidden input
		echo '<input name="tid" type="hidden" value="' . $tid . '" />';
		
		// Create the body textarea
		echo '<div class="center-post"><textarea class="sign-in text-comment" id="reply" name="body" placeholder="Express yourself here...">';

		if (isset($body)) {
			echo $body;
		}

		echo '</textarea>';
		echo '<div class="center-button"><input class="button-red" name="submit" type="submit" value="Submit" /></div></div></form>';

	} else { // New thread

		// Create subject input
		echo '<tr><td>Subject</td><td><input class="sign-in" name="subject" type="text"';

		if (isset($subject)) {
			echo "value=\"$subject\" ";
		}

		echo '/><td></tr>';
		
		// Create the body textarea
		echo '<tr><td>Body:</td><td><textarea class="sign-in text-comment" name="body">';

		if (isset($body)) {
			echo $body;
		}

		echo '</textarea></td></tr>';
			// Finish the form
		echo '<tr><td colspan="2"><div class="center-button"><input class="button-red" name="submit" type="submit" value="Submit" /></div></td></tr></table></form></section>';
		include ('templates/footer.html');
	} // End of $tid IF
} else {
	echo '<tr><td>You must be logged in to post messages.</td></tr></table></section>';
}

?>