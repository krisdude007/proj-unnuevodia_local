$(document).ready(function(){
 enlarged = false;

$('#imgMagnify').click(function () {
    $(this).stop(true, false).animate({
        width: enlarged ? 150 : 450,
        height: enlarged ? 100 : 280,
    }, 200);

    enlarged = !enlarged;
});
});