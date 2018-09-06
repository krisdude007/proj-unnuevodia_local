var getCsrfToken = function() {
    return $("#csrfToken").html();
}

var createCounters = function() {
    $('input.counter').each(function(i, e) {
        $(e).parent().append($('<div style="font-size:10px;text-align:right; margin-top:5px;color: darkgrey;"></div>').attr({'id': 'counter_' + $(e).attr('id')}));
        $('#counter_' + $(e).attr('id')).text($(e).attr('maxlength') + ' caracteres restantes.');
        $(e).on('keyup', function() {
            updateCount(this)
        });
    });
}

var updateCount = function(el) {
    var l = $(el).attr('maxlength') - $(el).val().length;
    $('#counter_' + $(el).attr('id')).css({'color': 'black'}).text(l + ' caracteres restantes.');
    if (l < 0) {
        $('#counter_' + $(el).attr('id')).css({'color': 'red'}).text('Over character limit!');
    }
}
var profile = function() {
    $('.profile .menu span').click(function() {
        $(this).addClass('bold');
        this_div = $(this).attr('rel');
        $("#" + this_div).show();
        $(this).siblings().each(function() {
            $(this).removeClass('bold');
            var other_div = $(this).attr('rel');
            $("#" + other_div).hide();
        })
    })
}

var filechooser = function() {
    $(document).on('change', '.custom-file-input :file', function() {
        var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });


    $('.custom-file-input :file').on('fileselect', function(event, numFiles, label) {
        console.log(numFiles);
        $('#file_name').html(label);
    });

}

var togglePopup = function() {
    $("#popupWrap").toggle();
}
$("#popupClose").on("click", togglePopup);
//$("#popupWrap").on("click",togglePopup)

var tickerHandlers = function() {
    $("#showTickerFormLogin").on("click", function(e) {
        window.location.href = "/login";
    });
    $("#showTickerFormTrigger").off("click");
    $("#showTickerFormTrigger").on("click", function(e) {
        e.preventDefault();
        if ($("#userHeaderTickerForm").is(":visible")) {
            $("#userHeaderTickerForm").hide("blind", {
                direction: "vertical"
            }, 400);
        } else {
            $("#userHeaderTickerForm").show("blind", {
                direction: "vertical"
            }, 400);
        }
    });

    $("#addTickerTrigger").off("click");
    $("#addTickerTrigger").on("click", function(e) {
        e.preventDefault();
        tickerSave($("#tickerTextField").val());
    });

    function tickerSave(text) {
        var request = $.ajax({
            url: '/ticker/ajaxSave',
            type: 'POST',
            data: ({
                'text': text,
                'CSRF_TOKEN': getCsrfToken()
            }),
            success: function(data) {
                alert(data);
            },
            error: function(data) {
                alert('Unable to save ticker.');
                return false;
            }
        });
        $("#userHeaderTickerForm").hide("blind", {
            direction: "vertical"
        }, 400);
    }

    $('.shoutListItem').each(function(i, e) {
        $(e).mouseover(function() {
            $(e).css('background-color', '#ff831f');
        });
        $(e).mouseout(function() {
            $(e).css('background-color', '');
        });
    });

    $('.shoutListItem').each(function(i, e) {
        $(e).mouseover(function() {
            $(e).css('color', '#fff');
        });
        $(e).mouseout(function() {
            $(e).css('color', '#ff831f');
        });
    });

}

var popupReport = function(me) {
    $('#contentOk').attr('tbl', me.getAttribute('tbl'));
    $('#contentOk').attr('contentId', me.getAttribute('contentId'));
    $('#flashMobileHeader').html('Flag ' + me.getAttribute('tbl').charAt(0).toUpperCase() + me.getAttribute('tbl').slice(1));
    $('#popupMessage').html('Are you sure you want to flag this ' + me.getAttribute('tbl') + '?');
    $('#popupConfirm').css('display', 'table');
};


