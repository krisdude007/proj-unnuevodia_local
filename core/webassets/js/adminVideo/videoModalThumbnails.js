var videoThumbnailHandlers = function() {
  $(".videoThumbnailTrigger").click(function(e) {
    e.preventDefault();
    var thumbnail =  $(this).attr('title'); 
    var videoId = $("#videoId").html();
    saveThumbnail(videoId, thumbnail);
  });
}

$(document).ready(function () {
  videoThumbnailHandlers();
});


/**
 * Takes a video id and thumbnail and saves to db
 */
function saveThumbnail(videoId, thumbnail){

  var request = $.ajax({
    url: '/adminVideo/ajaxVideoUpdateThumbnail',
    type: 'POST',
    data:({
      'thumbnail': thumbnail,
      'videoId': videoId,
      'CSRF_TOKEN': getCsrfToken()
    }),
    success: function(data){
      alert('Video thumbnail has been updated.');
    },
    error: function(data){
      alert('Unable to update thumbnail.');
      return false;
    }
  });   
}