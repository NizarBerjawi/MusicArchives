var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var password = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;

var loginHandler = function() {
	var $form = $("#login-form");
	var email = $form.find("input[name='email']").val();
	var pass = $form.find("input[name='password']").val();
	var url = $form.attr("action");

	$("#login-error").empty(); // Clear any previous error messages

	// Validate all the input in the form
	var emailIsValid = loginValidation(email, "Enter a valid email!", emailRegex);
	var passIsValid = loginValidation(pass, "Password is not valid!", password);

	// Check if all the input is valid
	if (emailIsValid && passIsValid) {
		// Post the data to the php file
		var posting = $.post(url, {
			e: email,
			p: pass
		});

		// The response of the php file consists of validation results similar to those in this file
		posting.done(function(data) {
			var messages = jQuery.parseJSON(data);

			if (messages.error) {
				var $errorMessages = $("#login-error").hide(); // Hide the errors div so that fade in works
				// Display any error messages received from login.php
				jQuery.each(messages, function(key, val) {
					if (key !== 'error') {
						$errorMessages.append(val);
						$errorMessages.fadeIn();
					}
				})
			}
			else {
				// If login is successful, then reload the page
				location.reload();
			}
		})
	}
}

// A function to validate the user's input other than the password
var loginValidation = function(input, message, regex) {
	var $errorMessage = $("#login-error");
	// Check if input is empty or does not match regex
	if (!input || !regex.test(input)) {
		var $errorMessage = $("#login-error").hide();
		var $errorList = $("<li>").text(message);
		$errorMessage.append($errorList);
		$errorMessage.fadeIn();
		return false;
	}
	else {
		return true;
	}
}

// Attach a submit handler to the registration form submission event
$("#login-form").submit(function(event) {
	// Stop the form from submitting normally
	event.preventDefault();
	// Call the login handler function
	loginHandler();
})
