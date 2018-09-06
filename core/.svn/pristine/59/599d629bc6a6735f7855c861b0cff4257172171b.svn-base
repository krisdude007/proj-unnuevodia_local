var pageHandlers = function() {
    $('#tab-schedule-history .yiiPager a').each(function(index, value) {
        $(this).on('click', function(e) {
            $("#tab-schedule-history").load($(this).attr('href'), function(response, status, xhr) {
                if (status == "error") {
                    var msg = "Sorry but there was an error loading history: ";
                    alert(msg + xhr.status + " " + xhr.statusText);
                    return;
                }
                else {
                    $.getScript("/core/webassets/js/adminVideo/videoSchedulerModalHistory.js");
                }
            });
            return false;
        });
    });
};
$(document).ready(function() {
    pageHandlers();
});

