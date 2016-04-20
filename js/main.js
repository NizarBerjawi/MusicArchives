/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
	document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
}

/* This function looks for an element with an id of “nav” (presumably your navigation bar), then looks at each of the anchor tags inside it. It then compares the anchor tag’s href tag with the page’s URL. If the href tag is contained within the URL anywhere, it gives that link a class of “active,” which I can then style specially in my CSS.*/
function setActive() {
	menuItem = document.getElementsByClassName("topnav")[0].getElementsByTagName("a");
	for(i = 0; i < menuItem.length; i++) { 
		if(document.location.href.indexOf(menuItem[i].href)>=0) {
			menuItem[i].className="active";
		}
	}
}
window.onload = setActive;

/* This part uses JQuery to display a modal window when the Sign-in Button is clicked */
var modal = $('.modal');
$('.show-modal').click(function() {
	modal.fadeIn();
});

$('.close-modal').click(function() {
	modal.fadeOut();
});

/* add interactivity to the tab menu in the administrator's page */
$(document).ready(function(){
	$('div#txt_cont div:gt(0)').css('display', 'none');
	$('#tab-menu ul li a').click(function(event){
		event.preventDefault();
		var id_tab = $(this).attr('href');
		$('#tab-menu ul li a').removeClass('hover_tab');
		$(this).addClass('hover_tab');
		$('div.txt_tab:visible').hide();
		$(id_tab).show('slide');
	});
});