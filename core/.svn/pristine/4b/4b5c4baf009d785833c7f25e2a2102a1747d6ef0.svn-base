/**
 * Handlers
 */
var selectedPreroll = null;
var selectedPostroll = null;

var amplifyHandlers = function() {

  $(".amp_scrollable").scrollable();
  
  // hide set default pre/post roll buttons
  $("#defaultPrerollContainer, #defaultPostrollContainer").children().prop('disabled',true);

  $('.preRollImage').off('click');
  $('.preRollImage').on('click',function(e){
      
      selectedPreroll = $(this);
      var videoId = selectedPreroll.attr('alt');
      $("#defaultPrerollContainer").children().prop('disabled',false);
      
      if (selectedPreroll.attr('class').indexOf("defaultItem") >= 0) {
        $('#setDefaultPreroll').prop('checked', true);
      } else {
        $('#setDefaultPreroll').prop('checked', false);
      }
      
      $('.preRollItems img').each(function() {
        $(this).css({'background-color' : '', 'border' : ''});
      });

      selectedPreroll.css({'background-color' : '#000', 'border' : '1px solid #000'});
      $('#amplifyPreroll').val(videoId);
      amplifyPreview();
  });
  
  $('.postRollImage').off('click');
  $('.postRollImage').on('click',function(e){
      
      selectedPostroll = $(this);
      var videoId = selectedPostroll.attr('alt');
      $("#defaultPostrollContainer").children().prop('disabled',false);
      
      if (selectedPostroll.attr('class').indexOf("defaultItem") >= 0) {
        $('#setDefaultPostroll').prop('checked', true);
      } else {
        $('#setDefaultPostroll').prop('checked', false);
      }
      
      $('.postRollItems img').each(function() {
        $(this).css({'background-color' : '', 'border' : ''});
      });
      
      selectedPostroll.css({'background-color' : '#000', 'border' : '1px solid #000'});
      $('#amplifyPostroll').val(videoId);
      amplifyPreview();
  });
  
  $('#setDefaultPreroll').off('click');
  $('#setDefaultPreroll').on('click',function(e){
      
      $('.preRollItems img').each(function() {
        $(this).removeClass('defaultItem');
      });
      
      var videoId = $('#amplifyPreroll').val();
      var rollType = 1;
        
      if($(this).is(':checked')) {
        
        var request = $.ajax({
              url: '/adminVideo/ajaxVideoSetDefaultRoll',
              type: 'POST',
              data:({
                  'videoId': videoId,
                  'rollType': rollType,
                  'CSRF_TOKEN': getCsrfToken()
              }),
              dataType: "json",
              success: function(data){
                  selectedPreroll.addClass('defaultItem');
                  alert(data.response);
                  return true;
              },
              error: function(data){
                  alert(data.response);
                  return false;
              }
          });   
          
      } else {
          var request = $.ajax({
              url: '/adminVideo/ajaxVideoUnsetDefaultRoll',
              type: 'POST',
              data:({
                  'videoId': videoId,
                  'CSRF_TOKEN': getCsrfToken()
              }),
              dataType: "json",
              success: function(data){
                  alert(data.response);
                  return true;
              },
              error: function(data){
                  alert(data.response);
                  return false;
              }
          });   
      }
  });
  
  $('#setDefaultPostroll').off('click');
  $('#setDefaultPostroll').on('click',function(e){
      
      $('.postRollItems img').each(function() {
        $(this).removeClass('defaultItem');
      });

      var videoId = $('#amplifyPostroll').val();
      var rollType = 2;
      
      if($(this).is(':checked')) {
          
        var request = $.ajax({
              url: '/adminVideo/ajaxVideoSetDefaultRoll',
              type: 'POST',
              data:({
                  'videoId': videoId,
                  'rollType': rollType,
                  'CSRF_TOKEN': getCsrfToken()
              }),
              dataType: "json",
              success: function(data){
                  selectedPostroll.addClass('defaultItem');
                  alert(data.response);
                  return true;
              },
              error: function(data){
                  alert(data.response);
                  return false;
              }
          });   
        
      } else {
          var request = $.ajax({
            url: '/adminVideo/ajaxVideoUnsetDefaultRoll',
            type: 'POST',
            data:({
                'videoId': videoId,
                'CSRF_TOKEN': getCsrfToken()
            }),
            dataType: "json",
            success: function(data){
                alert(data.response);
                return true;
            },
            error: function(data){
                alert(data.response);
                return false;
            }
        });   
      }
  });
}

var modalButtonHandlers = function() {
    
    $('#btnRotateVideoLeft').click(function() {
        $(this).prop('disabled', true);
        rotateVideo($(this), $("#videoId").html(), 'left');
    });

    $('#btnRotateVideoRight').click(function() {
        $(this).prop('disabled', true);
        rotateVideo($(this), $("#videoId").html(), 'right');
    });
    
  // save tags button
  $('#saveTagTrigger').click(function() {
    saveVideoTags($("#videoId").html(), $("#videoTags").val());
  });
  
  // video accept/deny buttons
  $('#fab-modal-accept-button').click(function() {
    $('#fab-modal-accept-button').hide();
    $('#fab-modal-deny-button').show();
  });
    
  $('#fab-modal-deny-button').click(function() {
    $('#fab-modal-deny-button').hide();
    $('#fab-modal-accept-button').show();
  });
  
  // download video button
  $('#fab-modal-download-button').click(function(e) {
    e.preventDefault();
    location.href = '/adminVideo/videoDownload/' + $(this).attr('value');
  });
}


