// Add an event listener to the icon that appears in the navigation menu when screen is minimized. 
// Toggle between adding and removing the "responsive" class to .topnav when the user clicks on the icon.
$(".icon").on("click", function() {
	$(".topnav")[0].classList.toggle("responsive");
	return false;
});

// This function compare the href of each a tag inside the navigation bar with the page's URL.
// If the href is in the URL then it sets the class of that link to "active".
function setActive() {
	menuItem = $(".topnav a");	// Select all anchor tags from the navigation menu
	for(i = 1; i < menuItem.length - 2 ; i++) { 
		if(document.location.href.indexOf(menuItem[i].href)>=0) {
			menuItem[i].className="active";
		}
	}
}

/* Display a modal window when the Sign-in Button is clicked */
var modal = $(".modal");
$(".show-modal").on("click", function() {
	modal.fadeIn();
});

/* Hide the modal window when the sign-in close button is clicked */
$(".close-modal").on("click", function() {
	modal.fadeOut();
});

/* Display a modal window when 'Enter' is pressed on the Search input */
var search_Modal = $(".search-result-modal");
$("#search").on("keypress", function(event) {
	if (event.keyCode === 13) {
		search_Modal.fadeIn();
	}
});

/* Hide the search results window when the close button is clicked */
$(".close-modal").on("click", function() {
	search_Modal.fadeOut();
});

$(document).ready(setActive);