<?php
/* @var $this UserController */
/* @var $user User */
/* @var $userEmail UserEmail */
/* @var $userLocation UserLocation */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-twitter-form',
            'enableAjaxValidation' => true,
        ));
    ?>
    <?php echo $form->errorSummary(Array($user,$userEmail,$userLocation)); ?>
    
    <div class="clearfix">
        <div class="row">
            <?php echo $form->labelEx($userEmail, 'email'); ?>
            <?php echo $form->textField($userEmail, 'email'); ?>
            <?php echo $form->error($userEmail, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($user, 'password'); ?>
            <?php echo $form->passwordField($user, 'password'); ?>
            <?php echo $form->error($user, 'password'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="row">
            <?php echo $form->labelEx($user,'birthday'); ?>
            <div>
                <?php echo $form->dropDownList($user,'birthMonth',  DateTimeUtility::monthsOfYear()); ?>                
                <?php echo $form->dropDownList($user,'birthDay', DateTimeUtility::daysOfMonth()); ?>
                <?php echo $form->dropDownList($user,'birthYear',  DateTimeUtility::yearsOfCentury()); ?>
                <?php echo $form->error($user, 'birthday'); ?>
            </div>                
        </div>
        <div class="row">
            <?php
                $gender = array('M'=>'Male', 'F'=>'Female');
                echo $form->radioButtonList($user,'gender',$gender,array('separator'=>' '));
            ?>
            <?php echo $form->error($user, 'gender'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="row">
            <?php echo $form->labelEx($user, 'first_name'); ?>
            <?php echo $form->textField($user, 'first_name'); ?>
            <?php echo $form->error($user, 'first_name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($user, 'last_name'); ?>
            <?php echo $form->textField($user, 'last_name'); ?>
            <?php echo $form->error($user, 'last_name'); ?>
        </div>
    </div>

    <div class="clearfix">
        <div class="row">
            <?php echo $form->labelEx($userLocation, 'postal_code'); ?>
            <?php echo $form->textField($userLocation, 'postal_code'); ?>
            <?php echo $form->error($userLocation, 'postal_code'); ?>
        </div>        
        <div class="row buttons" style="float:right;margin-top:12px;margin-right:7px;">
        <?php echo $form->hiddenField($user,'source',array('value'=>'web')); ?>            
        <input type="hidden" name="twuser" value="<?php echo $access_token['user_id']; ?>" />
        <input type="hidden" name="secret" value="<?php echo $access_token['oauth_token_secret']; ?>" />
        <input type="hidden" name="token" value="<?php echo $access_token['oauth_token']; ?>" />
        <input id="screen_width" type="hidden" name="screen_width" value="" />
        <input id="screen_height" type="hidden" name="screen_height" value="" />                    
        <?php echo CHtml::submitButton(''); ?>
        </div>
    </div>    
    
<?php $this->endWidget(); ?>

</div><!-- form -->
