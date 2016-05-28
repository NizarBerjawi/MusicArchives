// Toggle the class of the tabs to when a tab is clicked
$(document).ready(function() {

	$('ul.tabs li').click(function() {
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#" + tab_id).addClass('current');
	})
})

// Display autocomplete results for the administrator
$(function() {
	var url = "autocomplete.php";
	var posting = $.post(url);
	posting.done(function(response) {
		var autocompleteTags = jQuery.parseJSON(response);

		$(".genre-tags").autocomplete({
			source: autocompleteTags.genre
		});

		$("#artist-tags").autocomplete({
			source: autocompleteTags.artist_name
		});

		$("#label-tags").autocomplete({
			source: autocompleteTags.label_name
		});

		$("#country-tags").autocomplete({
			source: autocompleteTags.country
		});

		$("#record-tags").autocomplete({
			source: autocompleteTags.record_title
		});
	});
});

// Regex used to validate all text input
var textInputRegex = /^[a-zA-Z][a-zA-Z\-'\s]{0,43}$/;

// A function to handle form submission and validation of the Add ARTIST section
var artistHandler = function() {
	var $form = $("#artist-form");
	var artistName = $form.find("input[name='artist-name']").val();
	var artistCountry = $form.find("input[name='country']").val();
	var yearFormed = $form.find("input[name='year']").val();
	var artistGenre = $form.find("input[name='artist-genre']").val();

	var url = $form.attr("action");

	$(".artist-error").empty(); // Clear any previous error messages
	$(".artist-success").empty(); // Clear any previous success messages

	var yearIsValid = checkYear(yearFormed);
	var countryIsValid = checkTextInput(artistCountry, "Enter a valid Country!", "#artist-form .artist-error", textInputRegex);
	var genreIsValid = checkTextInput(artistGenre, "Enter a valid genre!", "#artist-form .artist-error", textInputRegex);
	var nameIsValid = checkTextInput(artistName, "Enter an artist name", "#artist-form .artist-error");
	// Check if all the input is valid
	if (yearIsValid && countryIsValid && genreIsValid && nameIsValid) {

		// Post the data to the php file
		var posting = $.post(url, {
			a: artistName,
			c: artistCountry,
			y: yearFormed,
			g: artistGenre
		});

		// The response of the php file consists of validation results similar to those in this file
		posting.done(function(data) {
			var messages = jQuery.parseJSON(data);
			var $errorMessages = $(".artist-error").hide(); // Hide the errors div so that fade in works
			var $successMessages = $(".artist-success").hide(); // Hide the success div so that fade in works
			jQuery.each(messages, function(key, val) {
				// Display any success or error messages
				if (key === "success") {
					$successMessages.append(val);
					$successMessages.fadeIn();
				}
				else {
					$errorMessages.append(val);
					$errorMessages.fadeIn();
				}
			})
		})
	}
}

// A function to handle form submission and validation of the Add RECORD section
var recordHandler = function() {
	var $form = $("#record-form");
	var artistName = $form.find("select[name='artistname']").val();
	var recordTitle = $form.find("input[name='recordtitle']").val();
	var releaseDate = $form.find("input[name='releasedate']").val();
	var genre = $form.find("input[name='genre']").val();
	var label = $form.find("input[name='label']").val();

	var url = $form.attr("action");

	$(".record-error").empty(); // Clear any previous error messages
	$(".record-success").empty(); // Clear any previous success messages

	// Only these need to be validated, the rest of the input can have any character.
	var dateIsValid = checkDate(releaseDate, "Enter a valid date!", "#record-form .record-error");
	var genreIsValid = checkTextInput(genre, "Enter a valid genre!", "#record-form .record-error", textInputRegex);
	var labelIsValid = checkTextInput(label, "Enter a valid label!", "#record-form .record-error");
	var titleIsValid = checkTextInput(recordTitle, "Enter a valid record title!", "#record-form .record-error");

	// Check if all the input is valid
	if (artistName !== "-- Select --") {
		if (genreIsValid && dateIsValid) {
			// Post the data to the php file
			var posting = $.post(url, {
				a: artistName,
				t: recordTitle,
				r: releaseDate,
				g: genre,
				l: label
			});

			// The response of the php file consists of validation results similar to those in this file
			posting.done(function(data) {
				var messages = jQuery.parseJSON(data);
				var $errorMessages = $(".record-error").hide(); // Hide the errors div so that fade in works
				var $successMessages = $(".record-success").hide(); // Hide the success div so that fade in works
				jQuery.each(messages, function(key, val) {
					// Display any success or error messages
					if (key === "success") {
						$successMessages.append(val);
						$successMessages.fadeIn();
					}
					else {
						$errorMessages.append(val);
						$errorMessages.fadeIn();
					}
				})
			})
		}
	}
	else {
		var $recordError = $("#record-form .record-error").hide();
		var $error = $("<li>").text("Please select an artist.");
		$recordError.append($error);
		$recordError.fadeIn();
	}
}

var adminManagement = function() {
	var $form = $("#admin-form");
	var username = $form.find("select[name='admin-username']").val();

	var url = $form.attr("action");

	if (username !== "-- Select --") {
		var posting = $.post(url, {
			u: username
		});
	}

	posting.done(function(data) {
		var adminInfo = jQuery.parseJSON(data);
		var fname = adminInfo.fn;
		var lname = adminInfo.ln;
		var email = adminInfo.e;
		var regDate = adminInfo.rd.split(" ");
		var userLevel = adminInfo.ul;

		$("#admin-fname").val(fname);
		$("#admin-lname").val(lname);
		$("#admin-email").val(email);
		$("#reg-date").val(regDate[0]);
		if (userLevel === '1') {
			$("#slideThree").prop('checked', true);
		} else if (userLevel === '0'){
			$("#slideThree").prop('checked', false);
		}
	})

};

var userLevel = function() {
	var $form = $("#admin-form");
	var isChecked = $("#slideThree").prop('checked');
	var username = $form.find("select[name='admin-username']").val();
	var url = "update-user-level.php";
	$(".admin-error").empty(); // Clear any previous error messages
	$(".admin-success").empty(); // Clear any previous success messages
	
	if (username !== "-- Select --") {
		var posting = $.post(url, {
			c: isChecked,
			u: username
		});

		posting.done(function(data) {
			console.log(data);
			var messages = jQuery.parseJSON(data);
			var $errorMessages = $(".admin-error").hide(); // Hide the errors div so that fade in works
			var $successMessages = $(".admin-success").hide(); // Hide the success div so that fade in works
			jQuery.each(messages, function(key, val) {
				// Display any success or error messages
				if (key === "success") {
					$successMessages.append(val);
					$successMessages.fadeIn();
				}
				else {
					$errorMessages.append(val);
					$errorMessages.fadeIn();
				}
			});
		});
	}
}

// ---------------------------- VALIDATION METHODS ---------------------------- //

// A utility method to validate the year
var checkYear = function(year) {
	if ((isNaN(parseFloat(year)) && !isFinite(year)) || !year || parseFloat(year) > new Date().getFullYear() || (parseFloat(year) % 1 != 0)) {
		var $artistError = $("#artist-form .artist-error").hide();
		var $error = $("<li>").text("Enter a valid Year!");
		$artistError.append($error);
		$artistError.fadeIn();
		return false;
	}
	else {
		return true;
	}
}

// A utility method to validate all text input that requires validation
var checkTextInput = function(input, message, id, regex) {
	// Check if input is empty or does not match regex
	if (regex && (!input || !regex.test(input))) {
		var $errorLocation = $(id).hide();
		var $error = $("<li>").text(message);
		$errorLocation.append($error);
		$errorLocation.fadeIn();
		return false;
	}
	else if (!input) {
		var $errorLocation = $(id).hide();
		var $error = $("<li>").text(message);
		$errorLocation.append($error);
		$errorLocation.fadeIn();
	}
	else {
		return true;
	}
}

// A function to validate date format
var checkDate = function(input, message, id) {
	// Validates that the release date input string is a valid date formatted as "dd/mm/yyyy"
	var check = function(date) {
		// First check for the pattern
		if (!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(date))
			return false;

		// Parse the date parts to integers
		var parts = date.split("/");
		var day = parseInt(parts[0], 10);
		var month = parseInt(parts[1], 10);
		var year = parseInt(parts[2], 10);

		// Check the ranges of month and year
		if (year < 1000 || year > 3000 || month == 0 || month > 12)
			return false;

		var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

		// Adjust for leap years
		if (year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			monthLength[1] = 29;

		// Check the range of the day
		return day > 0 && day <= monthLength[month - 1];
	}

	if (!check(input)) {
		var $errorLocation = $(id).hide();
		var $error = $("<li>").text(message);
		$errorLocation.append($error);
		$errorLocation.fadeIn();
		return false;
	}
	else {
		return true;
	}
};

// ---------------------------- EVENT LISTENERS ---------------------------- //

// Attach a submit handler to the Add Artist form submission event
$("#artist-form").submit(function(event) {
	// Stop the form from submitting normally
	event.preventDefault();
	// Call the form handler function
	artistHandler();
})

// Attach a submit handler to the Add Record form submission event
$("#record-form").submit(function(event) {
	// Stop the form from submitting normally
	event.preventDefault();
	// Call the form handler function
	recordHandler();
})

$("#admin-info select[name='admin-username']").on("change", function() {
	// Get the info of the selected user 
	adminManagement();
})

$("#admin-form").submit(function(event) {
	// Stop the form from submitting normally
	event.preventDefault();
	// Call the form handler function
	userLevel();
})