var explore = function() {
    
    // Check if the user left one of the filters empty; 
    // If yes, treat it as if all were selected in that filter
    var checkInput = function(filters) {
        if (!filters.val()) {
            var optionValues = [];
            filters.children().each(function() {
                optionValues.push($(this).html());
            });

            return optionValues;
        } else {
            return filters.val();
        }
    }
   
    var genres = checkInput($("#genres"));
    var years = checkInput($("#years"));
    var countries = checkInput($("#countries"));
    var labels = checkInput($("#labels"));
    
    
	var url = "explore-search.php";  // The php file that will do the advanced search

	// Post the data to the php file
	var posting = $.post(url, {g: genres, y: years, c: countries, l: labels});

	// The response of the php file consists of the advanced search results
	posting.done(function(data) {
	    if (data) {
            var searchResults = jQuery.parseJSON(data);
            showResult(searchResults);
        } else {
            var searchResults = [];
            showResult(searchResults);
        }
    })
}

// Show the table headers and data
function showResult(dataset) {
    // Check if the DataTable is already initialized
    if ( $.fn.dataTable.isDataTable( '#explore-table' )  ) {

        table.clear().draw();
        table.destroy();    // Destroy the table before it is initialized with new data.

        table = $('#explore-table').DataTable({
            data: dataset,
            responsive: true,
            lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
            columns: [
            { title: "Record Title" },
            { title: "Artist" },
            { title: "Release Date" },
            { title: "Genre" },
            { title: "Label" },
            { title: "Country" }
            ]
        } );
        table.columns.adjust().draw();
        
    } else {
        table = $('#explore-table').DataTable({
            data: dataset,
            responsive: true,
            lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
            columns: [
            { title: "Record Title" },
            { title: "Artist" },
            { title: "Release Date" },
            { title: "Genre" },
            { title: "Label" },
            { title: "Country"}
            ]
        } );
    }
}

$("#submit-filter").on("click", function(e) {
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
    e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    var modalBox = $(this).attr('data-modal-id');
    $('#'+modalBox).fadeIn($(this).data());	
    explore();
});

$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
});

$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});

$(window).resize();