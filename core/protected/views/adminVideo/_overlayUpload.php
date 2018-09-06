<div style="display: none;" id="videoUploadOverlay">
    <div id="videoUploadOverlayContent">
        <h2 style="font-size: 18px;">Upload a video:</h2>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'video-upload-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
            'action' => '/adminVideo/upload',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => false,
            )
                ));
        ?>


        <label class="fab-left compactRadioGroup">
            <?php $formVideoUploadModel->is_ad = 1;?>

            <?php
            if(Yii::app()->params['video']['adminAllowAdUpload'])
            {
                echo $form->radioButtonList($formVideoUploadModel, 'is_ad', array('1' => 'Ad', '0' => 'Question'), array('class' => 'is_ad_selector', 'labelOptions'=>array('style'=>'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;'));
            }
            else
            {
                echo $form->radioButtonList($formVideoUploadModel, 'is_ad', array('1' => 'Question'), array('class' => 'is_ad_selector', 'labelOptions'=>array('style'=>'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;'));
            }

            ?>

        </label>

        <div class="fab-clear" style="height:6px;"></div>
        <?php echo $form->dropDownList($formVideoUploadModel, 'question_id', $questionsUpload, array('class' => 'fab-select-question', 'id' => 'question_selector')); ?>
        <div class="fab-clear" style="height:6px;"></div>

        <label class="fab-left">Title (required):</label>
        <div class="fab-clear" style="height:6px;"></div>
        <div><?php echo $form->textField($formVideoUploadModel, 'title', array('style' => 'width: 200px;', 'class' => 'fab-small-input fab-left')); ?></div>
        <div><?php echo $form->error($formVideoUploadModel, 'title'); ?></div>
        <br/><br/>

        <div id="company_info">
        <label class="fab-left">Company Name:</label>
        <div class="fab-clear" style="height:6px;"></div>
        <div><?php echo $form->textField($formVideoUploadModel, 'company_name', array('style' => 'width: 200px;', 'class' => 'fab-small-input fab-left')); ?></div>
        <div><?php echo $form->error($formVideoUploadModel, 'company_name'); ?></div>
        <br/><br/>

        <label class="fab-left">Company Email:</label>
        <div class="fab-clear" style="height:6px;"></div>
        <div><?php echo $form->textField($formVideoUploadModel, 'company_email', array('style' => 'width: 200px;', 'class' => 'fab-small-input fab-left')); ?></div>
        <div><?php echo $form->error($formVideoUploadModel, 'company_email'); ?></div>
        <br/><br/>
        </div>

        <label class="fab-left">Tags:</label>
        <div class="fab-clear" style="height:6px;"></div>
        <?php echo $form->textField($formVideoUploadModel, 'tags', array('id' => 'videoUploadTags')); ?>
        <?php echo $form->error($formVideoUploadModel, 'tags'); ?>

        <label class="fab-left">Video file (required):</label>
        <div class="fab-clear" style="height:6px;"></div>.mov files only *
        <div><?php echo $form->fileField($formVideoUploadModel, 'video'); ?></div>
        <div><?php echo $form->error($formVideoUploadModel, 'video'); ?></div>
        <br/><br/>


        <?php echo CHtml::submitButton('Submit'); ?>

        <?php $this->endWidget(); ?>
    </div>
</div>