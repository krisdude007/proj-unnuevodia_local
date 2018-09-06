$(document).ready(function () {
    App.init(); // init the rest of plugins and elements

    $("ul#fab-collapsed li.fab-first").click(function () {

        if ($('#fab-nav-collapsed').hasClass('fab-small')) {

            $('.fab-text').css('display', 'block');
            $('#fab-nav-collapsed').removeClass('fab-small');
            $('#fab-nav-collapsed').addClass('fab-large');
            $('.fab-page-content').css('margin-left', '107px');


        } else if ($('#fab-nav-collapsed').hasClass('fab-large')) {

            $('.fab-text').css('display', 'none');
            $('#fab-nav-collapsed').removeClass('fab-large');
            $('#fab-nav-collapsed').addClass('fab-small');
            $('.fab-page-content').css('margin-left', '51px');

        }
    });

    // workaround for webkit browsers
    $(".fab-nav-collapse").on('shown',function () {
        $(this).removeClass("collapse");
    }).on('hidden', function () {
        $(this).removeClass("collapse");
    });

});
