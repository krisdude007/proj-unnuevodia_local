
$(document).ready(function() {
    gameRevelGridGetAjax(grid_id);
    gameControlHandlers();
    
    $('[id^="gridButton"]').on("click", function(e) {
        gameRevelGridSaveAjax(grid_id, parseInt($(this).attr('id').match(/\d+/)), 1);
    });
});

var gameControlHandlers = function() {
    $("#showAll").on("click").off('click');
    $("#showAll").on("click", function(e) {
        gameRevelGridSaveAjaxAll(grid_id, 1);
    });

    $("#hideAll").on("click").off('click');
    $("#hideAll").on("click", function(e) {
        gameRevelGridSaveAjaxAll(grid_id, 0);
    });
}

function gameRevelGridSaveAjaxAll(id, is_shown)
{
    for(i=1; i<=total_squares; i++)
    {
        gameRevelGridSaveAjax(id, i, is_shown);
    }
}

function gameRevelGridSaveAjax(id, grid_section, is_shown) {
    var formData = {grid_id:id, grid_section:grid_section, is_shown:is_shown};
    var request = $.ajax({
        url:"/adminGame/ajaxRevelGridSave",
        type:'POST',
        dataType: "json",
        data:$.param(formData),
        success: function(data){
            if(data.status == 'success')
            {
                if(data.is_shown == 1)
                {
                    $("#gridButton"+data.grid_section).addClass("buttonOpaque");
                }
                else
                {
                    $("#gridButton"+data.grid_section).removeClass("buttonOpaque");
                }
            }
        }
    });
}

function gameRevelGridGetAjax(id) {
    var formData = {grid_id:id};
    var request = $.ajax({
        url: "/game/ajaxRevealGridGet",
        type: 'POST',
        dataType: "json",
        data: formData,
        success: function(data){
            $.each(data, function(i) {
                  if(data[i].is_shown == 1)
                  {
                     $("#gridButton"+data[i].grid_section).addClass("buttonOpaque");
                  }
            });
        }
    });
}