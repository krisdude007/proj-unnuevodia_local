<div class="form" style="width:400px">
    <?php
     $form = $this->beginWidget('CActiveForm', array(
        'id' => 'image-upload-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div style="font-size: 12px;">
        <?php //echo $form->errorSummary(array($image)); ?>
    </div>
    <div class="clearfix" style="padding-top:20px;">

    </div>
    <div class="clearfix">
        <div class="row">
            <?php echo $form->fileField($uploadimage, 'image'); ?>
            <?php echo $form->error($uploadimage, 'image'); ?>
        </div>
    </div>
    <div class="clearfix">
        <div style="margin-top:12px;margin-right:7px;">
            <div class="row">
                Titulo * Requerido
                <div class="helperText">Esto te ayudará a encontrar tu foto.</div>
                <?php echo $form->textField($uploadimage, 'title'); ?>
                <?php echo $form->error($uploadimage, 'title'); ?>
            </div>

            <div class="row">
                Descripción * Opcional
                <div class="helperText">Describe tu foto para que la gente sepa de qué se trata</div>
                <?php echo $form->textArea($uploadimage, 'description', array('style' => 'width:207px')); ?>
                <?php echo $form->error($uploadimage, 'description'); ?>
            </div>
        </div>
    </div>
    <div class="bold" style="float:left; font-family: hnb; color: #636363; margin-bottom: 10px; font-size:13px">Compártelo también en tus medios sociales</div>
    <div class="clearfix"></div>
    <div class="row" style="font-size:11px">
        <?php echo $form->checkBox($uploadimage, 'to_twitter'); ?>
        <?php echo $form->labelEx($uploadimage, 'to_twitter'); ?>
        <?php echo $form->error($uploadimage, 'to_twitter'); ?>
    </div>
    <div class="row" style="margin-left:20px;font-size:11px">
        <?php echo $form->checkBox($uploadimage, 'to_facebook'); ?>
        <?php echo $form->labelEx($uploadimage, 'to_facebook'); ?>
        <?php echo $form->error($uploadimage, 'to_facebook'); ?>
    </div>
    <div class="clearfix">
        <div class="row buttons" style="float:left;margin-top:12px;margin-right:7px;">
            <?php echo CHtml::submitButton('ENVIAR'); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

