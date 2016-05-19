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


<!-- Search results Modal -->
<div class="search-result-modal">
	<a class="close-modal" href="#">X</a>
	<div class="dataTable_wrapper">
		<table class="table table-striped table-bordered table-hover" id="search-table" style="width: 100%;">
		</table>
	</div>
</div>
<!-- /Search Results Modal -->



<?php
include ('templates/footer.html');
?>