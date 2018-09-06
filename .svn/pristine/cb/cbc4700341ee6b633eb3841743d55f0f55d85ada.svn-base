<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
?>

<div class="fabmob_content-container text-center">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-login-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal fabmob_condensed-form',
        ),
    ));
    ?>
    <br/>
    <h2 class="text-center text">Iniciar</h2>
    <br/>
    <div class="form-group">
        <?php echo $form->textField($model, 'username', array('class' => 'form-control fabmob_round-border-top', 'placeholder' => 'Dirección de correo electrónico')); ?>
    </div>
    <div id="fabmob_login-password-form-input" class="form-group">
        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control fabmob_round-border-top', 'placeholder' => 'contraseña')); ?>
    </div>
    <?php echo $form->hiddenField($model, 'source', array('value' => 'mobile web')); ?>
    <a id="fabmob_login-forgot-password-link" class="active" style="font-size: 19px;" href="/forgot">¿Olvidaste tu contraseña?</a>
    <div>
        <button type="submit" class="btn btn-default" style="min-width: 165px; min-height: 45px;">Iniciar</button>
    </div>
    <?php $this->endWidget(); ?>
    <h5 class='horizontalLine text'>O</h5>
<!--    <div class="SocialLoginImage">
        <div>
            <img class="fbreg SocialLoginImage" src="/webassets/mobile/images/Button_Facebook_Login.png"/>
        </div>
        <div style="margin-top:10px">
            <img class="twreg SocialLoginImage" src="/webassets/mobile/images/Button_Twitter_Login.png"/>
        </div>
    </div>-->
    <p id="fabmob_login-register-copy" class="text" style="font-size: 19px;">
        ¿Eres nuevos en Telemundo?
    </p>
    <a id="fabmob_login-register-link" class="active" style="font-size: 19px;" href="/register">Registrate</a>
</div>
