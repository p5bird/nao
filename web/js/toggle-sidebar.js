$( document ).ready(function() {
// Toggle sidebar disposition
    $("#toggle-sidebar").click(function () {
        if ($('#sidebar.col-md-2').length !== 0) {
            $('#sidebar').addClass('col-md-1').removeClass('col-md-2');
            $('#user-interface-page-content').addClass('col-md-11').removeClass('col-md-10');
            $('i.fas.fa-angle-right').css('display', 'none');
            $('.navbar-user-username').css('padding', '13px 0 0 30px');
            $('.navbar-user-group').css('padding-left', '30px')
        } else {
            $('#sidebar').removeClass('col-md-1').addClass('col-md-2');
            $('#user-interface-page-content').removeClass('col-md-11').addClass('col-md-10');
            $('i.fas.fa-angle-right').css('display', 'inline-block');
            $('.navbar-user-username').css('padding', '13px 0 0 0');
            $('.navbar-user-group').css('padding-left', '0px')
        }
    });

// Toggle arrow icons
    $('li.menu-dropdown').click(function () {

        var arrow = $(this).find('a>span>i');

        if (arrow.hasClass('fa-angle-right')) {
            $(this).find('.fa-angle-right').addClass('fa-angle-down').removeClass('fa-angle-right');
        } else {
            $(this).find('.fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-right');
        }
    });
});