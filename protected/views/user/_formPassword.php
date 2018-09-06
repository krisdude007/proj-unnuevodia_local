<?php
/* @var $this UserController */
/* @var $user clientUser */
/* @var $form CActiveForm */
?>

<div style="margin:15px 0">
Cambiar tu contraseña.
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-password-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
    ),
));
echo $form->errorSummary(array($user));
?>

<div style="margin-bottom:15px">
    Nueva contraseña<br />
    <?php echo $form->passwordField($user, 'newPassword', array('autocomplete'=>'off')); ?>
    <?php echo $form->error($user, 'newPassword'); ?>
</div>

<div style="margin-bottom:15px">
    Confirmar contraseña<br />
    <?php echo $form->passwordField($user, 'newPasswordConfirm',array('autocomplete'=>'off')); ?>
    <?php echo $form->error($user, 'newPasswordConfirm'); ?>
</div>


<?php echo CHtml::submitButton('Guardar'); ?>

<?php $this->endWidget(); ?>
