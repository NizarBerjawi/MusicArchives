<?php
if (!isset($page_title)) {
	$page_title = "Music Archives - Home";
}
include ('templates/header.html');

?>

<!-- Search bar -->
<section class="search">
	<h1>Search Music Archives for data</h1>
	<input type="text" id="search" name="search" placeholder="Search...">
</section>
<!-- /Search Bar -->


<?php
include ('templates/footer.html');
?>