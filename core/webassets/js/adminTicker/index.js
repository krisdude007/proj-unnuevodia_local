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

var shareHandlers = function() {
    $('.shareToClientTwitter').off('click');
    $('.shareToClientTwitter').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to Tweet this?')) {
            var ticker_id = $(this).attr('rel');
            var elem = $(this).replaceWith($('<img></img>').attr({'id': 'spinner_tw_' + ticker_id, 'src': '/core/webassets/images/socialSearch/ajaxSpinner.gif'}).css({'width': '32px'}));
            var request = $.ajax({
                url: "/admin/ajaxClientShareTwitter",
                type: 'POST',
                data: ({
                    'CSRF_TOKEN': getCsrfToken(),
                    'type': 'ticker',
                    'id': ticker_id,
                }),
                success: function(data) {
                    alert('Twitter Says: ' + data);
                    $('#spinner_tw_' + ticker_id).replaceWith(elem);
                    shareHandlers();
                }
            });
        }
    });
    $('.shareToClientFacebook').off('click');
    $('.shareToClientFacebook').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to post this to Facebook?')) {
            var ticker_id = $(this).attr('rel');
            var elem = $(this).replaceWith($('<img></img>').attr({'id': 'spinner_fb_' + ticker_id, 'src': '/core/webassets/images/socialSearch/ajaxSpinner.gif'}).css({'width': '32px'}));
            FB.login(function(response) {
                if (response.authResponse) {
                    var request = $.ajax({
                        url: "/user/ajaxFacebookConnect",
                        type: 'POST',
                        data: ({
                            'CSRF_TOKEN': getCsrfToken(),
                            'accessToken': response.authResponse.accessToken,
                            'expiresIn': response.authResponse.expiresIn,
                            'userID': response.authResponse.userID
                        }),
                        success: function(data) {
                            var request = $.ajax({
                                url: "/admin/ajaxClientShareFacebook",
                                type: 'POST',
                                data: ({
                                    'CSRF_TOKEN': getCsrfToken(),
                                    'type': 'ticker',
                                    'id': ticker_id,
                                }),
                                success: function(data) {
                                    alert('Facebook Says: ' + data);
                                    $('#spinner_fb_' + ticker_id).replaceWith(elem);
                                    shareHandlers();
                                }
                            });
                        }
                    });
                }
            }, {
                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update,manage_pages'
            });
        }
    });
}

function flip() {
    /*
     if ($(".flip").attr("disabled")) {
     $(".flip").removeAttr("disabled");
     } else {
     $(".flip").attr("disabled", "disabled");
     }*/
    $('.flip').each(function() {
        if ($(this).css("display") === "none") {
            $(this).show();
            $(this).find('select').prop("disabled", false);
        }
        else {
            $(this).hide();
            $(this).find('select').prop("disabled", true);
        }
    });
}

$(document).ready(function() {
    createCounters();
    shareHandlers();
});

