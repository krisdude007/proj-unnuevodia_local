$(document).ready(function () {
    var startDate = getStartDate();
    var endDate = getEndDate();
lineGrapher('userGraph', 'user','ajaxGetLineGraphData', startDate, endDate,  'total', null);
pieGrapher('videoGraph', 'video','ajaxGetGraphData', startDate, endDate, 'total');
barGrapher('tickerGraph', 'ticker','ajaxGetGraphData', startDate, endDate, 'total');
barGrapher('voteGraph', 'vote','ajaxGetGraphData', startDate, endDate, 'total');
pieGrapher('imageGraph', 'image','ajaxGetGraphData', startDate, endDate, 'total');
});

function boldCurrentLink(obj){
    var nodes = obj.parentNode.childNodes;
    for(var i = 0; i < nodes.length; i++){
        if(nodes[i].nodeName.toLowerCase() === 'a'){
            nodes[i].style.fontWeight = 'normal';
        }
    }
    obj.style.fontWeight = 'bold';
}

function graph(id, date){
    $("#"+id+"Graph").html('<img src="/core/webassets/images/spinner.gif" width="100" style="display: block;margin:0px auto;">');
    var request = $.ajax({
        url:"/adminReport/ajaxDashboardGraph",
        type:'POST',
        data:({
            metric:id,
            date:date,
            CSRF_TOKEN: getCsrfToken()
        }),
        success: function(data){
            $("#"+id+"Graph").html(data);
        },
        error: function(data){
            console.log('Unable to update analytics.');
        }
    });
}