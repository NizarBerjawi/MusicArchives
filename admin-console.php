<?php
session_start();

if(($_SESSION['user_level'] != 1) && !(isset($_SESSION['email']) && isset($_SESSION['password']) && $_SESSION['user_level'] == 1)) {
    define ('BASE_URL', 'https://music-archives-nizar12.c9users.io');
	header('Location: ' . BASE_URL . '/index.php');
	exit();
}	

if (!isset($page_title)) { 
	$page_title="Administrator Console"; 
} 

include( 'templates/header.html'); 
?>

<!-- Admin dashboard goes in here -->

<div class="container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Add Artist</li>
        <li class="tab-link" data-tab="tab-2">Add Records</li>
        <li class="tab-link" data-tab="tab-3">Manage Administrators</li>
    </ul>

    <div id="tab-1" class="tab-content current">
        <form id="artist-form" method="post" action="add-artists.php">
            <fieldset class="fieldset">
                <legend>
                    <h3>Artist Information</h3>
                </legend>
                
            	<div class="artist-error"></div>
            	<div class="artist-success"></div>
            	
                <table id="artist-info">
                    <tr>
                        <td>Artist Name:</td>
                        <td>
                            <input id="artist-tags" class="sign-in" type="text" name="artist-name">
                        </td>
                        <td>Country:</td>
                        <td>
                            <input id="country-tags" class="sign-in" type="text" name="country">
                        </td>
                    </tr>
                    <tr>
                        <td>Year Formed:</td>
                        <td>
                            <input class="sign-in" type="text" name="year">
                        </td>
                        <td>Genre:</td>
                        <td>
                            <input class="sign-in genre-tags" type="text" name="artist-genre">
                        </td>

                    </tr>
                    <tr>
                        <td colspan="4">
                            <button type="submit" class="button-red" name="submit-artist">Add Artist</button>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

    <div id="tab-2" class="tab-content">
        <form id="record-form" method="post" action="add-records.php">
            <fieldset class="fieldset">
                <legend>
                    <h3>Record Information</h3></legend>
                    
                    
                <div class="record-error"></div>
            	<div class="record-success"></div>
                <table id="record-info">
                    <tr>
                        <td>
                            <label>Artist:</label>
                        </td>
                        <td>
                            <select class="sign-in" name="artistname">
                                <option>-- Select --</option>
                                <?php
                                    require('mysqli_connect.php');
                                    $query = "SELECT DISTINCT artist_name FROM artists";
                                    
                                    $query = mysqli_query($dbc, $query); // Execute the Query
	                                $numrows = mysqli_num_rows($query);  // The number of rows retrieved by the query 
	                                
	                                // Fetch the data from the database
                                    if ($numrows > 0) {
                                    	while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                            <option value="<?php echo $row['artist_name'];?>">
                                                <?php echo $row['artist_name']; ?></option>
                                <?php 
                                    	} 
                                    }
                                    mysqli_close($dbc);
                                ?>
                            </select>
                        </td>

                        <td>
                            <label>Record Title:</label>
                        </td>
                        <td>
                            <input id="record-tags" class="sign-in" type="text" name="recordtitle" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Release Date:</label>
                        </td>
                        <td>
                            <input class="sign-in" type="text" name="releasedate" placeholder="dd/mm/yyyy" />
                        </td>
                        <td>
                            <label>Genre:</label>
                        </td>
                        <td>
                            <input class="sign-in genre-tags" type="text" name="genre" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Label:</label>
                        </td>
                        <td>
                            <input id="label-tags" class="sign-in" type="text" name="label" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button type="submit" class="button-red" name="submit-record">Add Record</button>
                        </td>
                    </tr>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    
    <div id="tab-3" class="tab-content">
        <form id="admin-form" method="post" action="manage-admin.php">
            <fieldset class="fieldset">
                <legend>
                    <h3>Administrator Information</h3>
                </legend>
                    
                <div class="admin-error"></div>
            	<div class="admin-success"></div>
                <table id="admin-info">
                    <tr>
                        <td>
                            <label>User:</label>
                        </td>
                        <td>
                            <select class="sign-in" name="admin-username">
                                <option>-- Select --</option>
                                <?php
                                    require('mysqli_connect.php');
                                    $query = "SELECT username FROM registered_users WHERE active IS NULL";
                                    
                                    $query = mysqli_query($dbc, $query); // Execute the Query
	                                $numrows = mysqli_num_rows($query);  // The number of rows retrieved by the query 
	                                
	                                // Fetch the data from the database
                                    if ($numrows > 0) {
                                    	while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                            <option value="<?php echo $row['username'];?>">
                                                <?php echo $row['username']; ?></option>
                                <?php 
                                    	} 
                                    }
                                    mysqli_close($dbc);
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>First Name:</label>
                        </td>
                        <td>
                            <input id="admin-fname" class="sign-in" type="text" name="admin-fname" disabled />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Last Name:</label>
                        </td>
                        <td>
                            <input id="admin-lname" class="sign-in" type="text" name="admin-lname" disabled />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Email:</label>
                        </td>
                        <td>
                            <input id="admin-email" class="sign-in" type="text" name="admin-email" disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Registration date:</label>
                        </td>
                        <td>
                            <input id="reg-date" class="sign-in" type="text" name="reg-date" disabled/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label>Set as Admin</label>
                        </td>
                        <td>
                            <!-- CSS3 Checkbox Styles by Kushagra Agarwal  http://cssdeck.com/labs/css-checkbox-styles -->
                            <!-- Slide THREE -->
                            <div class="slideThree">	
                            	<input type="checkbox" value="None" id="slideThree" name="check" />
                            	<label for="slideThree"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="button-red" name="submit-admin">Update</button>
                        </td>
                    </tr>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

</div>
<!-- container -->

<?php
include ('templates/footer.html');
?>