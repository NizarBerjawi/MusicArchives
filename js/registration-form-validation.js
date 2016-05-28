// A set of regular expressions (regex) used to validate input. 
var nameRegex = /^[a-zA-Z][a-zA-Z\-'\s]{0,43}$/;
var usernameRegex = /^[a-z][a-z0-9_\.]{0,24}$/i;
var emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;

// A function to handle form submission and validation
var formHandler = function() {
	var $form = $("#registration");
	var fname = $form.find("input[name='fname']").val();
	var lname = $form.find("input[name='lname']").val();
	var email = $form.find("input[name='email']").val();
	var username = $form.find("input[name='username']").val();
	var pass1 = $form.find("input[name='password']").val();
	var pass2 = $form.find("input[name='password-confirm']").val();
	var url = $form.attr("action");

	$(".error-message").empty(); // Clear any previous error messages
	$(".success-message").empty(); // Clear any previous success messages

	// Validate all the input in the form
	var fnIsValid = inputValidation(fname, "Enter a valid first name!", nameRegex);
	var lnIsValid = inputValidation(lname, "Enter a valid last name!", nameRegex);
	var usrIsValid = inputValidation(username, "Enter a valid username!", usernameRegex);
	var emailIsValid = inputValidation(email, "Enter a valid email!", emailRegex);
	var passIsValid = passwordValidation(pass1, pass2, "Password is not valid!", "Passwords don't match!", passwordRegex);


	// Check if all the input is valid
	if (fnIsValid && lnIsValid && usrIsValid && emailIsValid && passIsValid) {

		// Post the data to the php file
		var posting = $.post(url, {
			fn: fname,
			ln: lname,
			e: email,
			u: username,
			p1: pass1,
			p2: pass2
		});

		// The response of the php file consists of validation results similar to those in this file
		posting.done(function(data) {
			console.log(data);
			var messages = jQuery.parseJSON(data);
			var $errorMessages = $(".error-message").hide(); // Hide the errors div so that fade in works
			var $successMessages = $(".success-message").hide(); // Hide the success div so that fade in works
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

// A function to validate the user's input other than the password
var inputValidation = function(input, message, regex) {
	var $errorMessage = $(".error-message");

	// Check if input is empty or does not match regex
	if (!input || !regex.test(input)) {
		var $errorMessage = $(".error-message").hide();
		var $errorList = $("<li>").text(message);
		$errorMessage.append($errorList);
		$errorMessage.fadeIn();
		return false;
	}
	else {
		return true;
	}
}

// A function to validate the user's password. It checks if the password is valid
// using the inputValidation function, then checks if the two passwords match
var passwordValidation = function(pass1, pass2, msg1, msg2, regex) {
	// Check if password is valid and display any error message.
	var isValid = inputValidation(pass1, msg1, regex);

	if (isValid && (pass1 === pass2)) {
		return true;
	}
	else if (isValid && (pass1 !== pass2)) {
		var $errorMessage = $(".error-message").hide();
		var $errorList = $("<li>").text(msg2);
		$errorMessage.append($errorList);
		$errorMessage.fadeIn();
		return false;
	}
	else {
		return false;
	}
}

// Attach a submit handler to the registration form submission event
$("#registration").submit(function(event) {
	// Stop the form from submitting normally
	event.preventDefault();
	// Call the form handler function
	formHandler();
})