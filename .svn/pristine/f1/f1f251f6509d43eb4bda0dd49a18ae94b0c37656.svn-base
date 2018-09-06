<div class='text' style='padding: 15px;'>
    <?php echo Yii::t('youtoo','What can we help you with today?'); ?>
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'contact-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class='row'>
            <div class="col-sm-3 col-sm-offset-1">
                <?php echo Yii::t('youtoo','Department'); ?>
            </div>
            <div class='col-sm-8'>
                <?php
                echo $form->dropDownList($model, 'department', array(
                    'General Question' => 'General Question',
                    'Technical Question' => 'Technical Question',
                    'Operations' => 'Operations',
                    'Sales' => 'Sales',
                ));
                ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-3 col-sm-offset-1">
                <?php echo $form->labelEx($model, 'name'); ?>
            </div>
            <div class='col-sm-8'>
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-3 col-sm-offset-1">
                <?php echo $form->labelEx($model, 'email'); ?>
            </div>
            <div class='col-sm-8'>
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-3 col-sm-offset-1">
                <?php echo $form->labelEx($model, 'subject'); ?>
            </div>
            <div class='col-sm-8'>
                <?php echo $form->textField($model, 'subject'); ?>
                <?php echo $form->error($model, 'subject'); ?>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-3 col-sm-offset-1">
                <?php echo $form->labelEx($model, 'message'); ?>
            </div>
            <div class='col-sm-8'>
                <?php echo $form->textArea($model, 'message', array('rows' => 6, 'cols' => '40')); ?>
                <?php echo $form->error($model, 'message'); ?>
            </div>
        </div>
        <div>*required</div>
        <div style='text-align: center;'>
            <button class='btn'><?php echo Yii::t('youtoo','Send'); ?></button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>