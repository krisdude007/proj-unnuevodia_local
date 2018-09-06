$(function() {
  $( "#weekSelect" ).datepicker({ dateFormat: "yy-mm-dd" });
  $("#reportButton").click(function(){
      if($("#weekSelect").val() != "")
          window.location.href = "/adminReport/weeklyReport/startDate/" + $("#weekSelect").val();
  });
});