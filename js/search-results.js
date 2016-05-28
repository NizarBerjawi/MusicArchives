var displayResults = function() {
    var $input = $("#search").val();
    var url = "main-search.php";  // The php file that will do the search

    // Post the data to the php file
    var posting = $.post(url, {i: $input});

    // The response of the php file consists of the search results
    posting.done(function(data) {
        if (data) {
            var searchResults = jQuery.parseJSON(data);
            showTable(searchResults);
        } else {
            var searchResults = [];
            showTable(searchResults);
        }

    })
}

// Show the table headers and data
function showTable(dataset) {
    // Check if the DataTable is already initialized
    if ( $.fn.dataTable.isDataTable( '#search-table' )  ) {

        table.clear().draw();
        table.destroy();    // Destroy the table before it is initialized with new data.

        table = $('#search-table').DataTable({
            data: dataset,
            responsive: true,
            columns: [
            { title: "Artist" },
            { title: "Country" },
            { title: "Year Formed" },
            { title: "Genre" },
            { title: "Total Albums" }
            ]
        } );
        table.columns.adjust().draw();
        
    } else {
        table = $('#search-table').DataTable({
            data: dataset,
            responsive: true,
            columns: [
            { title: "Artist" },
            { title: "Country" },
            { title: "Year Formed" },
            { title: "Genre" },
            { title: "Total Albums" }
            ]
        } );
    }
}

$("#search").on("keypress", function(e) {
    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
    if (event.keyCode === 13) {
        e.preventDefault();
        $("body").append(appendthis);
        $(".modal-overlay").fadeTo(500, 0.7);
        var modalBox = $(this).attr('data-modal-id');
        $('#'+modalBox).fadeIn($(this).data()); 
        displayResults();
    }
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