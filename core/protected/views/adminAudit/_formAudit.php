<div class="form">
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-audit-form',
            'enableAjaxValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
    ?>
    <?php echo $form->errorSummary(array($user, $auditStart, $auditEnd)); ?>
    <div class="row">
        <?php echo $form->labelEx($user, 'username'); ?>
        <?php echo $form->textField($user, 'username'); ?>
        <?php echo $form->error($user, 'username'); ?>
    </div>
    <div class="row">
        <div class="floatLeft marginRight10">
            <label for="eAudit_created_on">Start Time</label>
            <?php echo $form->textField($auditStart, 'created_on', array('class'=>'ui-timepicker-input')); ?> <?php echo(date('T'));?>
            <?php echo $form->error($auditStart, 'created_on'); ?>
        </div>
        <div class="floatLeft marginRight10">
            <label for="eAudit_end_time">End Time</label>
            <input class="ui-timepicker-input" name="eAudit[end_time]" id="eAudit_end_time" type="text"> <?php echo(date('T'));?>
            <?php echo $form->error($auditEnd, 'created_on'); ?>
        </div>
    </div>
    <div class="row">
        <?php echo CHtml::submitButton('Perform Audit'); ?>
    </div>
<?php $this->endWidget(); ?>
</div>
