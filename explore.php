<?php
if (!isset($page_title)) {
	$page_title = "Explore Music Archives";
}
include ('templates/header.html');

?>
<!-- Search bar -->
<section class="advanced-search">
	<h1>Explore</h1>	
	<div class="filters">
		<form>
			<table>
				<tr>
					<td colspan="4">
						<h2>Select filters below:</h2>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Filter: By Genre</strong>
					</td>
					<td>
						<strong>Filter: Year of release</strong>
					</td>
					<td>
						<strong>Filter: Country</strong>
					</td>
					<td>
						<strong>Filter: Labels</strong>
					</td>
				</tr>
				<tr>	
					<td>
						<select id="genres" size="7" multiple>
							<?php
								require('mysqli_connect.php');
								$q = 'SELECT genre FROM genres ORDER BY genre ASC'; 
								
								$r = mysqli_query($dbc, $q);	// Execute the Query
								$numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
							
								if ($numRows > 0) {
									while ($row = mysqli_fetch_assoc($r)) {
							?>
							<option value="<?php echo $row['genre'] ?>"><?php echo $row['genre']; ?></option>
							<?php			
									}
								}
							?>
						</select><br>(multiple selection, use <em>CTRL</em> key)
					</td>
					<td>
						<select id="years" size="7" multiple>    
							<?php
								$q = "SELECT DISTINCT date_format(release_date, '%Y') as release_date FROM records ORDER BY release_date ASC;"; 
								
								$r = mysqli_query($dbc, $q);	// Execute the Query
								$numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
							
								if ($numRows > 0) {
									while ($row = mysqli_fetch_assoc($r)) {
							?>
							<option value="<?php echo $row['release_date'] ?>"><?php echo $row['release_date']; ?></option>
							<?php			
									}
								}
							?>
						</select><br>(multiple selection, use CTRL key)
					</td>
					<td>  
						<select id="countries" size="7" multiple>
							<?php
								$q = "SELECT DISTINCT country FROM artists ORDER BY country ASC;"; 
								
								$r = mysqli_query($dbc, $q);	// Execute the Query
								$numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
							
								if ($numRows > 0) {
									while ($row = mysqli_fetch_assoc($r)) {
							?>
							<option value="<?php echo $row['country']; ?>"><?php echo $row['country']; ?></option>
							<?php			
									}
								}
							?>
						</select><br>(multiple selection, use <em>CTRL</em> key)
					</td>
					
					<td>  
						<select id="labels" size="7" multiple>
							<?php
								$q = "SELECT DISTINCT label_name FROM labels ORDER BY label_name ASC;"; 
								
								$r = mysqli_query($dbc, $q);	// Execute the Query
								$numRows = mysqli_num_rows($r);		// The number of rows retrieved by the query
							
								if ($numRows > 0) {
									while ($row = mysqli_fetch_assoc($r)) {
							?>
							<option value="<?php echo $row['label_name']; ?>"><?php echo $row['label_name']; ?></option>
							<?php			
									}
								}
							?>
						</select><br>(multiple selection, use <em>CTRL</em> key)
					</td>
					
				</tr>
				<tr>
					<td colspan="4">
						<div class="center-button">
							<input id="submit-filter" class="button-red" type="submit" value="Submit" data-modal-id="popup">
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</section>
<!-- /Search Bar -->


<!-- The modal that will display the advanced search results -->
<div id="popup" class="modal-box">  
  	<header>
    	<a href="#" class="js-modal-close close">×</a>
    	<h3>Search Results</h3>
  	</header>
  	<div class="modal-body">
    	<div class="dataTable_wrapper">
			<table class="table table-striped table-bordered table-hover" id="explore-table" style="width: 100%;">
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