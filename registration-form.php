<?php

if (!isset($page_title)) {
	$page_title = "Register";
}
include ('templates/header.html');

?>

<!-- Search bar -->
<section class="registration-form">
	<div id="center-form">
		<h1>Please enter your details below:</h1>
		
		<div class="error-message"></div>
		<div class="success-message"></div>

		<form id="registration" method="post" action="register.php">
			<table>
				<tr>
					<td>
						First Name:
					</td>
					<td>
						<input class="sign-in" type="text" name="fname" placeholder="John">
					</td>
				</tr>
				<tr>
					<td>
						Last Name:
					</td>
					<td>
						<input class="sign-in" type="text" name="lname" placeholder="Smith">
					</td>
				</tr>
				<tr>
					<td>
						Email:
					</td>
					<td>
						<input class="sign-in" type="text" name="email" placeholder="Email e.g., spaceman.spiff@gross.club">
					</td>
				</tr>
				<tr>
					<td>
						Username:
					</td>
					<td>
						<input class="sign-in" type="text" name="username" placeholder="Smith">
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td>
						<input class="sign-in" type="password" name="password">
					</td>
				</tr>
				<tr>
					<td>
						Confirm Password:
					</td>
					<td>
						<input class="sign-in" type="password" name="password-confirm">
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<button class="button-red" type="submit" name="btn-signup">Register</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</section>
<!-- /Search Bar -->


<?php
include ('templates/footer.html');
?>