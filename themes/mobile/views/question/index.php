<?php
function escapeJavaScriptText($string)
{
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}
?>
<div class="overlayBackGroundMob">
    <div style='position: absolute; bottom: 6%; width: 98%'>
    <div class="overlayPopupMob">
        <div class="overlayBodyMob">
            <?php if(!Yii::app()->user->isGuest) : ?>
<!--            <div style="text-align:center; margin-bottom: 5px;"><a class="linkButton" style="font-size: 18px;" id="record">Record a Video</a></div>
            <hr style="margin-top: 0px; margin-bottom: 0px;">-->
            <div style="text-align:center; margin-bottom: 5px;"><a class="linkButton" style="font-size: 18px;" id="upload">Upload a Video</a></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="overlayPopupCloseMob">
        <div class="overlayBodyCloseMob">
            <div style="text-align:center;color:#636363; font-size: 18px">Cancel</div>
        </div>
    </div>
    </div>
</div>
<div>
    <div class="homeTop">
        <b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día
    </div>
    <div class="homeFooter text-center">
        <div style='text-align: center;background-color:#d8512b;padding: 2% 0px; padding-bottom: 0px;'>
            <div style="display:inline-block;padding: 2px;"><h1 style="float:left;padding: 0px 3px; font-size: 24px;">Elije un tema</h1></div>
        </div>
        <img src="/webassets/mobile/images/Icon_Video.png" style="max-width: 54px; width: 100%; margin-top: 10px; margin-bottom: 20px;"/>

<!--        <div style='background-color:#0f668f;padding: 3% 1%;'>
            <button class="filledButton">
                <h6 style="font-size: 11px; margin-bottom: 0px;">Click on the question you want to record yourself answering.</h6>
                <h6 style="font-size: 11px; padding-bottom: 6px; margin-bottom: 0px;">Now you're one step closer to getting on TV!</h6>
            </button>
        </div>-->
    </div>
</div>
<div class="link" style="background-color: #d8512b;">
    <?php foreach ($questions as $question) : ?>
            <?php if(Yii::app()->user->isGuest): ?>
            <div onclick="window.location='/questions'">
                <a style="color:#ffffff;"><?php echo $question->question; ?></a>
            </div>
            <?php else: ?>
            <div onclick="overlayHandlersForRecordMob(<?php echo ($question->id . ",'" . escapeJavaScriptText($question->question). "'");?>);">
                <a style="color:#ffffff;"><?php echo $question->question; ?></a>
            </div>
            <?php endif; ?>
<!--        <hr></hr>-->
    <?php endforeach; ?>
</div>


