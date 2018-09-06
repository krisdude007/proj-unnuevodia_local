
var tabHandlers = function() {
    $('#videoSchedulerModalTabs').tabs();
    $("#tabHistoryTrigger").click(function(e) {
        $("#tab-schedule-history").load("/adminVideo/videoSchedulerModalHistory", function(response, status, xhr) {
            if (status == "error") {
                var msg = "Sorry but there was an error loading history: ";
                alert(msg + xhr.status + " " + xhr.statusText);
                return;
            }
            else {
                $.getScript("/core/webassets/js/adminVideo/videoSchedulerModalHistory.js");
            }
        });
        /*
         */
    });
};

var datePickerHandler = function() {
    // datepickers for datestart datestop on video filters
    $('#datepickerVideoSchedulerFilter').datepicker({
        //maxDate: "0"
    });
}


var spotHandlers = function() {
    $('.spotButton').click(function(event) {
        //console.log('test');
    });
}

var showTable;
var spotTable;
var fillSpotHtml = '<button class="spotTrigger" onclick="fillSpot(NETWORK_SHOW_SCHEDULE_ID)">+</button>';
var unfillSpotHtml = '<button class="spotTrigger" onclick="unfillSpot(NETWORK_SHOW_SCHEDULE_ID)">-</button>';
var spotThumbnail = '<img id="spotVideoThumbnail" alt="video-image" src="SPOT_THUMBNAIL_SRC">';
var iconGreen = '<div class="fab-green-button"></div>';
var iconYellow = '<div class="fab-yellow-button"></div>';
var iconRed = '<div class="fab-red-button"></div>';


$(document).ready(function() {
    tabHandlers();
    datePickerHandler();
    networkScheduleTableHandler();
});


function fillSpot(network_show_schedule_id) {

    // add video and user id to spot and set saved on = NOW()
    video_id = $('#selectedVideoId').html();

    if (video_id == '') {
        alert('In order to fill this spot, you must first click the "filmstrip" icon on a video.');
    } else {
        // fire off ajax req to /adminVideo/ajaxVideoFillNetworkSpot
        var request = $.ajax({
            url: '/adminVideo/ajaxVideoFillNetworkSpot',
            type: 'POST',
            data: ({
                'network_show_schedule_id': network_show_schedule_id,
                'video_id': video_id,
                'CSRF_TOKEN': getCsrfToken()
            }),
            success: function(data) {
                // notify user and refresh spot table
                spotTable.fnReloadAjax();
                alert('Spot has been filled and the video has been sent to flip.');
            },
            error: function(data) {
                alert('Unable to fill spot.');
                return false;
            }
        });


    }
}

