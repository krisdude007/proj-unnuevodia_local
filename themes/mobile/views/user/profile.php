<div class="fabmob_content-container" style="padding: 2%;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-profile-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array(
            'class' => 'form-horizontal fabmob_condensed-form',
        ),
    ));
    ?>
    <div class="form-group">
        <?php echo $form->textField($user, 'first_name', array('class' => 'form-control fabmob_round-border-top', 'placeholder' => 'First Name')); ?>
        <?php echo $form->error($user, 'first_name'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->textField($user, 'last_name', array('class' => 'form-control', 'placeholder' => 'Last Name')); ?>
        <?php echo $form->error($user, 'last_name'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->emailField($userEmail, 'email', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
        <?php echo $form->error($userEmail, 'email'); ?>
        <?php echo $form->error($user, 'username'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->textField($userLocation, 'postal_code', array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>
        <?php echo $form->error($userLocation, 'postal_code'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->textField($userPhone, 'number', array('class' => 'form-control', 'placeholder' => 'Phone Number')); ?>
        <?php echo $form->error($userPhone, 'number'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->dateField($user, 'birthday', array('class' => 'form-control fabmob_round-border-bottom', 'placeholder' => 'Date of Birth', 'style' => 'width: 100%')); ?>
        <?php echo $form->error($user, 'birthday'); ?>
        <span class="help-block hidden"></span>
    </div>
    <div class="form-group">
        <?php echo $form->dropDownList($user, 'gender', array('M' => 'Male', 'F' => 'Female') , array('separator' => ' ', 'class' => 'form-control fabmob_round-border-bottom', 'placeholder' => 'Gender')); ?>
        <?php echo $form->error($user, 'gender'); ?>
        <span class="help-block hidden"></span>
    </div>
    <br/>
    <button type="submit" class="btn btn-default" class="btn btn-block">Save</button>
    <?php $this->endWidget(); ?>
</div>