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