<?php
// page specific css
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/bootstrap-toggle-buttons.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminVoting/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/spectrum.css');
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminVoting/index.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/spectrum.js', CClientScript::POS_END);

$this->renderPartial('/admin/_csrfToken');
?>


<!-- BEGIN PAGE -->
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

    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top" style="background:#852b99;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="marginRight10 floatLeft" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/voting-image.png"/>Send SMS</h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- END PAGE HEADER-->
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div class="pollHolder" style="clear:both;padding-top:20px;">
                        <h2>Send SMS to </h2>

                        <div class="form">
                            <div style="width:600px" class="fab-left fab-voting-left">
                                <?php
                                    $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'send-sms-form',
                                        'enableClientValidation' => true,
                                        'enableAjaxValidation' => false,
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                            'validateOnChange' => true,
                                            'validateOnType' => false,
                                        )
                                    ));
                                ?>
                                
                                    <div>
                                        <?php echo $form->labelEx($formSendSMSModel, 'phone'); ?>
                                        <?php echo $form->textField($formSendSMSModel, 'phone', array('style' => 'width: 300px', 'value' => $username)); ?>
                                        <?php echo $form->error($formSendSMSModel, 'phone'); ?>

                                        <?php echo $form->hiddenField($formSendSMSModel, 'user_id', array('value' => $user_id)); ?>
                                    </div>

                                    <div>
                                        <?php echo $form->labelEx($formSendSMSModel, 'message'); ?>
                                        <?php echo $form->textField($formSendSMSModel, 'message', array('style' => 'width: 500px', 'class' => 'counter')); ?>
                                        <?php echo $form->error($formSendSMSModel, 'message'); ?>

                                        <?php echo $form->hiddenField($formSendSMSModel, 'user_id', array('value' => $user_id)); ?>
                                    </div>

                                    <div class="submit_button" style="clear:both">
                                        <?php echo CHtml::submitButton(Yii::t('youtoo','Submit')); ?>
                                    </div>

                                <?php $this->endWidget(); ?>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->

