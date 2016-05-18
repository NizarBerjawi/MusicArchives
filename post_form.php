<?php
// This page shows the form for posting messages
// It's included by other pages, never called directly

// Redirect if this page is caled directly
if (!isset($words)) {
	header ("Location: http://localhost/MusicArchives/forum.php");
	exit();
}

// Only display this form if the user is logged in
if(isset($_SESSION['email']) && isset($_SESSION['password'])) {
	// Display the form
	echo '<form action="post.php" method="post" accept-charset="utf-8">';

	// If on read.php
	if (isset($tid) && $tid) {

		// Print a caption
		echo '<h3>Post a Reply</h3>';

		// Add the thread ID as a hidden input
		echo '<input name="tid" type="hidden" value="' . $tid . '" />';
	} else { // New thread

		// Print a caption
		echo '<h3>New Thread</h3>';

		// Create subject input
		echo '<p><em>Subject</em>: <input name="subject" type="text" size="60" maxlength="100" ';

		if (isset($subject)) {
			echo "value=\"$subject\" ";
		}

		echo '/></p>';
	} // End of $tid IF

	// Create the body textarea
	echo '<p><em>Body</em>: <textarea name="body" rows="10" cols="60">';

	if (isset($body)) {
		echo $body;
	}

	echo '</textarea></p>';

	// Finish the form
	echo '<input name="submit" type="submit" value="Submit" />
</form>';

} else {
	echo '<p>You must be logged in to post messages.</p>';
}

?>