function unfillSpot(network_show_schedule_id) {
    // remove video id and user id from spot and set saved on = 0000-00-00 00:00:00
    // fire off ajax req to /adminVideo/ajaxVideoUnfillNetworkSpot
    var request = $.ajax({
        url: '/adminVideo/ajaxVideoUnfillNetworkSpot',
        type: 'POST',
        data: ({
            'network_show_schedule_id': network_show_schedule_id,
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {

            // notify user and refresh spot table
            spotTable.fnReloadAjax();
            alert('Spot cleared!');
        },
        error: function(data) {
            alert('Unable to open spot.');
            return false;
        }
    });

}

function networkScheduleTableHandler() {
    showTable = initNetworkShowTable('FS', null);

    $('#datatableScheduler tbody').click(function(event) {

        $(showTable.fnSettings().aoData).each(function() {
            $(this.nTr).removeClass('row_selected');
        });
        $(event.target.parentNode).addClass('row_selected');

    });


    $('#videoSchedulerRefresh').click(function(event) {

        event.preventDefault();
        var network_show_id = $('#showPickerVideoSchedulerFilter').val();

        if (network_show_id == '0') {
            network_show_id = null;
        }

        initNetworkShowTable('FS', network_show_id);
    });
}



function rowClickHandler() {
    $('#datatableScheduler tbody tr').off('click');
    $('#datatableScheduler tbody tr').on('click', function(event) {

        var aPos = showTable.fnGetPosition(this);
        var aData = showTable.fnGetData(aPos);
        var show_title = aData[1];
        var show_date = aData[2] + ' ' + aData[3];
        var show_on = aData[6];
        var network_show_id = aData[7];
        var spot_type = aData[8];

        // set selected show name
        $('#selectedShowName').text(show_title + ' ' + show_date);
        $('#datatableSpotScheduler').show();
        spotTable = initNetworkSpotTable(show_on, spot_type, network_show_id);
    });
}

function initNetworkShowTable(spot_type, network_show_id)
{
    $('#datatableSpotScheduler').hide();

    if (typeof showTable != 'undefined') {
        showTable.fnDestroy();
    }

    network_show_str = '';
    if (network_show_id != null) {
        network_show_str = '&network_show_id=' + network_show_id;
    }

    return  $('#datatableScheduler').dataTable({
        "bProcessing": true,
        "sScrollY": "185px",
        "bPaginate": false,
        "sAjaxSource": '/adminVideo/ajaxVideoGetNetworkShowSchedule?spot_type=' + spot_type + network_show_str,
        "bFilter": false,
        "bSort": false,
        "bRetrieve": true,
        "fnDrawCallback": function(oSettings) {
            rowClickHandler();
        },
        "fnRowCallback": function(row, column, iDisplayIndex, iDisplayIndexFull) {

            // todo - consolodate this!
            insertedHtml = '';
            switch (column[0]) {
                case 'green':
                    insertedHtml = iconGreen;
                    break;
                case 'yellow':
                    insertedHtml = iconYellow;
                    break;
                case 'red':
                    insertedHtml = iconRed;
                    break;
            }

            $("td:eq(0)", row).html(insertedHtml);

        },
        "aoColumns": [
            {
                "sWidth": "5%" // color
            },
            {
                "sWidth": "20%" // network show name
            },
            {
                "sWidth": "20%" // run date
            },
            {
                "sWidth": "20%" // run time
            },
            {
                "sWidth": "20%"  // slots
            },
            {
                "sWidth": "20%"  // time remaining
            },
            {
                "bVisible": false // show_on
            },
            {
                "bVisible": false // show id
            },
            {
                "bVisible": false // spot type
            },
            {
                "bVisible": false // id
            },
        ]
    });
}


function initNetworkSpotTable(show_on, spot_type, network_show_id) {

    if (typeof spotTable != 'undefined') {
        spotTable.fnDestroy();
    }

    return  $('#datatableSpotScheduler').dataTable({
        "bProcessing": true,
        "sScrollY": "185px",
        "bPaginate": false,
        "sAjaxSource": '/adminVideo/ajaxVideoGetNetworkSpotSchedule?show_on=' + show_on + '&spot_type=' + spot_type + '&network_show_id=' + network_show_id,
        "bFilter": false,
        "bSort": false,
        "bRetrive": true,
        "bDestroy": true,
        "fnRowCallback": function(row, column, iDisplayIndex, iDisplayIndexFull) {

            // todo - consolodate this!
            switch (column[1]) {
                case 0:
                    insertedHtml = fillSpotHtml.replace("NETWORK_SHOW_SCHEDULE_ID", column[9]);
                    break;
                case 1:
                    insertedHtml = unfillSpotHtml.replace("NETWORK_SHOW_SCHEDULE_ID", column[9]);
                    break;
            }

            $("td:eq(1)", row).html(insertedHtml);

            // insert thumbnail if available
            if (column[11] != null && column[11] != '') {
                insertedImage = spotThumbnail.replace("SPOT_THUMBNAIL_SRC", column[11]);
                $("td:eq(2)", row).html(insertedImage + ' ' + column[2]);
            }

        },
        "aoColumns": [
            {
                "sWidth": "1%" // pos
            },
            {
                "sWidth": "4%" // action
            },
            {
                "sWidth": "20%" // file
            },
            {
                "sWidth": "15%" // producer
            },
            {
                "sWidth": "15%" // run time
            },
            {
                "sWidth": "5%" // length
            },
            {
                "sWidth": "5%" // time left
            },
            {
                "sWidth": "10%" // house #
            },
            {
                "sWidth": "25%" // save time
            },
            {
                "bVisible": false // network show schedule id
            },
            {
                "bVisible": false // video id
            },
            {
                "bVisible": false // video thumbnail
            },
        ]
    });
}



$.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw)
{
    if (sNewSource !== undefined && sNewSource !== null) {
        oSettings.sAjaxSource = sNewSource;
    }

    // Server-side processing should just call fnDraw
    if (oSettings.oFeatures.bServerSide) {
        this.fnDraw();
        return;
    }

    this.oApi._fnProcessingDisplay(oSettings, true);
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams(oSettings, aData);

    oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable(oSettings);

        /* Got the data - add it to the table */
        var aData = (oSettings.sAjaxDataProp !== "") ?
                that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

        for (var i = 0; i < aData.length; i++)
        {
            that.oApi._fnAddData(oSettings, aData[i]);
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

        that.fnDraw();

        if (bStandingRedraw === true)
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd(oSettings);
            that.fnDraw(false);
        }

        that.oApi._fnProcessingDisplay(oSettings, false);

        /* Callback user function - for event handlers etc */
        if (typeof fnCallback == 'function' && fnCallback !== null)
        {
            fnCallback(oSettings);
        }
    }, oSettings);
};


$.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw)
{
    if (sNewSource !== undefined && sNewSource !== null) {
        oSettings.sAjaxSource = sNewSource;
    }

    // Server-side processing should just call fnDraw
    if (oSettings.oFeatures.bServerSide) {
        this.fnDraw();
        return;
    }

    this.oApi._fnProcessingDisplay(oSettings, true);
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams(oSettings, aData);

    oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable(oSettings);

        /* Got the data - add it to the table */
        var aData = (oSettings.sAjaxDataProp !== "") ?
                that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

        for (var i = 0; i < aData.length; i++)
        {
            that.oApi._fnAddData(oSettings, aData[i]);
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

        that.fnDraw();

        if (bStandingRedraw === true)
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd(oSettings);
            that.fnDraw(false);
        }

        that.oApi._fnProcessingDisplay(oSettings, false);

        /* Callback user function - for event handlers etc */
        if (typeof fnCallback == 'function' && fnCallback !== null)
        {
            fnCallback(oSettings);
        }
    }, oSettings);
};