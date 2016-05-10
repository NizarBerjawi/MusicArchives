<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Music Archives</title>
	<!-- My Styles -->
	<link href="css/main.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>

</head>

<body>
	<header>
		<!-- Navigation menu -->
		<nav>
			<ul class="topnav">
				<li><a href="index.html" id="logo">Music Archives</a></li>
				<li><a href="index.html">Home</a></li>
				<li><a href="explore.html">Explore</a></li>
				<li><a href="analytics.html">Analytics</a></li>
				<li><a href="forum.html">Blog</a></li>
				<li><a href="about-us.html">About Us</a></li>
				<li><a href="contact-us.html">Contact Us</a></li>
				<li class="button"><a class="show-modal open-modal">Sign in</a></li>
				<li class="icon">
					<a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
				</li>
			</ul>
		</nav>
		<!-- /Navigation Menu -->
		
		<!-- Sign-in Modal -->
		<div class="modal">
			<a class="close-modal" href="#">X</a>
			<h2>Enter Email and password to login</h2>
			<form action="#">
				<input class="sign-in" type="text" name="email" placeholder="Email e.g., spaceman.spiff@gross.club">
				<input class="sign-in" type="password" name="password" placeholder="Password e.g., ********">
				<input class="button-red" type="submit" value="Submit">
			</form> 
		</div>
		<!-- /Sign-in Modal -->
	</header>

	<main>
		<div class="container">
			<!-- Search bar -->
			<section class="search">
				<h1> Under Construction</h1>
			</section>
			<!-- /Search Bar -->

		</div>
	</main>

	<footer class="footer-basic-centered">
		<p class="footer-company-motto">Music Archives</p>
		<p class="footer-company-name">Copyright &copy; 2015</p>
	</footer>

	<!-- JQuery -->
	<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
	<!-- My JavaScript -->
	<script src="js/main.js"></script>

</body>

</html>