<?php
if (!isset($page_title)) {
	$page_title = "Forum";
}
include ('templates/header.html');

?>

<!-- Form content goes here -->

<div class="forum">
	<table>
		<tr>
			<td id="header" colspan="2"><h1>Message Board</h1></td>
		</tr>
		<tr>
			<td id="new-thread-button">
				<?php
				// Display links based on login status
				if(isset($_SESSION['email']) && isset($_SESSION['password'])) {
					// If this is the forum page, add a link for posting new threads:
					if (basename($_SERVER['PHP_SELF']) == 'forum.php') {
						echo '<a href="post.php">New Thread</a><br />';
					}
				}
				?>
			</td>
		</tr>

		<tr>
			<td>
				<?php
				// This part shows the threads in the forum
				// Retrieve all the messages...

				// The query for retrieving all the threads in this forum, along with the original user,
				// when the thread was first posted, when it was last replied to, and how many replies it has had.
				$q = "SELECT t.thread_id, t.subject, username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN registered_users AS u ON t.user_id = u.user_id GROUP BY (p.thread_id) ORDER BY last DESC";

				require('mysqli_connect.php');

				$r = mysqli_query($dbc, $q);
				if(mysqli_num_rows($r) > 0) {
					// Create a table
					echo '<table id="threads-list">
					<tr id="headers">
						<td>Subject</td>
						<td>Posted by</td>
						<td>Posted on</td>
						<td>Replies</td>
						<td>Latest Reply</td>
					</tr>';

						// Fetch each thread
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr id="threads">
						<td><a href="read.php?tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
						<td>' . $row['username'] . '</td>
						<td>' . $row['first'] . '</td>
						<td>' . $row['responses'] . '</td>
						<td>' . $row['last'] . '</td>
					</tr>';
				}

				echo '</table>'; // Complete the table
			} else {
				echo '<p>There are currently no messages in this forum.</p>';
			}
			?>
		</td>
	</tr>
</table>
</div>

<!-- End of About Us content -->


<?php
include ('templates/footer.html');
?>