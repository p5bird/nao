$( "#toggle-sidebar" ).click(function() {
        if ($('#sidebar.col-md-2').length !== 0) {
            $('#sidebar').addClass('col-md-1').removeClass('col-md-2');
            $('#user-interface-page-content').addClass('col-md-11').removeClass('col-md-10');
        } else {
            $('#sidebar').removeClass('col-md-1').addClass('col-md-2');
            $('#user-interface-page-content').removeClass('col-md-11').addClass('col-md-10');
        }
});