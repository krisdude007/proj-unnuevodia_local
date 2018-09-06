var socialHandlers = function(){ 
  $('#clientShareTwitterTrigger, #clientShareTwitterModalTrigger').off('click');
  $('#clientShareTwitterTrigger, #clientShareTwitterModalTrigger').on('click',function(e){    
    e.preventDefault();
    if(confirm('Are you sure you want to Tweet this?')){
      var question_id = $(this).attr('rev');
      var message = $('#message').val();
      var elem = $(this).replaceWith($('<img></img>').attr({
        'id':'spinner_tw_'+question_id,
        'src':'/core/webassets/images/socialSearch/ajaxSpinner.gif'
      }).css({
        'width':'25px'
      }));        
      var request = $.ajax({
        url:"/admin/ajaxClientShareTwitter",
        type:'POST',
        data:({
          'CSRF_TOKEN':getCsrfToken(),
          'type':'question',
          'id':question_id,
        }),
        success: function(data){
          alert('Twitter Says: '+data);
          $('#spinner_tw_'+question_id).replaceWith(elem);
          socialHandlers();
        }
      });
    }
  });
  
  $('#clientShareFacebookTrigger, #clientShareFacebookModalTrigger').off('click');
  $('#clientShareFacebookTrigger, #clientShareFacebookModalTrigger').on('click',function(e){   
    e.preventDefault();
    if(confirm('Are you sure you want to post this to facebook?')){
      var question_id = $(this).attr('rev');
      var elem = $(this).replaceWith($('<img></img>').attr({
        'id':'spinner_fb_'+question_id,
        'src':'/core/webassets/images/socialSearch/ajaxSpinner.gif'
      }).css({
        'width':'25px'
      }));
      FB.login(function(response) {
        if (response.authResponse) {            
          var request = $.ajax({
            url:"/user/ajaxFacebookConnect",
            type:'POST',
            data:({
              'CSRF_TOKEN':getCsrfToken(),
              'accessToken':response.authResponse.accessToken,
              'expiresIn':response.authResponse.expiresIn,
              'userID':response.authResponse.userID
            }),
            success: function(data){
              var request = $.ajax({
                url:"/admin/ajaxClientShareFacebook",
                type:'POST',
                data:({
                  'CSRF_TOKEN':getCsrfToken(),
                  'type':'question',
                  'id':question_id,
                }),
                success: function(data){
                  alert('Facebook Says: '+data);
                  $('#spinner_fb_'+question_id).replaceWith(elem);
                  socialHandlers();
                }
              });
            }
          });
        }
      },{
        scope: 'user_location,user_birthday,email,publish_stream,publish_actions,status_update,manage_pages'
      });                                
    }
  });
}

var createCounters = function(){
    $('input.counter').each(function(i,e){
        $(e).parent().append($('<div></div>').attr({'id':'counter_'+$(e).attr('id')}));
        $('#counter_'+$(e).attr('id')).text($(e).attr('maxlength') +' characters remaining.');
        $(e).on('keyup',function(){updateCount();});
        //$(e).on('blur',function(){adjustMaxLength(this,'blur')});
        //$(e).on('focus',function(){adjustMaxLength(this,'focus')});
    });
}

var adjustMaxLength = function(el,event){
    var classes = $(el).attr('class').split(/ /);
    $.each(classes,function(i,e){
        if(e.match('linkTo')){
            if(event == 'focus'){
                var maxlength = parseInt($('#'+e.replace(/linkTo/,'')).attr('maxlength')) + parseInt($(el).val().length);        
                $('#'+e.replace(/linkTo/,'')).attr({'maxlength':maxlength});        
            } else {            
                var maxlength = $('#'+e.replace(/linkTo/,'')).attr('maxlength') - $(el).val().length;
                $('#'+e.replace(/linkTo/,'')).attr({'maxlength':maxlength});
                $('#'+e.replace(/linkTo/,'')).trigger('keyup');
            }
        }            
    });    
}

