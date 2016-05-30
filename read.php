<?php
if (!isset($page_title)) {
	$page_title = "Forum";
}
include ('templates/header.html');

?>

<!-- Form content goes here -->

<div class="posts">
	<table>
		<tr>
			<td colspan="2"><h1>Posts</h1></td>
		</tr>
		<tr>
			<td id="back-button" colspan="2">
				<a href="forum.php">Back to Forum</a>
			</td>
		</tr>
				<?php
				
				// Check for a thread ID...
				$tid = FALSE;
				if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {

					// Create a shorthand version of the thread ID
					$tid = $_GET['tid'];

					// Run the query
					$q = "SELECT t.subject, p.message, username, DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p') AS posted FROM threads AS t LEFT JOIN posts AS p USING (thread_id) INNER JOIN registered_users AS u ON p.user_id = u.user_id WHERE t.thread_id = $tid ORDER BY p.posted_on ASC";

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
							echo "<tr id='post-subject'><td colspan='2'><h2>{$messages['subject']}</h2></td></tr>";
							echo "<tr height='30px'></tr>";
							$printed = TRUE;
						}

						// Print the message
						echo "<tr><td id='username'>{$messages['username']} ({$messages['posted']}):</td></tr>";
						echo "<tr id='post'><td id='message'>{$messages['message']}</td></tr>";
					} // End of WHILE loop.
					
					echo '</table>';
					
					// Show the form to post a message
					include('post_form.php');

				} else { // Invalid thread ID
					echo '<p>This page has been accessed in error.</p>';
				}

				?>
	</table>
</div>

<!-- End of About Us content -->


<?php
include ('templates/footer.html');
?>