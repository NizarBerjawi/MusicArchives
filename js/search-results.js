var displayResults = function() {
    var $input = $("#search").val();
    console.log($input);
	// var url = "search-result.php";  // The php file that will do the search
	
	var dataSet = [
    [ "Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800" ],
    [ "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750" ],
    [ "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000" ],
    [ "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060" ],
    [ "Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700" ],
    [ "Brielle Williamson", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000" ],
    [ "Herrod Chandler", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500" ]
    ];

    showTable(dataSet);
	// Post the data to the php file
/*	var posting = $.post(url, {i: $input});

	// The response of the php file consists of validation results similar to those in this file
	posting.done(function(data) {
		var searchResults = jQuery.parseJSON(data);
        showTable(searchResults);
    })*/
}

/* Show the table headers and data */
function showTable(dataset) {
    if ( $.fn.dataTable.isDataTable( '#search-table' )  ) {
        table.clear().draw();
        table.destroy();    // Destroy the table before it is initialized with new data.

        table = $('#search-table').DataTable({
            data: dataset,
            responsive: true,
            columns: [
            { title: "Convict ID" },
            { title: "First Name" },
            { title: "Last Name" },
            { title: "Place of Sentence" },
            { title: "Date of Sentence" },
            { title: "Term" }
            ]
        } );
        table.columns.adjust().draw();
        
    } else {
        table = $('#search-table').DataTable({
            data: dataset,
            responsive: true,
            columns: [
            { title: "Convict ID" },
            { title: "First Name" },
            { title: "Last Name" },
            { title: "Place of Sentence" },
            { title: "Date of Sentence" },
            { title: "Term" }
            ]
        } );
    }
}

/* Show the search results when Enter is clicked */
var search_Modal = $(".search-result-modal");
$("#search").on("keypress", function(event) {
	if (event.keyCode === 13) {
		displayResults();
	}
});