var flagContent = function(me) {
    var tbl = me.getAttribute('tbl');
    $.ajax({
        url: '/contentReport/ajaxFlag',
        type: 'POST',
        data: ({
            'tbl': tbl,
            'contentId': me.getAttribute('contentId'),
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {
            var result = $.parseJSON(data)
            if (result.error) {
                alert(result.error);
                return;
            }
            //flag
            var flagged = [];
            if (getCookie('flagged' + tbl)) {
                flagged = getCookie('flagged' + tbl).split(',');
            }
            flagged.push(me.getAttribute('contentId'));
            setCookie('flagged' + tbl, flagged.join(','));
            setFlag(tbl);
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });
};

var setFlag = function(tbl) {
    var flagged = [];
    if (getCookie('flagged' + tbl)) {
        flagged = getCookie('flagged' + tbl).split(',');
    }
    $('.flag').each(function(index) {
        for (var i = 0; i < flagged.length; i++) {
            if (tbl === $(this).attr('tbl') && flagged[i] === $(this).attr('contentId')) {
                $(this).removeAttr('onclick');
                $(this).html('Flagged');
            }
        }
    });
};


var tabHandlers = function() {
    /*
     $('.tab').each(function(i,e){
     if(window.location.toString().indexOf($(e).attr('href')) != -1 && $(e).attr('href') != '/'){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/-on/,'-over')
     });
     }
     if(window.location.toString().match($(e).attr('href')+'$')){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/-on/,'-over')
     });
     }
     if(window.location.toString().indexOf('/play/') != -1){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/videos-on/,'video-selected')
     });
     }
     if(window.location.toString().indexOf('/user/') != -1){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/videos-on/,'video-selected')
     });
     }
     if(window.location.toString().indexOf('/process/') != -1){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/recordnow-on/,'recordnow-over')
     });
     }
     if(window.location.toString().indexOf('/thanks') != -1){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/recordnow-on/,'recordnow-over')
     });
     }
     if(window.location.toString().indexOf('/vote') != -1){
     $(e).find('img').attr({
     'src':$(e).find('img').attr('src').replace(/vote-selected/,'vote-deselected')
     });
     }
     });
     */
    $('.sidebar a').each(function(i, e) {
        $(e).removeClass('activePage');
        if (window.location.toString().match($(e).attr('href') + '$')) {
            $(e).addClass('activePage');
        }
    });
    $('.sorter a').each(function(i, e) {
        $(e).removeClass('activeLink');
        if (window.location.toString().match($(e).attr('href') + '$')) {
            $(e).addClass('activeLink');
        }
    });
}

var socialHandlers = function() {
    $('#tw_conn').off('click');
    $('#tw_conn').on('click', function(e) {
        e.preventDefault();
        if ($(this).attr('rel') == 1) {
            if (confirm('Are you sure you want to disconnect your twitter account?')) {
                var request = $.ajax({
                    url: "/user/ajaxTwitterDisconnect",
                    type: 'POST',
                    data: ({
                        'CSRF_TOKEN': getCsrfToken()
                    }),
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        } else {
            $.oauthpopup({
                path: '/user/twitterConnect',
                callback: function() {
                    window.location.reload();
                }
            })
        }
    });
    $('#fb_conn').off('click');
    $('#fb_conn').on('click', function(e) {
        e.preventDefault();
        if ($(this).attr('rel') == 1) {
            if (confirm('Are you sure you want to disconnect your facebook account?')) {
                var request = $.ajax({
                    url: "/user/ajaxFacebookDisconnect",
                    type: 'POST',
                    data: ({
                        'CSRF_TOKEN': getCsrfToken()
                    }),
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        } else {
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
                            window.location.reload();
                        }
                    });
                }
            }, {
                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update'
            });
        }
    });
    $('.twreg').off('click');
    $('.twreg').on('click', function(e) {
        e.preventDefault();
        var elem = $(this).replaceWith($('<img></img>').attr({
            'id': 'spinner_tw',
            'src': '/core/webassets/images/socialSearch/ajaxSpinner.gif'
        }).css({
            'width': '25px'
        }));
        $.oauthpopup({
            path: '/user/twitter',
            callback: function() {
                window.location.replace('/');
            }
        })
    });
    $('.fbreg').off('click');
    $('.fbreg').on('click', function(e) {
        e.preventDefault();
        var elem = $(this).replaceWith($('<img></img>').attr({
            'id': 'spinner_fb',
            'src': '/core/webassets/images/socialSearch/ajaxSpinner.gif'
        }).css({
            'width': '25px'
        }));
        FB.login(function(response) {
            if (response.authResponse) {
                var request = $.ajax({
                    url: "/user/ajaxFacebook",
                    type: 'POST',
                    data: ({
                        'CSRF_TOKEN': getCsrfToken(),
                        'accessToken': response.authResponse.accessToken,
                        'expiresIn': response.authResponse.expiresIn,
                        'userID': response.authResponse.userID
                    }),
                    success: function(data) {
                        window.location.replace('/');
                    }
                });
            }
        }, {
            scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update'
        });
    });
}

var shareHandlers = function() {
    $('#eVideo_to_twitter').off('change');
    $('#eVideo_to_twitter').on('change', function(e) {
        if ($(this).is(':checked')) {
            $.oauthpopup({
                path: '/user/twitterConnect',
                callback: function() {
                }
            })
        }
    });
    $('#eVideo_to_facebook').off('change');
    $('#eVideo_to_facebook').on('change', function(e) {
        if ($(this).is(':checked')) {
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
                        })
                    });
                }
            }, {
                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update'
            });
        }
    });
    $('#eImage_to_twitter').off('change');
    $('#eImage_to_twitter').on('change', function(e) {
        if ($(this).is(':checked')) {
            $.oauthpopup({
                path: '/user/twitterConnect',
                callback: function() {
                }
            })
        }
    });
    $('#eImage_to_facebook').off('change');
    $('#eImage_to_facebook').on('change', function(e) {
        if ($(this).is(':checked')) {
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
                        })
                    });
                }
            }, {
                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update'
            });
        }
    });
    $('.star').off('click');
    $('.star').one('click', function(e) {
        e.preventDefault();
        var ratingType = $('#ratingType').html();
        var bID = $(this).attr('rev');
        var request = $.ajax({
            url: "/" + ratingType + "/ajaxRate",
            type: 'POST',
            data: ({
                'CSRF_TOKEN': getCsrfToken(),
                'rating': $(this).attr('rel'),
                'object_id': $(this).attr('rev')
            }),
            success: function(data) {
                var obj = $.parseJSON(data);
                $('#stars').html('');
                var starnum = 0;
                for (i = 0; i < obj.avg; i++) {
                    starnum++;
                    $('#stars').append(
                            $('<a></a>').attr({
                        'rel': starnum,
                        'rev': bID
                    }).append(
                            $('<img></img>').attr({
                        'src': '/webassets/images/play/star_yellow.png'
                    })
                            ))
                }
                for (t = 0; t < 5 - i; t++) {
                    starnum++;
                    $('#stars').append(
                            $('<a></a>').attr({
                        'rel': starnum,
                        'rev': bID
                    }).append(
                            $('<img></img>').attr({
                        'src': '/webassets/images/play/star_white.png'
                    })
                            ))
                }
                $('#votes').html(obj.votes);
                shareHandlers();
            }
        });
    });
}

