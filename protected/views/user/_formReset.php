<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-login-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
        )
            ));
    ?>    
    <?php echo $form->errorSummary($model); ?>
    <div class="clearfix">
        <div class="row">
            Dirección de correo electrónico<br />
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="row buttons" style="float:left;margin-top:20px;margin-right:5px;">
            <?php echo $form->hiddenField($model, 'source', array('value' => 'web')); ?>            
            <?php echo CHtml::submitButton('ENVIAR'); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
