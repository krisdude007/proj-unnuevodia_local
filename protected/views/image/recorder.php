<?php
/* @var $this VideoController */
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/swfobject.js', CClientScript::POS_HEAD);
$cs->registerScriptFile('/webassets/js/cbUtil.js', CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    var tag="<?php echo $question_id; ?>";
    var question="<?php echo htmlentities($question, ENT_QUOTES); ?>";
    var swfVersionStr = "10.0.0";
    var xiSwfUrlStr = "expressInstall.swf";
    var flashvars = {'max_dur':'<?php echo $duration; ?>','uid':'<?php echo $user_id; ?>','recMode':'','server':'rtmp://<?php echo $wowzaip; ?>/vod/','integrationURL':'/newrecorder/hd/','micTint':100,'micHexColor':'0x2796A9','frameTint':100,'frameHexColor':'0x2796A9'};
    var params = {};
    params.quality = "high";
    params.wmode="opaque";
    params.allowscriptaccess = "true";
    params.allowfullscreen = "true";
    var attributes = {};
    attributes.id = "youtoorecorder";
    attributes.name = "youtoorecorder";
    attributes.align = "middle";
    swfobject.embedSWF("/core/webassets/swf/recorder.swf?id=<?php echo time(); ?>", "flashContent", "710", "426", swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
    swfobject.createCSS("#flashContent", "display:block;");
</script>    

<div id="content">
    <div class="recorder">
        <div class="topic bold">
            <?php echo $question; ?>
        </div>
        <center>
            <div style="clear:both;display:inline-block;">
                <div id="flashContent">
                    <p>To view this page ensure that Adobe Flash Player version 10.3.187.7 or greater is installed.</p>
                    <script type="text/javascript">
                        var pageHost = ((document.location.protocol == "https:") ? "https://" :	"http://");
                        document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"
                            + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>" );
                    </script>
                </div>                
            </div>
        </center>
    </div>
    
    <!--
    <div class="overlay" style="background:url('/webassets/images/record/overlay.png');position:absolute;top:0;left:0;width:100%;height:100%">
        <div style="margin-top:195px;margin-left:auto;margin-right:auto;width:464px;height:299px;text-align:left;background:url('/webassets/images/record/pop-up-box.png');position:relative;color:#FFF">
            <div style="position:absolute;top:-13px;right:-15px">
                <a href="javascript:void(0)" onclick="$('.overlay').toggle()">
                    <img src="/webassets/images/record/close-button.png" />
                </a>                        
            </div>
            <div style="padding:20px;">
                <div style="text-align:center;color:#fcc51e;font-size:58px;margin-bottom:20px;">
                    WAIT!
                </div>
                <ul>
                    <li>Do you want us to hear you? Us too! Turn down your TV and/or music please!</li>
                    <li>Make sure you speak clearly—and no foul language.</li>
                    <li>Fill up all 10 seconds to amp up your chances of being chosen.</li>
                    <li>BE YOURSELF, and have fun. Don’t do anything we wouldn't do.</li>      
                </ul>
            </div>
        </div>        
    </div>--> 
</div>