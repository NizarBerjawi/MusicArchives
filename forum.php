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
				// This part shows the threads in the forum
				// Retrieve all the messages...

				// The query for retrieving all the threads in this forum, along with the original user,
				// when the thread was first posted, when it was last replied to, and how many replies it has had.
				$q = "SELECT t.thread_id, t.subject, username, COUNT(post_id) - 1 AS responses, MAX(DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p')) AS last, MIN(DATE_FORMAT(p.posted_on, '%e-%b-%y %l:%i %p')) AS first FROM threads AS t INNER JOIN posts AS p USING (thread_id) INNER JOIN registered_users AS u ON t.user_id = u.user_id GROUP BY (p.thread_id) ORDER BY last DESC";
				
				require('mysqli_connect.php');


				$r = mysqli_query($dbc, $q);
				if(mysqli_num_rows($r) > 0) {
					// Create a table
					echo '<table width="100%" border="0" cellspacing"2" cellpadding="2" align="center">
					<tr>
						<td align="left" width="50%"><em>Subject</em>:</td>
						<td align="left" width="20%"><em>Posted by</em>:</td>
						<td align="center" width="10%"><em>Posted on</em>:</td>
						<td align="center" width="10%"><em>Replies</em>:</td>
						<td align="center" width="10%"><em>Latest Reply</em>:</td>
					</tr>';

						// Fetch each thread
					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

						echo '<tr>
						<td align="left"><a href="read.php?tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></td>
						<td align="left">' . $row['username'] . '</td>
						<td align="center">' . $row['first'] . '</td>
						<td align="center">' . $row['responses'] . '</td>
						<td align="center">' . $row['last'] . '</td>
					</tr>';
				}

				echo '</table>'; // Complete the table
			} else {
				echo '<p>There are currently no messages in this forum.</p>';
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