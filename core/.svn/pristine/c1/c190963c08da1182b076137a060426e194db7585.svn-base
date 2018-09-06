$( "#startDateFilter" ).datepicker({ dateFormat: "yy-mm-dd" });
$( "#endDateFilter" ).datepicker({ dateFormat: "yy-mm-dd" });

$("#reportButton").click(function(){
    var url = "/adminReport/index";
    if($("#startDateFilter").val() != '')
        url += "/startDate/" + $("#startDateFilter").val();
    else
        url += "/startDate/total";
    if($("#endDateFilter").val() != '')
        url += "/endDate/" + $("#endDateFilter").val();
    window.location.href = url;
});