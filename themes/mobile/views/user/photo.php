<div class="fabmob_content-container text-center" style="padding: 2%;">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-profileimage-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal fabmob_condensed-form',
            'enctype' => 'multipart/form-data'
        ),
    ));
    ?>
    <div class="link" style="text-align: left;position:relative;">
        <div style="display:inline-block; padding: 1%;">
            <img class="userAvatarXS" src='<?php echo UserUtility::getAvatar($user); ?>'/>
        </div>
        <div style="display:inline-block; padding: 1%;"><h5 class="graylink">Current Photo</h5></div>
        <div style="display:inline-block; padding: 1%;padding-left: 30%; ">
            <span class="custom-file-input">
                Edit  <?php echo $form->fileField($image, 'image', array('accept' => 'image/*')); ?>
            </span>
        </div>
        <div id="file_name" style="padding:0px;font-size: 70%;position: absolute;bottom: 2%; right:2%;overflow: hidden;" class="graylink"></div>
    </div>
    <hr></hr>
    <div style="padding: 0px 1%;">
        <?php echo $form->error($image, 'image', array('clientValidation' => 'customValidateFile(messages);'), false, true); ?>
    </div>
    <?php $infoFieldFile = (end($form->attributes)); ?>
    <br/>
    <button id="js-forgot-password-btn" type="submit" class="btn btn-default">Save</button>
    <?php $this->endWidget(); ?>
</div>
<script>
    function customValidateFile(messages) {
        var nameC = '#<?php echo $infoFieldFile['inputID']; ?>';
        var control = $(nameC).get(0);
        //simulates the required validator and allowEmpty setting of the file validator
        if (control.files.length == 0) {
            messages.push("Image cannot be blank.");
            return false;
        }

        file = control.files[0];
    }
</script>