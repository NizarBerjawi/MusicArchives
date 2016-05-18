<?php 
if (!isset($page_title)) { 
	$page_title="Contact Music Archives"; 
} 

include( 'templates/header.html'); 
?>

<!-- Contact Us form goes here -->
<div class="container-contact-us">
	<h1>Contact Us</h1>
	<div id="feedback">
		<form id="comments" action="#" method="post">
			<table>
				<tr>
					<td class="info">Your name:</td>
					<td>
						<input class="sign-in" type="text" name="name">
					</td>
				</tr>
				<tr>
					<td class="info">Your email:</td>
					<td>
						<input class="sign-in" type="text" name="email">
					</td>
				</tr>
				<tr>
					<td class="info">Your comments:</td>
					<td>
						<textarea class="sign-in text-comment" name="comments" rows="15" cols="50"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button class="button-red contact-us-button" type="submit" value="Submit">Submit</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div id="findUs">
		<h2>Find Us:</h2>
		<table>
			<tr>
				<td><b>Phone:</b></td>
				<td>0416139022</td>
			</tr>
			<tr>
				<td><b>Fax:</b></td>
				<td>(07) 1224 5678</td>
			</tr>
			<tr>
				<td><b>Email Us:</b></td>
				<td><a href="mailto:alexlou1390@gmail.com">alexlou1390@gmail.com</a></td>
			</tr>
			<tr>
				<td><b>Address:</b></td>
				<td>St Lucia QLD 4072</td>
			</tr>
		</table>
		<div id="map"></div>
	</div>
	<!-- End of Contact Us form -->
</div>

<?php 
include('templates/footer.html');
?>