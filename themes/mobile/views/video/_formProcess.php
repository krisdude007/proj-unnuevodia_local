<div class="form video_process_form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'video-process-form',
        'enableAjaxValidation' => true,
    ));
    ?>
    <div>
        <?php echo $form->hiddenField($model, 'source', array('value' => 'web')); ?>
        <?php echo $form->hiddenField($model, 'question_id', array('value' => $question_id)); ?>
    </div>
    <?php echo $form->label($model, 'Titulo', array('style'=>'color: #ffffff;')); ?>
    <?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Titulo (Requerido)','style' => 'background-color: #d60000; border: 1px solid #d60000; color: #ffffff;')); ?>
    <?php echo $form->error($model, 'title'); ?><br/>
    <span class="help-block hidden"></span>
    <?php echo $form->label($model, 'Descripción', array('style'=>'color: #ffffff;')); ?>
    <?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'placeholder' => 'Describe tu video.', 'style' => 'background-color: #d60000; border: 1px solid #d60000; color: #ffffff;')); ?>
    <?php echo $form->error($model, 'description'); ?>
    <!--
    <div style="width: 100%">
        <label>Share</label>
    </div>
    <div style="width: 100%;">
        <div class='col-sm-5'>
            <?php echo $form->checkBox($model, 'to_twitter'); ?>
            <?php echo $form->labelEx($model, 'to_twitter'); ?>
            <?php echo $form->error($model, 'to_twitter'); ?>
        </div>
        <div>
            <?php echo $form->checkBox($model, 'to_facebook'); ?>
            <?php echo $form->labelEx($model, 'to_facebook'); ?>
            <?php echo $form->error($model, 'to_facebook'); ?>
        </div>
    </div>
    -->
    <div class='text-center' style='padding: 5%'>
        <?php
        echo CHtml::submitButton('Enviar', array('class' => 'btn btn-default', 'onclick' => "$('#loading_modal').modal({backdrop:'static',keyboard:false});return true;", "style" => "max-width: 140px; border-color: #ffffff !important; color: #ffffff !important; border: solid; padding: 2% 5% !important;"
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<div style="margin-top:20px;display:inline-block;width:100%">
    <input type="hidden" name="question_id" value="<?php print $question_id; ?>">
</div>
<?php $this->renderPartial('/video/_loading_modal'); ?>