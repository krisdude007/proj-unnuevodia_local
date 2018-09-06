<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminVideo/videoImportModal.js', CClientScript::POS_END);
?>


<div class="fab-row-fluid" style="color: #fff;">
  <h1>Import Videos</h1>
  <hr/>
</div>

<div class="fab-row-fluid" style="color: #fff;">
  <div id="videoImportModalTabs">
    <ul>
      <li><a href="#tab-vine">Vine</a></li>
      <li><a href="#tab-youtube">YouTube</a></li>
    </ul>
    <div id="tab-vine">
      <div class="fab-row-fluid">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'video-import-vine',
            'enableAjaxValidation' => true,
            'enableClientValidation'=>true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnType' => false,
            )
                ));
        ?>

        <div class="clearfix">
          <?php echo $form->labelEx($formVineModel, 'categoryIdentifier'); ?>
          <?php echo $form->textField($formVineModel, 'categoryIdentifier', array('style' => 'width: 200px;', 'class' => 'fab-small-input fab-left')); ?>
          <?php echo $form->error($formVineModel, 'categoryIdentifier'); ?>
        </div>

        <div class="clearfix">
          <?php echo $form->labelEx($formVineModel, 'numVideos'); ?>
          <?php echo $form->dropDownList($formVineModel, 'numVideos', array('1' => 1, '5' => 5, '10' => 10), array('style' => 'width: 50px;', 'class' => 'fab-select-num')); ?>
          <?php echo $form->error($formVineModel, 'numVideos'); ?>
        </div>

        <div class="clearfix">
          <?php echo $form->hiddenField($formVineModel,'source',array('id' => 'videoImportSource', 'value'=>'Vine')); ?>
          <?php echo CHtml::submitButton('Begin Import',array('class' => 'submitButton', 'style' => 'margin-top:8px;padding-top:0')); ?>
        </div>
        <?php $this->endWidget(); ?>
        
      </div>
    </div>


    <div id="tab-youtube">
      Coming soon.
    </div>


  </div>
</div>