var questionHandlers = function() {
    $('.question').off('mouseover');
    $('.question').on('mouseover', function(e) {
        $(this).addClass('hover');
    });
    $('.question').off('mouseout');
    $('.question').on('mouseout', function(e) {
        $(this).removeClass('hover');
    });
}



var linkHandlers = function() {
    $('.delete').off('click');
    $('.delete').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this video?')) {
            window.location = $(this).attr('href');
        }
    })
}

var termsHandlers = function() {
    $('#terms_accept').off('change');
    $('#terms_accept').on('change', function(e) {
        var choice = ($('#terms_accept').is(':checked')) ? 1 : 0;
        var request = $.ajax({
            type: 'POST',
            url: '/user/ajaxAcceptTerms',
            data: ({
                'CSRF_TOKEN': getCsrfToken(),
                'choice': choice
            }),
            success: function(data) {
                document.location = '/record';
            }
        });
    });
}

var newAcctHandlers = function() {

    $('#createNewAccount').off('change');
    $('#createNewAccount').on('change', function(e) {
        window.location = '/register';
    });
}

var voteHandlers = function() {

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
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });
}

var voteHandlersForMobile = function() {

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
                getGraphDataForMobile($('.afterVote').attr('rel'));
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });
}

var detectmob = function() {
    if (navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)
            ) {
        return true;
    }
    else {
        return false;
    }
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
            drawGraph(data.values, data.labels, data.colors);
        }
    });
}

