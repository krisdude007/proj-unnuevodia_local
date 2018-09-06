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

var updateCount = function(el) {
    var l = $(el).attr('maxlength') - $(el).val().length;
    $('#counter_' + $(el).attr('id')).css({'color': 'black'}).text(l + ' characters remaining.');
    if (l < 0) {
        $('#counter_' + $(el).attr('id')).css({'color': 'red'}).text('Over character limit!');
    }
}

var avatarHandlers = function() {
    $('.ajaxSetEntityAvatar').off('click');
    $('.ajaxSetEntityAvatar').on('click', function(e) {
        e.preventDefault();
        var request = $.ajax({
            url: "/adminEntity/ajaxSetEntityAvatar",
            type: 'POST',
            data: ({
                'CSRF_TOKEN': getCsrfToken(),
                'entity': $(this).attr('rel'),
                'image': $(this).attr('rev'),
            }),
            success: function(data) {
                window.location = window.location
            }
        });
    });
}

var editHandler = function() {
    $('.setEntityState').off('click');
    $('.setEntityState').on('click', function(e) {
        e.preventDefault();
        var obj = new Object;
        obj.value = $(this).attr('rev');
        obj.id = $(this).attr('rel');
        obj.CSRF_TOKEN = getCsrfToken();
        if (confirm('Are you sure you wish to make this edit?')) {
            var request = $.ajax({
                url: "/adminEntity/ajaxSetEntityStatus",
                type: 'POST',
                data: $.param(obj),
                success: function(data) {
                    window.location.href = window.location.href;
                }
            });
        }
    });
}

var addContestantClick = function() {
    //e.preventDefault();
    //id = $(me).attr('rel');
    $.ajax(
            {
                url: '/admin/entity/contestantsModal/'
            }
    ).done(function(data) {
        modal(data);
    });
}

var modal = function(content) {
    // Generate the HTML and add it to the document
    $("#modal").remove();
    $("#cover").remove();
    $cover = $('<div id="cover"></div>');
    $modal = $('<div id="modal"></div>');
    $content = $('<div></div>');
    $close = $('<a id="close">X</a>');

    $modal.hide();
    $modal.append($content, $close);

    $(document).ready(function() {
        $('body').append($cover);
        $('body').append($modal);
    });

    $close.click(function(e) {
        e.preventDefault();
        $modal.remove();
        $cover.remove();
        window.location = window.location;
    });

    $cover.click(function(e) {
        e.preventDefault();
        $modal.remove();
        $cover.remove();
    });
    // Open the modal
    //return function (content) {
    $content.html(content);
    // Center the modal in the viewport
    $modal.css({
        top: ($(window).height() - $modal.outerHeight()) / 2,
        left: ($(window).width() - $modal.outerWidth()) / 2
    });
    $modal.show();
    //};
};

var triggerTab = function(me) {
    if (!($(me).attr('class') && $(me).attr('class') === 'selected')) {
        var formId = $(me).attr('formId');
        $(".tabNav li").each(function(e) {
            $(this).attr('class', '');
            $("#" + $(this).attr('formId')).hide();
        });
        $("#" + formId).show();
        $(me).attr('class', 'selected');
    }
    return false;
}
var addUserClick = function() {
    window.open('/admin/user');
}
var deleteContestantClick = function(entityAnswerId) {
    if (!confirm('Are you sure to delete contestant?\nAll vote will be removed for this contestant.'))
        return;
    var request = $.ajax({
        url: "/adminEntity/ajaxDeleteContestant",
        type: 'POST',
        data: ({
            'CSRF_TOKEN': getCsrfToken(),
            'id': entityAnswerId,
        }),
        success: function() {
            window.location = window.location;//reload() give error when previous request was post(process again).
        }
    });
}

var viewClicked = function(me) {
    var request = $.ajax({
        url: "/adminEntity/ajaxAddContestant",
        type: 'POST',
        data: ({
            'CSRF_TOKEN': getCsrfToken(),
            'id': $(me).attr('href'),
            'poll_id': location.search.split('id=')[1],
        }),
        success: function(data) {
            result = JSON.parse(data);
            if (result.error)
                alert('Added to contestant');
        },
        error: function() {
            alert('Unable to add to contestant.');
        }
    });
}

var dateTimeHandlers = function() {
    $('.ui-timepicker-input').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm'});
};

$(document).ready(function() {

    $('#entityTable').dataTable({
        "aaSorting": [[1, "asc"]]
    });
    dateTimeHandlers();
    createCounters();
    avatarHandlers();
    editHandler();
});
