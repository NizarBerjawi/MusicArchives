<?php
if (!isset($page_title)) {
	$page_title = "Forum";
}
include ('templates/header.html');

?>

<!-- Form content goes here -->

<section>
	<table width="90%" border="0" cellspacing="10" cellpadding="0" align="center">

		<tr>
			<td colspan="2" bgcolor="#003366" align="center"><p class="title">Title</p></td>
		</tr>
		<tr>
			<td valign="top" nowrap="nowrap" width="10%">
				<a href="index.php" class="navlink">Home</a><br />
				<a href="forum.php" class="navlink">Forum</a><br />

				<?php
					// This page handles the message post.
					// It also displays the form if creating a new thread.

					if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form
						// Validate thread ID ($tid), which may not be present
						if (isset($_POST['tid']) && filter_var($_POST['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
							$tid = $_POST['tid'];
						} else {
							$tid = FALSE;
						}

						// If there is no thread ID, a subject must be provided
						if (!$tid && empty($_POST['subject'])) {
							$subject = FALSE;
							echo '<p>Please enter a subject for this post.</p>';
						} elseif (!$tid && !empty($_POST['subject'])) {
							$subject = htmlspecialchars(strip_tags($_POST['subject']));
						} else { // Thread ID, no need for subject
							$subject = TRUE;
						}

						// Validate the body
						if (!empty($_POST['body'])) {
							$body = htmlentities($_POST['body']);
						} else {
							$body = FALSE;
							echo '<p.Please enter a body for this post.</p>';
						}

						if ($subject && $body) { // OK!
							// Add the message to the database...

							if (!$tid) { // Crete a new thread.
								$q = "INSERT INTO threads (user_id, subjects) VALUES ({$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";

								require('mysqli_connect.php');
								$r = mysqli_query($dbc, $q);
								if (mysqli_affected_rows($dbc) == 1) {
									$tid = mysqli_insert_id($dbc);
								} else {
									echo '<p>Your post could not be handled due to a system error.</p>';
								}
							} // No $tid.

							if ($tid) { // Add this to the replies table
								$q = "INSERT INTO posts (thread_id, user_id, message, posted_on) VALUES ($tid, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
								require('mysqli_connect.php');

							}
						}

					}
					?>