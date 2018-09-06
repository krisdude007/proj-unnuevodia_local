<div style="display: none;" id="fileUploadOverlaySchedule">
    <div id="fileUploadOverlayContent">
        <h2 style="font-size: 18px;">Upload Youtoo America Schedule:</h2>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'schedule-upload-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
            'action' => '/admin/uploadschedule',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => false,
            )
                ));
        ?>

        <label class="fab-left">Schedule PDF file (required):</label>
        <div class="fab-clear" style="height:6px;"></div>
        <div><?php echo $form->fileField($formUploadManualModel, 'uploadfile'); ?></div>
        <div><?php echo $form->error($formUploadManualModel, 'uploadfile'); ?></div>
        <br/><br/>


        <?php echo CHtml::submitButton('Submit'); ?>

        <?php $this->endWidget(); ?>
    </div>
</div>