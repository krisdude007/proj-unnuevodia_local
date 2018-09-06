var req;
function init() {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
			req = new ActiveXObject(
			"Microsoft.XMLHTTP");
            }
}
function updateDBCallBack(uid, filePath, spotName)
{
      $.ajax({ 
          url: '/capture',
          type: 'POST',
          context: document.body,
          data:({
             'file':filePath,
             'source':'web',
             'qID':tag,
             'CSRF_TOKEN':getCsrfToken()
          }),
          success: function(data){
                window.location="/process/"+data;
          }
      });
}
function processRequest()
{
   if (req.readyState == 4) {
       if (req.status == 200) {
           var message = req.responseText;
           alert(message);
        } else {
                 alert("Error!!");
                }
      }
}
function setVideoType(){
	var text="NO";
	var answer=confirm("Do you have an HD Camera and a high speed Internet connection to record?");
	if(answer){
		text= "OK";
	}
	getFlashMovie('youtoorecorder','swf').sendTextToFlash(text);

}
function getFlashMovie(objectId,embedId) {

	return (window[objectId]) ? window[objectId]
              : document[objectId];
}
function openHelp(){
	window.open('Help.html',
  '_blank',    'width=640, height=300,directories=0,location=0,menubar=0,resizable=0,scrollbars=1,status=0,titlebar=0, toolbar=0');
}
function WarnStopBeforeDuration()
{
	var msg="You've stopped the recording before the selected duration. You need to start recording the video all over again.";
	alert(msg);
}



