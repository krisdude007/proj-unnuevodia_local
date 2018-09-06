<div class="fabmob_content-container text-center">
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
    <br/>
    <h2 class="text-center text">¿Olvidaste tu contraseña?</h2>
    <br/>
    <div class="form-group">
        <?php echo $form->emailField($model, 'username', array('class' => 'form-control', 'placeholder' => "Dirección de correo electrónico")); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <br/>
    <div>
        <button id="js-forgot-password-btn" type="submit" style="font-size: 19px; min-width: 165px; min-height: 45px;" class="btn btn-default">Enviar</button>
    </div>
    <a class="active" id="fabmob_forgot-password-cancel-link" style="font-size: 19px;" href="/login">Cancelar</a>
    <?php $this->endWidget(); ?>
</div>
