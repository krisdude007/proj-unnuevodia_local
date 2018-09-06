<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseurl . '//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css');
$cs->registerCss('body','body{width: 720px; height: 58px;}');
$cs->registerCssFile(Yii::app()->request->baseurl . '/core/webassets/css/preview/preview.css');
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/preview/preview.js', CClientScript::POS_END);

$cs->registerScript('graph', "getGraphDataForTV({$activePoll->id});setInterval('getGraphDataForTV({$activePoll->id})',3000);", CClientScript::POS_READY);
?>
<?php if(Yii::app()->params['custom_params']['customSettingForArabic'] === true): ?>
     <?php if (Yii::app()->name == 'BBEIRUT'): ?>
        <img src ="/webassets/images/home/bg_alphaVoting.png" style="width: 720px;">
        <div id="voteDetail" style="text-align: center;position: absolute; top: -10px; left: 30px">
    <?php endif; ?>
    <?php if (Yii::app()->name == 'ALRISALA'): ?>
        <div id="voteDetail" class="<?php echo 'slider'.Yii::app()->name?>" style="text-align: center;">
    <?php endif; ?>
    <?php if (Yii::app()->name == 'YAHALA'): ?>
        <div id="voteDetail" class="<?php echo 'slider'.Yii::app()->name?>" style="text-align: center;">
    <?php endif; ?>
    <?php if (Yii::app()->name == 'FEESAMEEM'): ?>
        <div id="voteDetail" class="<?php echo 'slider'.Yii::app()->name?>" style="text-align: center;">
    <?php endif; ?>
    <?php if (Yii::app()->name == 'KOORA'): ?>
        <div id="voteDetail" class="<?php echo 'slider'.Yii::app()->name?>" style="text-align: center;">
    <?php endif; ?>
<?php endif; ?>
<?php if (!is_null($activePoll)): ?>
            <div style="padding: 5px;">
<!--                <div style="font-size: 30px;color: #007a38;padding: 5px;">
                    <?php if (strtotime($activePoll->end_time) <= time()): ?>
                        إغلاق التصويت
                    <?php else: ?>
                        صوت الآن
                    <?php endif; ?>
                </div>-->
                <?php if (Yii::app()->name == 'FEESAMEEM'): ?>
                <div style="font-size:18px;color: #000000">
                    <?php echo $activePoll->question; ?>
                </div>
                <?php else: ?>
                <div style="font-size:18px;color: #ffffff">
                    <?php echo $activePoll->question; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="afterVote row" <?php echo (strtotime($activePoll->end_time) <= time()) ? '' : 'style="display:inline-block;margin:0 auto;width: 720px;"'; ?>>
                <div class="text-center" style="display:inline-block;">
                    <?php foreach ($activePoll->pollAnswers as $answer): ?>
                        <span class='col-sm-9 vote_div' style="width:160px">
                            <?php if (Yii::app()->name == 'FEESAMEEM'): ?>
                            <div class='vote_label' style='color: #000000'>
                             <?php else: ?>
                             <div class='vote_label'>
                             <?php endif; ?>
                                <span class='pull-left percent'>0%</span>
                                <span class='pull-right'><?php echo $answer->answer; ?></span>
                            </div>
                            <div class="progress">
                                <span class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"  >
                                </span>
                            </div>
                        </span> <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class='row text-center'>
                <h1>No Polls Open!</h1>
            </div>
        <?php endif; ?>
    </div>

