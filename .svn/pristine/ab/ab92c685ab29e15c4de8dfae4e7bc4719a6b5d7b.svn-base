/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var datePicker = function() {
    $('#clientUser_birthday').off('focus');
    $('#clientUser_birthday').on('focus', function(e) {
        e.preventDefault();
        $(this).attr('type', 'date');
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $(this).val(today);
    });
    $('#clientUser_birthday').off('blur');
    $('#clientUser_birthday').on('blur', function(e) {
        e.preventDefault();
        $(this).attr('type', 'text');

    });
}

var overlayHandlersForRecordMob = function(id, q) {

    //alert ('question: '+ q);
    $('.overlayBackGroundMob').fadeIn();
    $('#login').attr('href', '/login');
    $('#record').attr('href', '/record?id=' + id + '&question=' + encodeURIComponent(q));
    $('#upload').attr('href', '/video/videoupload?id=' + id + '&question=' + encodeURIComponent(q));
    $('.overlayPopupCloseMob').click(function() {
        $('.overlayBackGroundMob').fadeOut(200, "linear");
    });
}

var overlayHandlersForRecord = function(id) {
    //alert ('id: '+ id);
    $('.dimQuestions').fadeIn();
    $('#record').attr('href', '/record?id=' + id);
    $('#upload').attr('href', '/videoupload?id=' + id);
    $('button').click(function() {
        $('.dimQuestions').fadeOut(200, "linear");
    });
}

jQuery(document).ready(function() {
    datePicker();
    overlayHandlersForRecord();
    //voteHandlers();
    $('.sidebar a').each(function(i, e) {
        $(e).removeClass('activePage');
        if (window.location.toString().match($(e).attr('href') + '$')) {
            $(e).addClass('activePage');
        }
    });
});

