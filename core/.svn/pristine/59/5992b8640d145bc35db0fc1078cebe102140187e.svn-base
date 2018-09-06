<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminEmail/index.css');
?>
<?php $this->renderPartial('/admin/_csrfToken', array()); ?>
<div class="fab-page-content">
    <div id="fab-top" style="background:#E02222;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/video-admin-image.jpg"/>Email Template</h2>
    </div>
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <div class="fab-container-fluid" style="padding: 1% 2%;">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-email-form',
            'enableAjaxValidation' => false,
        ));
        ?>
        <p><label style="margin: 0px 10px;"><?php echo $form->labelEx($emailTemplate, 'name'); ?>: </label><?php echo $form->textField($emailTemplate, 'name', array('maxlength' => '140','readonly'=>'readonly')); ?></p>
        <p><label style="margin: 0px 10px;"><?php echo $form->labelEx($emailTemplate, 'subject'); ?>: </label><?php echo $form->textField($emailTemplate, 'subject', array('maxlength' => '140')); ?></p>
        <p><label style="margin: 0px 10px;"><?php echo $form->labelEx($emailTemplate, 'content'); ?>: </label>
        <?php
        Yii::import('ext.imperavi-redactor-widget-master.ImperaviRedactorWidget');
        $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $emailTemplate,
            'attribute' => 'content',
            // or just for input field
            //'name' => 'my_input_name',
            // Some options, see http://imperavi.com/redactor/docs/
            'options' => array(
                //'lang' => 'en',
                //'toolbar' => true,
                //'iframe' => true,
                //'css' => 'wym.css',
                //'fileUpload'=>Yii::app()->createUrl('post/fileUpload',array('attr'=>'content')),
                //'fileUploadErrorCallback'=>new CJavaScriptExpression('function(obj,json) { alert(json.error); }'),
                //'imageUpload'=>Yii::app()->createUrl('adminEmail/imageUpload'),
                ////'imageGetJson'=>Yii::app()->createUrl('adminEmail/imageList'),
                ////'imageUploadErrorCallback'=>new CJavaScriptExpression('function(obj,json) { alert(json.error); }'),
            ),

        ));
        ?>
        <?php //echo $form->textArea($emailTemplate, 'content', array('rows' => 10,'style'=>'width:400px;')); ?>
        </p>
        <p><label style="margin: 0px 10px;"><?php echo $form->labelEx($emailTemplate, 'active'); ?>: </label><?php echo  $form->checkBox($emailTemplate,'active'); ?></p>
        <div>
            <?php echo CHtml::submitbutton('Save'); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>