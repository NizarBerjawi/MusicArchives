<?php
if (!isset($page_title)) {
	$page_title = "Explore Music Archives";
}
include ('templates/header.html');

?>
<!-- Search bar -->
<section class="advanced-search">
	<h1>Select search criteria below:</h1>	
	<div class="filters">
		<form>
			<table>
				<tr>
					<td>
						<p>
							<strong>Filter: By Genre</strong><br>
							<select name="ssubgenres" size="22" multiple="">
								<option>-- ALL --</option>
								<option>Canterbury Scene</option>
								<option>Crossover Prog</option>
								<option>Eclectic Prog</option>
								<option>Experimental/Post Metal</option>
								<option>Heavy Prog</option>
								<option>Indo-Prog/Raga Rock</option>
								<option>Jazz Rock/Fusion</option>
								<option>Krautrock</option>
								<option>Neo-Prog</option>
								<option>Post Rock/Math rock</option>
								<option>Prog Folk</option>
								<option>Progressive Electronic</option>
								<option>Progressive Metal</option>
								<option>Psychedelic/Space Rock</option>
								<option>RIO/Avant-Prog</option>
								<option>Rock Progressivo Italiano</option>
								<option>Symphonic Prog</option>
								<option>Tech/Extreme Prog Metal</option>
								<option>Various Genres</option>
								<option>Zeuhl</option>
							</select><br>(multiple selection, use <em>CTRL</em> key)
						</p>
					</td>
					<td>
						<p>
							<strong>Filter: Specify the list recording type</strong><br>

							<select name="salbumtypes" multiple=""> 
								<option>Studio</option>
								<option>DVD/Video</option>
								<option>Boxset/Compilation</option>
								<option>Live</option>
								<option>Singles/EPs/Fan Club/Promo</option>
							</select><br>(multiple selection, use <em>CTRL</em> key)
						</p>

						<p>
							<strong>Filter: Year of release</strong><br>
							<select name="syears" size="10" multiple="">    
								<option>-- ALL --</option>
								<option>2016</option>
								<option>2015</option>
								<option>2014</option>
								<option>2013</option>
								<option>2012</option>
								<option>2011</option>
								<option>2010</option>
								<option>2009</option>
							</select><br>(multiple selection, use CTRL key)
						</p>
					</td>

					<td>  
						<p>
							<strong>Filter: Country</strong><br>
							<select name="scountries" size="10" multiple="">
								<option>-- ALL --</option>
								<option>Andorra</option>
								<option>Argentina</option>
								<option>Armenia</option>
								<option>Australia</option>
								<option>Austria</option>
								<option>Bahrain</option>
								<option>Bangladesh</option>
								<option>Belarus</option>
								<option>Belgium</option>
								<option>Bolivia</option>
							</select><br>(multiple selection, use <em>CTRL</em> key)
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="center-button">
							<input class="button-red" type="submit" value="Submit">
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</section>
<!-- /Search Bar -->

<?php
include ('templates/footer.html');
?>