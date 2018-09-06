

$(document).ready(function() {

    uploadFileHandlerManual();
    uploadFileHandlerSchedule();

    $(".trainingVideoTrigger").click(function(e) {
        e.preventDefault();
        var videoUrl = $(this).attr('href');
        var imageUrl = $(this).find('img').attr('src');

        // update flashvars
        var flavhVars = 'file=' + videoUrl + '&image=' + imageUrl + '&controlbar=none&dock=false&autostart=false&stretching=exactfit';

        $("object param[name='flashvars']").attr("value", flavhVars);
        $("embed").attr("flashvars", flavhVars);

        // create new object to hold it
        var obj = $("object");

        // remove existing Flash from DOM
        $("object").remove();

        // add new HTML to DOM
        $("#player").append(obj);
    });
});

var uploadFileHandlerManual = function() {


    var fileUploadTrigger = $("#fileUploadOverlayManual").overlay({
        mask: '#000',
        effect: 'default',
        top: 25,
        closeOnClick: true,
        closeOnEsc: true,
        fixed: true,
        oneInstance: true,
        api: true
    });

    $('#fab-upload-manual-button').off('click');
    $('#fab-upload-manual-button').on('click',function(e){
        e.preventDefault();
        $("#fileUploadOverlayManual").overlay().load();
    });

}

var uploadFileHandlerSchedule = function() {


    var fileUploadTrigger = $("#fileUploadOverlaySchedule").overlay({
        mask: '#000',
        effect: 'default',
        top: 25,
        closeOnClick: true,
        closeOnEsc: true,
        fixed: true,
        oneInstance: true,
        api: true
    });

    $('#fab-upload-schedule-button').off('click');
    $('#fab-upload-schedule-button').on('click',function(e){
        e.preventDefault();
        $("#fileUploadOverlaySchedule").overlay().load();
    });

}
