<?php
if (!isset($page_title)) {
	$page_title = "Music Archives - Home";
}
include ('templates/header.html');

?>

<!-- Search bar -->
<section class="search">
	<h1>Search Music Archives for data</h1>
	<input type="text" id="search" name="search" placeholder="Search..." data-modal-id="popup">
</section>
<!-- /Search Bar -->

<!-- The modal that will display the search results -->
<div id="popup" class="modal-box">  
  	<header>
    	<a href="#" class="js-modal-close close">×</a>
    	<h3>Search Results</h3>
  	</header>
  	<div class="modal-body">
    	<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="search-table" style="width: 100%;">
		</table>
	</div>
  	</div>
  	<footer>
    	<a href="#" class="js-modal-close">Close</a>
  	</footer>
</div>
<!-- End of the modal section -->

<?php
include ('templates/footer.html');
?>