function getGraphDataForMobile(pID) {
    var request = $.ajax({
        url: "/poll/ajaxGetDataForMobile",
        type: 'POST',
        data: ({
            'id': pID,
            'CSRF_TOKEN': getCsrfToken()
        }),
        dataType: 'json',
        success: function(data) {
            $.each(data.values, function(index, value) {
                var label = $('.vote_label .percent').get(index);
                $(label).text(value + '%');
                var bar = $('.progress-bar').get(index);
                $(bar).width(value + '%');
            })

        }
    });
}

function drawGraph(v, l, c) {
    RGraph.Clear(document.getElementById("cvs"));
    var graph = new RGraph.HBar('cvs', v);
    graph.Set('chart.labels', l);
    graph.Set('chart.colors', c);
    graph.Set('chart.units.post', '%');
    graph.Set('chart.labels.above', true);
    graph.Set('chart.xmax', 100);
    graph.Set('chart.background.barcolor1', 'transparent');
    graph.Set('chart.background.barcolor2', 'transparent');
    graph.Set('chart.text.size', 12);
    graph.Set('chart.text.color', 'black');
    graph.Set('chart.xlabels', false);
    graph.Set('chart.gutter.left', 200);
    graph.Set('chart.gutter.top', 0);
    graph.Set('chart.gutter.bottom', 25);
    graph.Set('chart.background.grid', false);
    graph.Set('chart.colors.sequential', true);
    graph.Set('chart.noaxes', true);
    graph.Set('chart.axis.color', 'transparent');
    graph.Draw();
}

var crawler = function() {
    var request = $.ajax({
        url: "/ticker/ajaxStream",
        type: 'POST',
        data: ({
            'destination': 'web',
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {
            var data = $.parseJSON(data);
            $('#tickerCrawlImage').attr({'src': data.image});
            $('#tickerCrawlId').html(data.username);
            $('#tickerCrawlText').html(data.ticker);
        }
    });
}

var overlayHandlers = function() {
    if (getCookie("hideRecorderOverlay")) {
        setCookie("hideRecorderOverlay", 1);//renew 30day validation
    }
    else {
        $('.dim').toggle();
    }
    $('.hide_dim').off('click');
    $('.hide_dim').on('click', function(e) {
        e.preventDefault();
        $('.dim').toggle();
        if ($('#hiderecorderhelp').is(':checked')) {
            setCookie("hideRecorderOverlay", 1);
        }
    });
}

function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000 * 30));//30 days
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString() + '; path=/; domain=.youtoo.com';
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

var reloadVideo = function(vid) {
    var request = $.ajax({
        url: '/video/ajaxPreviewVideo',
        type: 'POST',
        data: ({
            'CSRF_TOKEN': getCsrfToken(),
            'vID': vid
        }),
        success: function(data) {
            var obj = $.parseJSON(data);
            $('#videoPlayer').html(obj.html);
            if (obj.status == 'WAIT') {
                setTimeout('reloadVideo(' + vid + ')', 2000);
            }
        }
    });
}

jQuery(document).ready(function() {
    newAcctHandlers();
    tabHandlers();
    questionHandlers();
    shareHandlers();
    linkHandlers();
    socialHandlers();
    termsHandlers();
    voteHandlers();
    voteHandlersForMobile();
    tickerHandlers();
    crawler();
    overlayHandlers();
    createCounters();
    profile();
    //filechooser();

//    /**
//    * VIDEO OVERLAY
//    * Provides method for showing overlay when video is clicked or when history
//    * is clicked.
//    */
//    $("a[rel]").overlay({
//
//        mask: '#000',
//        effect: 'default',
//        top: 25,
//        closeOnClick: true,
//        closeOnEsc: true,
//        fixed: true,
//        oneInstance: true,
//        api: true,
//
//        onBeforeLoad: function() {
//
//            var wrap = this.getOverlay().find(".termsOverlayContent");
//            var url = this.getTrigger().attr("href");
//            wrap.html('');
//            wrap.load(url);
//        }
//    });

});