var updateCount = function(){
    var maxTextLength = maxLengthQ;
    var maxHashtagLength = 30;
    var q = $('#eQuestion_question');//question input count
    var ht = $('#eQuestion_hashtag');//hashtag input count
    $('#counter_'+$(q).attr('id')).css({'color':'black'}).text(maxTextLength - $(q).val().length - $(ht).val().length + ' characters remaining.');//decrease maxlength for hashtag
    if( maxTextLength <=  $(q).val().length +  maxHashtagLength){//set maxHashtagLength if overflow            
        $(q).attr({'maxlength':maxTextLength - $(ht).val().length});//set maxTextLength
        $(ht).attr({'maxlength':maxHashtagLength > (maxTextLength - $(q).val().length)?(maxTextLength - $(q).val().length):maxHashtagLength});//set maxHashtagLength
        $('#counter_'+$(ht).attr('id')).css({'color':'black'}).text(maxTextLength - $(ht).val().length - $(q).val().length + ' characters remaining.');//decrease maxlength for hashtag
    }else{
        $(q).attr({'maxlength':maxTextLength - $(ht).val().length});//set maxTextLength
        $(ht).attr({'maxlength': maxHashtagLength});//set maxHashtagLength
        $('#counter_'+$(ht).attr('id')).css({'color':'black'}).text(maxHashtagLength - $(ht).val().length + ' characters remaining.');//decrease maxlength for hashtag
    }  
}

var submissionHandler = function(el){
    $('#submitEdit').off('submit');
    $('#submitEdit').on('submit',function(e){
        if(confirm('Are you sure you wish to make this edit?')){
            var data = $(this).serializeArray();
            var csrf = new Object;
            csrf.name = 'CSRF_TOKEN';
            csrf.value = getCsrfToken();
            data.push(csrf);
            var request = $.ajax({
                url:"/adminQuestion/save",
                type:'POST',
                data:$.param(data),
                success: function(data){
                    $(el).html(data);
                    $('#submitEdit').parents('td').html(el);                                        
                    editHandler();
                }
            });
        }
        return false;
    });
}
var cancelHandler = function(el){
    $('#cancelEdit').off('click');
    $('#cancelEdit').on('click',function(e){
        $(this).parents('td').html(el);
        editHandler();
    });
}
var editHandler = function(){
    $('.setQuestionState').off('click');
    $('.setQuestionState').on('click',function(e){
        e.preventDefault();
        if($(this).parents('td').hasClass('active') || $('td.active').length < maxActives){
            if($(this).parents('td').hasClass('active') && $('td.active').length == 1){
                var confirmMessage = 'This will result in no questions currently running on the site. \r\n Users will be unable to record video until there is at least one active question. \r\n'
            } else {
                var confirmMessage = '';
            }
            var obj = new Object;
            obj.column = 'end_time';
            obj.value = $(this).attr('rev');
            obj.id = $(this).attr('rel');
            obj.CSRF_TOKEN = getCsrfToken();
            if(confirm(confirmMessage+'Are you sure you wish to make this edit?')){
                var request = $.ajax({
                    url:"/adminQuestion/save",
                    type:'POST',
                    data:$.param(obj),
                    success: function(data){
                        window.location.href = window.location.href;
                    }
                });
            }        
        } else {
            alert('Only '+maxActives+' running questions allowed!');
        }
    });
    $('.setQuestionDeleted').off('click');
    $('.setQuestionDeleted').on('click',function(e){
        e.preventDefault();
        
            var obj = new Object;
            obj.column = 'is_deleted';
            obj.value = $(this).attr('rev');
            obj.id = $(this).attr('rel');
            obj.CSRF_TOKEN = getCsrfToken();
            if(confirm('Are you sure you wish to delete this question?')){
                var request = $.ajax({
                    url:"/adminQuestion/save",
                    type:'POST',
                    data:$.param(obj),
                    success: function(data){
                        window.location.href = window.location.href;
                    }
                });
            }
    });
    $('.edit').off('click');
    $('.edit').on('click',function(e){
        if($('#cancelEdit').length != 0){
            $('#cancelEdit').trigger('click');
        }
        e.preventDefault();
        var formHolder = $('<div></div>').css({'display':'inline-block','width':'100%'});
        var miniform = $('<form></form>').attr({'id':'submitEdit'});
        var inputField = $('<input></input>').val($(this).html()).attr({'id':$(this).attr('rel'),'name':'value'});        
        var hiddenIDField = $('<input></input>').attr({'type':'hidden','name':'id'}).val($(this).attr('rev'));        
        var hiddenColField = $('<input></input>').attr({'type':'hidden','name':'column'}).val($(this).attr('rel'));        
        var submitButton = $('<input></input>').attr({'type':'submit'});
        var cancelButton = $('<button></button>').attr({'id':'cancelEdit','type':'button'}).css({'float':'right'}).html('Cancel');
        miniform.append(inputField).append(hiddenIDField).append(hiddenColField).append(submitButton).append(cancelButton);
        formHolder.append(miniform);        
        var el = $(this).replaceWith(formHolder);
        submissionHandler(el);
        cancelHandler(el);
    });
}

