<?php
/* @var $this VideoController */
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
if (!file_exists(Yii::app()->params['paths']['video'] . '/' . basename($videoInfo['videofile']))) {
    $cs->registerScript('reloadVideo', "reloadVideo({$model->id});", CClientScript::POS_END);
}
?>
<div style='padding: 2% 1%;'>
    <h2 class='text-center'>Video Revisión</h2>
</div>
<div id="videoWindow" class="videoWindow" style="padding: 1%;">
    <div id='videoPlayer'>
        <?php $this->renderPartial('/video/_videoPlayer', array('videoInfo' => $videoInfo)); ?>
    </div>
</div>
<div class='process_video graylink' style='padding: 2% 2%;'>
    <?php
    $this->renderPartial('/video/_formProcess', array(
        'model' => $model,
        'question_id' => $question_id,
    ));
    ?>
</div>
