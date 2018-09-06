<div class="homeTop">
    <b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día
</div>
<div class="fabmob_content-container">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'video-uploader-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate'=>'js:function(form,data,hasError){
                        if(!hasError){
                            $("#loading_modal").modal({backdrop: "static", keyboard: false});
                        }
                        return true;//enable submit with no Error
            }'
            ),
    ));
    ?>
    <label>( .mov, .mp4 only *)</label><br/>
    <?php echo $form->fileField($uploadvideo, 'video', array('class' => 'form-control','accept'=>'video/quicktime,video/mp4', 'style' => 'background-color: #d60000; border: 1px solid #d60000; color: #ffffff;')); ?>
    <video id='player' controls autoplay style="display:none;width:100%;"></video>
    <?php echo $form->error($uploadvideo, 'video', array('clientValidation' => 'return customValidateFile(messages);')); ?>
    <button class="btn fabmob_auth-flow-btn" style='max-width: 140px; border-color: #ffffff !important; color: #ffffff !important;'>Enviar</button>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('/video/_loading_modal'); ?>
<?php
    $infoFieldFileID = CHtml::activeId($uploadvideo, 'video');
    Yii::app()->getClientScript()->registerScript('videoSelect', "
    function customValidateFile(messages) {
        var nameC = '#" . $infoFieldFileID . "';
        var control = $(nameC).get(0);

        //simulates the required validator and allowEmpty setting of the file validator
        if (control.files.length == 0) {
            messages.push('Video cannot be blank');
            return false;
        }

        file = control.files[0];

        //simulates the maxSize setting of the file validator
        if (file.size > 104857600) {
            messages.push('The file is too large to be uploaded. Maximum is 100 Mb');
            return false;
        }

        //simulates the format type (extra checking) see also http://en.wikipedia.org/wiki/Internet_media_type

        if (file.type != 'video/quicktime' && file.type != 'video/mp4') {
            messages.push('Invalid file type. Only .mov, .mp4 files can be uploaded');
            return false;
        }
        return true;
    }
    ", CClientScript::POS_END);
?>
