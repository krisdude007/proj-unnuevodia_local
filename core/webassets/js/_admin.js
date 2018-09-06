$(document).ready(function () {
    navHandlers();
    sessionHandlers();
});

var navHandlers = function(){
    $('#fab-collapsed li a').each(function(i,e){   
        if(window.location.toString().indexOf($(e).attr('href').split('?')[0].replace(/\/index/,'')) != -1)
        {
            $(e).find('.fab-text').addClass('on');
        }
    }); 
}

// snags session duration and displays a message 
// right before a user session expires
var sessionHandlers = function() {
    var duration = $('#sessionDuration').html();
    var offset = $('#sessionDurationOffset').html();
    var durationInJsSecs = (duration * 1000) - offset;
    var durationInJsSecsWithOffset = durationInJsSecs - offset;

    var triggers = $("#sessionDurationOverlay").overlay({
        mask: '#000',
        effect: 'default',
        top: 25,
        closeOnClick: true,
        closeOnEsc: true,
        fixed: true,
        oneInstance: true,
        api: true,
        onClose: function(){
            logout();
        }
    });

    setTimeout(function() {
        // show user session expiration warning
        $("#sessionDurationOverlay").overlay().load();
    }, durationInJsSecsWithOffset);
    
    setTimeout(function() {
        // log user out
        logout();
    }, durationInJsSecs);
    
    $('#sessionRefresh').click(function() {
        $("#sessionDurationOverlay").overlay().close();
        location.reload();
    });
    
    $('#sessionExpire').click(function() {
        $("#sessionDurationOverlay").overlay().close();
        logout();
    });
}

function logout() {
    window.location.replace("/admin/logout");
}


