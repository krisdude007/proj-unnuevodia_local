$(document).ready(function() {
    editHandler();
    createCounters();
});

var createCounters = function() {
    $('input.counter').each(function(i, e) {
        $(e).parent().append($('<div></div>').attr({'id': 'counter_' + $(e).attr('id')}));
        $('#counter_' + $(e).attr('id')).text($(e).attr('maxlength') + ' characters remaining.');
        $(e).on('keyup', function() {
            updateCount(this)
        });
        $(e).on('blur', function() {
            adjustMaxLength(this, 'blur')
        });
        $(e).on('focus', function() {
            adjustMaxLength(this, 'focus')
        });
    });
}

var adjustMaxLength = function(el, event) {
    var classes = $(el).attr('class').split(/ /);
    $.each(classes, function(i, e) {
        if (e.match('linkTo')) {
            if (event == 'focus') {
                var maxlength = parseInt($('#' + e.replace(/linkTo/, '')).attr('maxlength')) + parseInt($(el).val().length);
                $('#' + e.replace(/linkTo/, '')).attr({'maxlength': maxlength});
            } else {
                var maxlength = $('#' + e.replace(/linkTo/, '')).attr('maxlength') - $(el).val().length;
                $('#' + e.replace(/linkTo/, '')).attr({'maxlength': maxlength});
                $('#' + e.replace(/linkTo/, '')).trigger('keyup');
            }
        }
    });
}

var updateCount = function(el) {
    var l = $(el).attr('maxlength') - $(el).val().length;
    $('#counter_' + $(el).attr('id')).css({'color': 'black'}).text(l + ' characters remaining.');
    if (l < 0) {
        $('#counter_' + $(el).attr('id')).css({'color': 'red'}).text('Over character limit!');
    }
}

var editHandler = function(){
    $('.setGameState').off('click');
    $('.setGameState').on('click',function(e){
        e.preventDefault();
        
        var obj = new Object;
        obj.column = 'is_active';
        obj.value = $(this).attr('rev');
        obj.id = $(this).attr('rel');
        obj.CSRF_TOKEN = getCsrfToken();
        if(confirm('Are you sure you wish to make this edit?')){
            var request = $.ajax({
                url:"/adminGame/saveChoice",
                type:'POST',
                data:$.param(obj),
                success: function(data){
                    window.location.href = window.location.href;
                }
            });
        }    
    });
    
    $('.setGameDeleted').off('click');
    $('.setGameDeleted').on('click',function(e){
        e.preventDefault();
        
        var obj = new Object;
        obj.column = 'is_deleted';
        obj.value = $(this).attr('rev');
        obj.id = $(this).attr('rel');
        obj.CSRF_TOKEN = getCsrfToken();
        if(confirm('Are you sure you wish to delete this game?')){
            var request = $.ajax({
                url:"/adminGame/saveChoice",
                type:'POST',
                data:$.param(obj),
                success: function(data){
                    window.location.href = window.location.href;
                }
            });
        }
    });
}


