<?php
if (!isset($page_title)) {
	$page_title = "Forum";
}
include ('templates/header.html');

?>

<!-- Form content goes here -->

<section>
	<form action="post.php" method="post">
		<table id="new-thread">
			<tr>
				<td id="header" colspan="2"><h1>New Thread</h1></td>
			</tr>
			<tr>
				<td id="back-button2" colspan="2">
					<a href="forum.php">Back to Forum</a><br />
				</td>
			</tr>

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
								require('mysqli_connect.php');

								$q = "INSERT INTO threads (user_id, subject) VALUES ({$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";

								$r = mysqli_query($dbc, $q);

								if (mysqli_affected_rows($dbc) == 1) {
									$tid = mysqli_insert_id($dbc);
								} else {
									echo '<p>Your post could not be handled due to a system error.</p>';
								}
							} // No $tid.

							if ($tid) { // Add this to the replies table
								require('mysqli_connect.php');
								$q = "INSERT INTO posts (thread_id, user_id, message, posted_on) VALUES ($tid, {$_SESSION['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
								
								$r = mysqli_query($dbc, $q);
								if (mysqli_affected_rows($dbc) == 1) {
									define ('BASE_URL', 'http://music-archives.azurewebsites.net/');
									header('Location: ' . BASE_URL . '/forum.php');
									die();
									
								} else {
									echo '<p>Your post could not be handled due to a system error.</p>';
									include ('templates/footer.html');
									
								}
							} // Valid $tid
						} else {
							include ('post_form.php');
						}
					} else { // Display the form
						include ('post_form.php');
					}
					?>