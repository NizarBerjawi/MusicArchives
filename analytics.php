<?php
if (!isset($page_title)) {
	$page_title = "Analytics";
}
include ('templates/header.html');

?>

<!-- List of Analytics visualizations -->
<section class="analytics-list">
	<h1>Analytics</h1>

	<div class="category-box">
		<div class="category-icon">
			<div class="category-image"></div>
		</div>

		<div class="category-description">
			<h3>Releases Per Year</h3> 
			<p>An area chart that displays the changes in number of albums release over the years.</p>
		</div>

		<div class="category-button">
			<span><a id="releases-per-year" class="visualization-button" data-modal-id="popup">View</a></span>
		</div>
	</div>
</section>
<!-- End of list of analytics section -->

<!-- The modal that will allow all the visualizations to be displayed -->
<section>
	<div id="popup" class="modal-box">
		<header>
			<a href="#" class="js-modal-close close">×</a>
			<h3>Search Results</h3>
		</header>
		<div class="modal-body">
			<!-- All d3.js visualizations are displayed here -->
			<div class="visualization"></div>
		</div>
		<footer>
			<a href="" class="js-modal-close">Close</a>
		</footer>
	</div>
</section>
<!-- End of visualization Section -->

<?php
include ('templates/footer.html');
?>