var tabHandlers = function() {
  $('#modalTabs').tabs();
  $("#tabThumbnailTrigger").click(function(e) {
    $("#tab-thumbnail").load("/adminVideo/videoModalThumbnails/"+$("#videoId").html(), function(response, status, xhr) {
      if (status == "error") {
        var msg = "Sorry but there was an error loading thumbnails: ";
        alert(msg + xhr.status + " " + xhr.statusText);
      }
    });
  });
  $("#tabHistoryTrigger").click(function(e) {
    $("#tab-history").load("/adminVideo/videoModalHistory/"+$("#videoId").html(), function(response, status, xhr) {
      if (status == "error") {
        var msg = "Sorry but there was an error loading history: ";
        alert(msg + xhr.status + " " + xhr.statusText);
      }
    });
  });
}

var tagHandlers = function() {
  //var sampleTags = ['c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy', 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];
  $('#videoTags').tagit({
    //availableTags: sampleTags
  });
}

var setPostRoll = function(videoId) {

  $('#amplifyPostroll').val(videoId);
  amplifyPreview();
}

var amplifyPreview = function() {
    var request = $.ajax({
        url: '/adminVideo/ajaxAmplifyPreview',
        type: 'POST',
        data:({
            'videos': new Array($('#amplifyPreroll').val(),$('#amplifyBase').val(),$('#amplifyPostroll').val()),
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data){
            $('#amplifyPreviewVideo').html(data);
            $('#mediaplayer_wrapper').css("width", "150px");
            $('#mediaplayer_wrapper').css("height", "85px");
        }
    });
}

var amplify = function() {
    if(confirm('Are you sure you want to Tweet this?')){
        var request = $.ajax({
            url: '/adminVideo/ajaxAmplifyConcatenate',
            type: 'POST',
            data:({
                'base':$('#amplifyBase').val(),
                'videos': new Array($('#amplifyPreroll').val(),$('#amplifyBase').val(),$('#amplifyPostroll').val()),
                'CSRF_TOKEN': getCsrfToken()
            }),
            success: function(data){
                if(data != 'fail'){
                    var video_id = data;
                    var message = $('#amplifyText').val();
                    var request = $.ajax({
                        url:"/admin/ajaxClientShareTwitter",
                        type:'POST',
                        data:({
                            'CSRF_TOKEN':getCsrfToken(),
                            'type':'video',
                            'id':video_id,
                            'message':message,
                        }),
                        success: function(data){
                            alert('Twitter Says: '+data);
                        }
                    });
                } else {
                    alert('fail');
                }
            }
        });
    }
}

var createCounters = function(){
    $('input.counter').each(function(i,e){
        $(e).parent().append($('<div></div>').attr({'id':'counter_'+$(e).attr('id')}));
        $('#counter_'+$(e).attr('id')).text($(e).attr('maxlength') +' characters remaining.');
        $(e).on('keyup',function(){updateCount(this)});
        $(e).on('blur',function(){adjustMaxLength(this,'blur')});
        $(e).on('focus',function(){adjustMaxLength(this,'focus')});
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

var updateCount = function(el){
    var l = $(el).attr('maxlength') - $(el).val().length;
    $('#counter_'+$(el).attr('id')).css({'color':'black'}).text(l+' characters remaining.');
    if(l<0){
        $('#counter_'+$(el).attr('id')).css({'color':'red'}).text('Over character limit!');
    }
}


$(document).ready(function () {

  modalButtonHandlers();
  tabHandlers();
  tagHandlers();
    
  // have to call this from here in order to reinitialize the 
  // video status handlers and social handlers previously loaded
  // in the video page.
  socialHandlers();
  videoStatusHandlers();
  createCounters();
  amplifyHandlers();
});

/**
 * Takes a video id and list of tags to save
 */
function saveVideoTags(videoId, tags){

  var request = $.ajax({
    url: '/adminVideo/ajaxVideoAddTags',
    type: 'POST',
    data:({
      'tags': tags,
      'videoId': videoId,
      'CSRF_TOKEN': getCsrfToken()
    }),
    success: function(data){
      alert('Video  tags saved.');
    },
    error: function(data){
      alert('Unable to save video tags.');
      return false;
    }
  });   
}



function rotateVideo(buttonObj, videoId, direction) {

    $("#modalVideo").attr("src", '/core/webassets/images/loading.gif');
    var request = $.ajax({
        url: '/adminVideo/ajaxRotateVideo',
        type: 'POST',
        dataType: 'json',
        data: ({
            'direction': direction,
            'videoId': videoId,
            'CSRF_TOKEN': getCsrfToken()
        }),
        success: function(data) {
            if (data.success == 'true') {
                //$("#" + thumbnailId).attr("src", data.filename);
                $("#modalVideo").attr("src", '');
            } else {
                alert(data.message);
            }
            $(buttonObj).prop('disabled', false);
        },
        error: function(data) {
            alert(data.message);
            $(buttonObj).prop('disabled', false);
            return false;
        }
    });
}




