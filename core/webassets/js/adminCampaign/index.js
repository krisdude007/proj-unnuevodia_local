
$(function() {
    $('.fbreg').bind('click',function(e){    
        if($(this).children('.campaign_media_row_text').html() == 'Connect') {
            $(this).children('.campaign_media_row_text').html('<img height=32 width=32 src="/core/webassets/images/socialSearch/ajaxSpinner.gif"/>');

            FB.login(function(response) {
                if (response.authResponse) {
                    $.ajax({
                        url:"/user/ajaxFacebook",
                        type:'POST',
                        data:({
                            'CSRF_TOKEN':getCsrfToken(),
                            'accessToken':response.authResponse.accessToken,
                            'expiresIn':response.authResponse.expiresIn,
                            'userID':response.authResponse.userID
                        }),
                        success: function(data){
                            $('.fbreg .campaign_media_row_text').html('Connected');
                            $('.fbreg_on').removeClass('campaign_on_unselected').addClass('campaign_on_selected');
                            $('.fbreg_off').removeClass('campaign_off_selected').addClass('campaign_off_unselected');
                            $('.campaign_media_button_facebook').css('cursor','auto');
                            $('.fbreg_off').css('cursor','pointer');
                            
                        }
                    });
                    
                    FB.api('/me', function(res) {
                        $('.campaign_social_media_email').html(res.email);
                    });
                }
            },{
                scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update'
            });    
        }
    });
/*  comment out disconnect facebook authentication here 
    $('.fbreg_off').on('click',function(){    
        if($(this).hasClass('campaign_off_unselected')) {
            if(confirm('Are you sure you want to disconnect your facebook account?')){
                FB.api(
                    "/me/permissions","DELETE",
                    function (response) {
                      if (response && !response.error) {
                        $('.fbreg .campaign_media_row_text').html('Connect');
                        $('.fbreg_on').removeClass('campaign_on_selected').addClass('campaign_on_unselected');
                        $('.fbreg_off').removeClass('campaign_off_unselected').addClass('campaign_off_selected');
                        $('.campaign_media_button_facebook').css('cursor','pointer');
                        $('.fbreg_off').css('cursor','auto');
                        $('.campaign_social_media_email').html('');
                      }
                    }
                );
         
            }
        }
    });
*/
    if( $('#toggle').hasClass('toggle_down') ) {
    	$('#package').hide();
    }
    $('#choose_package').click(function(e){
    	$('#package').toggle();
    	if($('#toggle').hasClass('toggle_down')) {
    		$('#toggle').removeClass('toggle_down').addClass('toggle_up');
    	} else {
    		$('#toggle').removeClass('toggle_up').addClass('toggle_down');
    	}
    })
    
});


