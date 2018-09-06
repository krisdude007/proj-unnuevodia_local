<div id="registerWrap">
    <br/>
    <h1>COMIENZA AQUÍ</h1>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-register-form',
        'enableAjaxValidation' => true,
            ));
    ?>
    <table style="margin-top:-10px;height: 320px;">
        <tr>
            <td>Nombre *</td>
            <td>Apellido *</td>
        </tr>
        <tr>
            <td>
                <?php echo $form->textField($user, 'first_name'); ?>
                <?php echo $form->error($user, 'first_name'); ?>
            </td>
            <td>
                <?php echo $form->textField($user, 'last_name'); ?>
                <?php echo $form->error($user, 'last_name'); ?>
            </td>
        </tr>
        <tr>
            <td>Dirección de correo electrónico *</td>
            <td style="width:302px">Confirmar dirección de correo electrónico *</td>
        </tr>
        <tr>
            <td>
                <?php echo $form->textField($userEmail, 'email'); ?>
                <?php echo $form->error($userEmail, 'email'); ?>
            </td>
            <td>
                <?php echo $form->textField($userEmail, 'confirm_email'); ?>
                <?php echo $form->error($userEmail, 'confirm_email'); ?>
            </td>
        </tr>
        <tr>
            <td>Contraseña *</td>
            <td>Confirmar contraseña *</td>
        </tr>
        <tr>
            <td>
                <?php echo $form->passwordField($user, 'password'); ?>
                <?php echo $form->error($user, 'password'); ?>
            </td>
            <td>
                <?php echo $form->passwordField($user, 'confirm_password'); ?>
                <?php echo $form->error($user, 'confirm_password'); ?>
            </td>
        </tr>
        <tr>
            <td>Código postal/ZIP *</td>
            <td>Fecha de nacimiento *</td>
        </tr>
        <tr>
            <td>
                <?php echo $form->textField($userLocation, 'postal_code'); ?>
                <?php echo $form->error($userLocation, 'postal_code'); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($user,'birthMonth',  DateTimeUtility::monthsOfYear()); ?>
                <?php echo $form->dropDownList($user,'birthDay', DateTimeUtility::daysOfMonth()); ?>
                <?php echo $form->dropDownList($user,'birthYear',  DateTimeUtility::yearsOfCentury()); ?>
                <?php echo $form->error($user, 'birthday'); ?>
            </td>
        </tr>
        <tr>
            <td>
            Sexo<br />
            <div>
            <?php
                $gender = array('M' => 'Masculino', 'F' => 'Femenino');
                echo $form->radioButtonList($user, 'gender', $gender, array('labelOptions' => array('style' => 'display:inline;'), 'separator' => '',));
            ?>
            <?php echo $form->error($user, 'gender'); ?>
            </div>
        </td>
        <td style="font-size:10px;padding-top:10px;">
               <?php echo $form->Checkbox($user, 'terms_accepted',array('value' => 1)); ?>
                <a href="#" class="fab-link" onclick="$('#registerTerms').toggle();">He leído y estoy de acuerdo con los Términos de Presentación *</a>
             <?php echo $form->error($user, 'terms_accepted'); ?>
            </td>
        </tr>
        <tr>
            <td style="font-size:12px;padding-top: 30px;">¿Ya tienes nombre de usuario? <a href="/login">¡Haz clic aquí!</a></td>

            <td>
                <?php echo CHtml::submitButton('ENVIAR'); ?>
                <span>
                 regístrate con
                <!--<a href="#" class="twreg"><img src="<?php echo Yii::app()->request->baseurl; ?>/webassets/images/twitter.png"></a>-->
                <a href="#" class="fbreg"><img src="<?php echo Yii::app()->request->baseurl; ?>/webassets/images/facebook.png"></a>
                </span>
            </td>
        </tr>
        <tr>
            <td>

            </td>

        </tr>
    </table>
    <?php echo $form->hiddenField($user, 'source', array('value' => 'web')); ?>
    <input id="screen_width" type="hidden" name="screen_width" value="" />
    <input id="screen_height" type="hidden" name="screen_height" value="" />
    <?php $this->endWidget(); ?>
</div>


<!-- TERMS MODAL -->
<div class="termsOverlay" id="termsOverlayTrigger">
    <div class="termsOverlayContent" ></div>
</div>
<!-- TERMS MODAL -->