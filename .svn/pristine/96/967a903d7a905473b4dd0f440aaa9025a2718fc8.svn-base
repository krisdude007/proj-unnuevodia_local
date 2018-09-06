<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/_login.js', CClientScript::POS_END);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-login-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'class' => 'fab-login-content',
    ),
        ));
?>    

<div class="fab-login-logo">
    <!--<img style="height:94px;" src="<?php echo Yii::app()->request->baseUrl; ?>/webassets/images/logo.png">-->
</div>

<?php if ($model->hasErrors()): ?>
    <div class="fab-title fab-error-color">
        Login Failed
    </div>
<?php else: ?>
    <div class="fab-title">
        Login to your account    
    </div>
<?php endif; ?>

<div class="fab-forms">
    <div class="fab-controls">
        <div class="fab-input-icon fab-left">
            <i class="icon-user"></i>
            <?php echo $form->textField($model, 'username', array('class' => 'fab-m-wrap', 'placeholder' => 'Username', 'style' => 'border-left: 2px solid #35aa47; margin-bottom: 20px; width: 227px')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>
    <div class="fab-controls">
        <div class="fab-input-icon fab-left">
            <i class="icon-lock"></i>
            <?php echo $form->passwordField($model, 'password', array('class' => 'fab-m-wrap', 'placeholder' => 'Password', 'style' => 'border-left: 2px solid #35aa47; margin-bottom: 20px; width: 227px')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
</div>

<div class="fab-controls">
    <!--
    <label class="fab-checkbox fab-pull-left" style="padding-left: 0px; padding-top: 10px !important">
        <div class="fab-checker fab-pull-left" id="fab-remember-me" style="padding-top: 3px !important;"><span><input type="checkbox" value="" style="opacity: 0;"></span></div>
        Remember me
    </label>
    -->
    <button class="fab-btn icn-only fab-green fab-pull-right" style="margin-right: 29px">Login <i class="fab-m-icon-swapright fab-m-icon-white"></i></button>
</div>
<div class="fab-clear"></div>
<hr>
<div class="fab-forgot-password">
    Forgot your password?
    <br/>
    <!-- todo - reset password functionality -->
    <span style="font-size: 13px; line-height: 28px">No worries, <span style="color: #005580">click here </span> to reset your password.</span>
</div>
<hr style="margin: 10px 32px 10px 32px; border-top: 1px dotted #b9b9b9">
<div class="fab-create-account">
    Don’t have an account yet? <a href="#">Create an account</a>
</div>
<?php echo $form->hiddenField($model, 'source', array('value' => 'web')); ?> 
<input id="screen_width" type="hidden" name="screen_width" value="" />
<input id="screen_height" type="hidden" name="screen_height" value="" />
<?php $this->endWidget(); ?>


