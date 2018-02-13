$(document).ready(function() {
    // When something is typed in search
    $('#system-search').keyup( function() {
        var that = this;
        var tableBody = $('.list-users-table tbody');
        var tableRow = $('.list-users-table tbody tr');
        $('.search-nothing').remove();

        tableRow.each(function(i, val) {

            //Lower text for case sensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();

            if (inputText !== '') {
                $('.search-value').remove();
                tableBody.prepend('<tr class="search-value"><td class="search"><strong>Recherche de: "'
                    + $(that).val()
                    + '"</strong></td></tr>');
            } else {
                $('.search-value').remove();
            }

            if ( rowText.indexOf( inputText ) === -1 ) {
                // Hide rows
                tableRow.eq(i).hide();
            } else {
                $('.search-nothing').remove();
                tableRow.eq(i).show();
            }
        });

        // Hide all rows
        if (tableRow.children(':visible').length === 0) {
            tableBody.append('<tr class="search-nothing"><td class="text-muted">Aucun résultat trouvé.</td></tr>');
        }
    });
});