// global js

$(document).ready(function () {
    
    var numNotifications = $('#numNotifications').html();
    if(numNotifications > 0) {

        playNotificationSound();
        var notificationIcon = $('.fab-notifications');
        var notificationCount = $("#notificationCount");
        function fadeNotificationIcon() {
            notificationIcon.animate({
                opacity:'+=1'
            }, 1000);
            notificationCount.animate({
                opacity:'+=1'
            }, 1000);
            notificationIcon.animate({
                opacity:'-=0.75'
            }, 1000);
            notificationCount.animate({
                opacity:'-=0.75'
            }, 1000, fadeNotificationIcon);
        }
        fadeNotificationIcon();
    }
});


function playNotificationSound() {
    audio = document.getElementsByTagName("audio")[0];
    audio.play();
}

function getCsrfToken(){
    return $("#csrfToken").html();
}

function getEndDate(){
    return $("#endDate").html();
}

function getStartDate(){
    return $("#startDate").html();
}