var send_ticker = function(el){
	$('.send_button').off('click');
	$('.send_button').on('click', function(e){
		e.preventDefault();
		var obj = new Object;
        obj.id = $(this).prev().attr('rev');
        obj.CSRF_TOKEN = getCsrfToken();
		if(confirm('Are you sure you want to send ticker?')){
			$(this).html('<img style="height:20px;margin-top:-5px;" src="/core/webassets/images/socialSearch/ajaxSpinner.gif">');
			var button = $(this);
            var request = $.ajax({
                url:"/adminQuestion/ajaxSendTicker",
                type:'POST',
                data:$.param(obj),
                success: function(data){
                    alert(data);
                    $(button).hide();
                }
            });
        }
	});
	
}
var linkPopUp = function(){
    $('.linkPopUp').off('click');
    $('.linkPopUp').on('click',function(e){
        e.preventDefault();
        $("#xml_url").val('');
        $("#rss_url").val('');
        $("#tv_url").val('');
        $("#tv_url2").val('');
        $("#linksPopUpOverlay").overlay({
                mask: '#000',
                effect: 'default',
                top: 25,
                closeOnClick: true,
                closeOnEsc: true,
                fixed: true,
                oneInstance: true,
                api: true
            }).load();

        var id = $(this).attr('rel');
        var baseurl =$("#baseurl").val();
        $("#xml_url").val(baseurl+'/XML/questionTicker?id='+id);
        $("#xml_url_lb").html('<a target="_blank" style="color:#000;" href="'+baseurl+'/XML/questionTicker?id='+id+'">XML URL</a>');
        $("#rss_url").val( baseurl+'/XML/questionTickerRSS?id='+id );
        $("#rss_url_lb").html('<a target="_blank" style="color:#000;" href="'+baseurl+'/XML/questionTickerRSS?id='+id+'">RSS URL</a>');
        $("#tv_url").val( baseurl+'/preview/questionTicker?id='+id );
        $("#tv_url_lb").html('<a target="_blank" style="color:#000;" href="'+baseurl+'/preview/questionTicker?id='+id+'">TV URL</a>');
        $("#tv_url2").val( baseurl+'/preview/questionTicker2?id='+id );
        $("#tv_url2_lb").html('<a target="_blank" style="color:#000;" href="'+baseurl+'/preview/questionTicker2?id='+id+'">TV URL 2</a>');
    });

}

var copyUrl = function(){
    $('.copyTxtBox').off('click');
    $('.copyTxtBox').on('click',function(e){
        e.preventDefault();  
        $(this).select(); 
    });

}


$(document).ready(function(){
 
    $('#questionTable').dataTable({
        "fnDrawCallback":editHandler(),
        "aaSorting": [[ 0, "desc" ],[ 1, "desc" ]],//second sort by updated_on(1)
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [1] }],//set visible false on updated_on(1)
        "iDisplayLength": 100
    });
    editHandler();
    createCounters();updateCount();//calculate initial charaters for talk
    socialHandlers();
    send_ticker();
    linkPopUp();
    copyUrl();
});    
