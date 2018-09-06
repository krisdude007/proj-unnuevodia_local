var getCsrfToken = function() {
    return $("#csrfToken").html();
}

function getGraphDataForTV(pID) {
    var request = $.ajax({
        url: "/poll/ajaxGetData",
        type: 'POST',
        data: ({
            'id': pID,
            'CSRF_TOKEN': getCsrfToken()
        }),
        dataType: 'json',
        success: function(data) {
            $.each(data.values, function(index, value) {
                var label = $('.percent').get(index);
                $(label).text(value + '%');
                var bar = $('.progress-bar').get(index);
                $(bar).width(value + '%');
            })

        }
    });
}



var voteHandlersForTV = function() {

    $('.voteAgain').off('click');
    $('.voteAgain').on('click', function(e) {
        e.preventDefault();
        $('.afterVote').toggle();
    });
    $('.voteButton').off('click');
    $('.voteButton').on('click', function(e) {
        e.preventDefault();
        var request = $.ajax({
            type: 'POST',
            url: '/poll/ajaxResponse',
            data: ({
                'CSRF_TOKEN': getCsrfToken(),
                'answer': $(this).attr('rel'),
                'source': 'web'
            }),
            success: function(data) {
                $('.afterVote').toggle();
                getGraphDataForTV($('.afterVote').attr('rel'));
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });
}

function getGraphData(pID) {
    var request = $.ajax({
        url: "/poll/ajaxGetData",
        type: 'POST',
        data: ({
            'id': pID,
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {
            var data = $.parseJSON(data);
            $.each(data.labels, function(i, e) {
                drawGraph('cvs' + i, [data.values[i]], [data.labels[i]], [data.colors[i]]);
            });
        }
    });
}

function drawGraph(canvas, v, l, c) {
    console.log(canvas);
    console.log(v);
    console.log(l);
    console.log(c);
    RGraph.Clear(document.getElementById(canvas));
    var graph = new RGraph.HBar(canvas, v);
    console.log(graph);
    graph.Set('chart.labels', l);
    graph.Set('chart.colors', c);
//    graph.Set('chart.units.post', '%');
//    graph.Set('chart.labels.above', true);
    graph.Set('chart.xmax', 100);
    graph.Set('chart.background.barcolor1', 'transparent');
    graph.Set('chart.background.barcolor2', 'transparent');
    graph.Set('chart.text.size', 17);
    graph.Set('chart.text.color', 'white');
    graph.Set('chart.strokestyle', 'white');
    graph.Set('chart.xlabels', false);
    graph.Set('chart.gutter.left', 0);
    graph.Set('chart.gutter.top', 0);
    graph.Set('chart.gutter.bottom', 0);
    graph.Set('chart.background.grid', false);
    graph.Set('chart.colors.sequential', true);
    graph.Set('chart.noaxes', true);
    graph.Set('chart.axis.color', 'transparent');
    graph.Draw();
}

var sliderHandler = function(speed) {

    var slider_w = 0;

    $('#sliderContainer .sliders').css('left', $(window).width() + 'px');

    $('#sliderContainer .sliders .slider').each(function(i, e) {
        slider_w = slider_w + $(this).width() + 60;
    });

    $('#sliderContainer .sliders').css('width', slider_w + 'px');
    $('#sliderContainer .sliders').animate({
        left: -$(".sliders").width()},
    {duration: slider_w * speed,
        easing: "linear",
        complete: function() {
            sliderHandler(speed);
        }
    });
}

var sliderHandlerReverse = function(speed) {

    var slider_w = 0;
    $('#sliderContainer .slidersRev .sliderRev').each(function(i, e) {
        slider_w = slider_w + $(this).width() + 60;
    });

    $('#sliderContainer .slidersRev').css('left', -slider_w + 'px');//

    $('#sliderContainer .slidersRev').css('width', slider_w + 'px');
    $('#sliderContainer .slidersRev').animate({
        left: $(window).width()},
    {duration: slider_w * speed,
        easing: "linear",
        complete: function() {
            sliderHandlerReverse(speed);
        }
    });
}

jQuery(document).ready(function() {
    voteHandlersForTV();
    sliderHandler($('#slide_speed').val());
    sliderHandlerReverse($('#slide_speed').val());
});