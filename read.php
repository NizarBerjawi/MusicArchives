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
				// Display links based on login status
				if(isset($_SESSION['email']) && isset($_SESSION['password'])) {
						// If this is the forum page, add a link for posting new threads:
					if (basename($_SERVER['PHP_SELF']) == 'forum.php') {
						echo '<a href="post.php" class="navlink">New Thread</a><br />';
					}

					//add the log out link
					echo '<a href="logout.php" class="navlink">Logout</a><br />';
				} else {
					// Register and login links
					echo '<a href="registration-form.php" class="navlink">Register</a><br /><a href="#" class="navlink show-modal open-modal">Sign In</a><br />';
				}
				?>
			</td>
			<td valign="top" class="content">
				
				<?php
				
				// Check for a thread ID...
				$tid = FALSE;
				if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {

					// Create a shorthand version of the thread ID
					$tid = $_GT['tid'];

					// Run the query
					$q = "SELECT t.subject, p.message, username DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p') AS posted FROM threads AS t LEFT JOIN posts AS p USING (thread_id) INNER JOIN registered_users AS u ON p.user_id = u.user_id WHERE t.thread_id = $tid ORDER BY p.posted_on ASC";

					require('mysqli_connect.php');

					$r = mysqli_query($dbc, $q);
					if (!(mysqli_num_rows($r) > 0)) {
						$tid = FALSE; // Invalid thread ID
					}
				} // End of isset($_GET['tid']) IF.

				if ($tid) { // Get the messages in this thread...

					$printed = FALSE; //Flag variable

					// Fetch each
					while ($messages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						// Only need to print subject once
						if(!$printed) {
							echo "<h2>{$messages['subject']}</h2>\n";
							$printed = TRUE;
						}

						// Print the message
						echo "<p>{$messages['username']} ({$messages['posted']})<br /> {$messages['message']}</p><br />\n";
					} // End of WHILE loop.

					// Show the form to post a message

				} else { // Invalid thread ID
					echo '<p>This page has been accessed in error.</p>';
				}

				?>
			</td>
		</tr>

		<tr>
			<td colspan="2" align="center">&copy; 2016 Music Archive
			</td>
		</tr>
	</table>
</section>

<!-- End of About Us content -->


<?php
include ('templates/footer.html');
?>