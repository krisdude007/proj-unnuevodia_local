<?php
// page specific css
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/chosen.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/bootstrap-toggle-buttons.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminEntity/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-timepicker-addon.css');
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$cs->registerCssFile('/core/webassets/css/adminEntity/index.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminEntity/index.js', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/adminEntity/index.js', CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
$count = 0;
$noItemOnRow =4;
?>
<div class="fab-page-content">
    <!-- flash messages -->
    <?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        $messageFormat = '<div class="flashes"><div class="flash-%s">%s</div></div>';
        foreach ($flashMessages as $key => $message) {
            echo sprintf($messageFormat, $key, $message);
        }
    }
    ?>
    <!-- flash messages -->
    <div id="fab-top">
        <h2 class="fab-title">
            <img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/> Contestants Editor
            <?php echo(CHtml::link(' << back to contest',array('contest','id'=>$poll->id))) ?>
        </h2>
    </div>
    <div class="fab-container-fluid">
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div class="pollHolder" style="padding-top:20px;">
                        <div class="form" style="overflow: hidden;">
                            <div class="fab-voting-left">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'admin-voting-form',
                                    'enableAjaxValidation' => true,
                                ));
                                ?>
                                <div>
                                    <h2><?php echo CHtml::label($poll->question, false) ?></h2>
                                </div>
                                <div style="overflow: hidden;">
                                    <h3>Contestants: <?php echo CHtml::htmlButton('Add Contestant',array('rel'=>'overlay','onclick'=>'addContestantClick();return false;')); ?> or click <?php echo CHtml::link('Here','/admin/user',array('target'=>'_blank')); ?> to add user.</h3>
                                    <h4>Order: <?php echo CHtml::link('A to Z',"/admin/entity/contestants?id={$id}"); ?> | <?php echo CHtml::link('Status',"/admin/entity/contestants?id={$id}&e=1"); ?></h4>
                                    <?php foreach ($poll->entityAnswers as $entityAnswer): ?>
                                    <?php $count++; ?>
                                        <div style="float:left;margin: 10px;">
                                            <?php $avatarPath = empty($entityAnswer->eUser->avatarImages[0]->filename)?UserUtility::getAvatar($entityAnswer->eUser):'/userimages/'.$entityAnswer->eUser->avatarImages[0]->filename; ?>
                                            <div class="contestantImg"><?php echo CHtml::link(CHtml::image($avatarPath),'/admin/user/'.$entityAnswer->eUser->id,array('target'=>'_blank')) ?></div>
                                            <?php echo CHtml::label($entityAnswer->eUser->first_name.' '.$entityAnswer->eUser->last_name, false); ?><br/>
                                            <?php echo CHtml::label('Biography:', false); ?><br/>
                                            <?php echo $form->textArea($entityAnswer, "[$entityAnswer->id]biography", array('style' => 'width:120px;','rows'=>6)) ?><br/>
                                            <?php echo $form->checkBox($entityAnswer, "[$entityAnswer->id]eliminated") ?> Eliminated
                                            <p style="text-align:center;padding: 4px;"><?php echo CHtml::htmlButton('Delete',array('onclick'=>'deleteContestantClick('.$entityAnswer->id.');return false;')) ?></p>
                                        </div>
                                    <?php if($count%$noItemOnRow == 0) : ?>
                                    <div style="clear:left;"></div>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($poll->entityAnswers) > 0 ): ?>
                                <div>
                                    <?php echo CHtml::submitButton('Submit'); ?>
                                </div>
                                <?php endif; ?>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>