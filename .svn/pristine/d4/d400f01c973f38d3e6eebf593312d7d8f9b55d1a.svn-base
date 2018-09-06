<div class="fabmob_content-container text-center" style="padding: 2%;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-password-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal fabmob_condensed-form'),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->passwordField($user, 'newPassword', array('value'=>'','class' => 'form-control', 'placeholder' => 'New Password')); ?>
        <?php echo $form->error($user, 'newPassword'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->passwordField($user, 'newPasswordConfirm', array('class' => 'form-control', 'placeholder' => 'Confirm Password')); ?>
        <?php echo $form->error($user, 'newPasswordConfirm'); ?>
        <span class="help-block hidden"></span>
    </div>
    <br/>
    <button id="js-forgot-password-btn" type="submit" class="btn btn-default">Save</button>
    <?php $this->endWidget(); ?>
</div>
