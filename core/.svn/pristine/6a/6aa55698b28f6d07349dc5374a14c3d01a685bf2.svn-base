
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/core/webassets/js/adminPrize/index.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/adminPrize/index.css');
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$cs->registerScript('typeSelect', "function typeChanged(value){ $('.question').hide();$('.question > select').attr('disabled',true);$('#'+value+'Question > select')[0].disabled= false;$('#'+value+'Question').toggle(); }", CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
?>


<div class="fab-page-content">
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 class="fab-title">
            <img class="floatLeft" style="margin-right: 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>
            <div class="floatLeft">Store Editor (<?php echo CHtml::link('Export CSV Report', array('adminPrize/export'), array('title' => 'Export CSV Report')); echo ', '; echo CHtml::link('HTML Report', array('adminPrize/HTMLTable'), array('target'=>'_blank'), array('title' => 'HTML Report')); ?>)</div>
        </h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- BEGIN PAGE HEADER-->

        <!-- END PAGE HEADER-->
        <div id="fab-dashboard">
            <div style="padding:0px 20px 0px 20px; color: #000;">

                <div style="padding: 0px 0px 0px 30px;">
                    <div class="row">
                        <h3>Create Item</h3>
                    </div>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'admin-prize-form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    ));
                    ?>
                    <?php //echo $form->errorSummary(array($prizeModel)); ?>

                    <div class="row">
                        <span style="width: 12%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'type'); ?>
                            <?php echo $form->dropDownList($prizeModel, 'type', array('product' => 'Product', 'video' => 'Video', 'ticker' => 'Ticker'), array('onchange' => 'typeChanged(this.value);', 'style' => 'width:120px;')); ?>
                            <?php echo $form->error($prizeModel, 'type'); ?>
                            <span class="question pull-right" id="tickerQuestion" style="<?php echo $prizeModel->type == 'ticker' ? '' : 'display:none' ?>">
                                <?php echo $form->labelEx($prizeModel, 'question_id'); ?>
                                <?php echo $form->dropDownList($prizeModel, 'question_id', $tickerQuestions, array('style' => 'width:120px;', 'disabled' => $prizeModel->type == 'ticker' ? false : true)); ?>
                                <?php echo $form->error($prizeModel, 'question_id'); ?>
                            </span>
                            <div class="question" id="videoQuestion" style="<?php echo $prizeModel->type == 'video' ? '' : 'display:none' ?>">
                                <?php echo $form->labelEx($prizeModel, 'question_id'); ?>
                                <?php echo $form->dropDownList($prizeModel, 'question_id', $videoQuestions, array('style' => 'width:120px;', 'disabled' => $prizeModel->type == 'video' ? false : true)); ?>
                                <?php echo $form->error($prizeModel, 'question_id'); ?>
                            </div>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'name'); ?>
                            <?php echo $form->textField($prizeModel, 'name'); ?>
                            <?php echo $form->error($prizeModel, 'name'); ?>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'description'); ?>
                            <?php echo $form->textArea($prizeModel, 'description', array('maxlength' => 300, 'rows' => 2, 'cols' => 100)); ?>
                            <?php echo $form->error($prizeModel, 'description'); ?>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'image'); ?>
                            <?php echo $form->fileField($prizeModel, 'image'); ?>
                            <?php echo $form->error($prizeModel, 'image'); ?>
                        </span>
                    </div>

                    <div class="row">
                        <span style="width: 12%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'quantity'); ?>
                            <?php echo $form->textField($prizeModel, 'quantity', array('style' => 'width: 50px;;')); ?>
                            <?php echo $form->error($prizeModel, 'quantity'); ?>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'credits_required'); ?>
                            <?php echo $form->textField($prizeModel, 'credits_required', array('style' => 'width: 50px;;')); ?>
                            <?php echo $form->error($prizeModel, 'credits_required'); ?>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'sponsor'); ?>
                            <?php echo $form->textField($prizeModel, 'sponsor'); ?>
                            <?php echo $form->error($prizeModel, 'sponsor'); ?>
                        </span>
                        <span style="width: 20%; float: left;">
                            <?php echo $form->labelEx($prizeModel, 'market_value'); ?>
                            <?php echo $form->textField($prizeModel, 'market_value', array('style' => 'width: 50px;;')); ?>
                            <?php echo $form->error($prizeModel, 'market_value'); ?>
                        </span>
                    </div>

                    <div class="row">
                        <?php echo CHtml::submitButton('Add Item'); ?>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>

                <div>
                    <?php
                    $dataProvider = $prizes->search();
                    $dataProvider->sort = array(
                        'defaultOrder' => 'id DESC'
                    );

                    $assetsDir = Yii::app()->params['paths']['image'] . '/';
                    //print $assetsDir;
                    $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'admin-prize-grid',
                        'dataProvider' => $dataProvider,
                        'filter' => $prizes,
                        'pager' => array(
                            'prevPageLabel' => 'Prev',
                            'nextPageLabel' => 'Next',
                        ),
                        'columns' => array(
                            array(
                                'name' => 'id',
                                'type' => 'raw',
                                //'value' => 'CHtml::encode($data->user->username)',
                                'htmlOptions' => array('style' => "width:20px;")
                            ),
                            array(
                                'name' => 'user_id',
                                'header' => "Created By",
                                'type' => 'raw',
                                'value' => 'CHtml::encode($data->user->username)',
                            ),
                            array(
                                'name' => 'name',
                                'type' => 'raw',
                            //'value' => 'CHtml::encode($data->user->username)',
                            ),
                            array(
                                'name' => 'description',
                                'type' => 'raw',
                            //'value' => 'CHtml::encode($data->user->username)',
                            ),
                            array(
                                'name' => 'image',
                                'type' => 'raw',
                                'filter' => false,
                                //'value' => '$data->image',
                                'value' => function($data) {
                                    $url = "/userimages/".$data->image;
                                    return '<a href="'.$url.'" target="_blank"><img src="'.$url.'" style="max-width: 50px;"></a>';
                                },
                            ),
                            array(
                                'name' => 'quantity',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => "text-align:center; width: 15px;")
                            ),
                            array(
                                'name' => 'credits_required',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => "text-align:center; width: 15px;")
                            ),
                            array(
                                'name' => 'sponsor',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => "text-align:center; width: 50px;"),
                            ),
                            array(
                                'name' => 'market_value',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => "text-align:center; width: 15px;")
                            ),
                            array(
                                'name' => 'enabled',
                                'header' => "Enabled",
                                'value' => '$data->enabled?Yii::t(\'app\',\'Yes\'):Yii::t(\'app\', \'No\')',
                                'filter' => CHtml::dropDownList('ePrize[enabled]', $prizes->enabled, array(NULL => 'All', '1' => 'Yes', '0' => 'No')),
                                'htmlOptions' => array('style' => "text-align:center; width: 70px;"),
                            ),
                            array(
                                'name' => 'created_on',
                                'header' => "Date Created",
                                'type' => 'raw',
                                'value' => '$data->created_on',
                                'htmlOptions' => array('style' => "text-align:center;")
                            ),
                            array(
                                'name' => 'updated_on',
                                'header' => "Date Updated",
                                'type' => 'raw',
                                'value' => '$data->updated_on',
                                'htmlOptions' => array('style' => "text-align:center;")
                            ),
                            array
                                (
                                'class' => 'CButtonColumn',
                                'template' => '{edit} <br> {enableOn}{enableOff} <br> {disableOn}{disableOff}',
                                'header' => "Edit/Enable/Disable",
                                'buttons' => array
                                    (
                                    'edit' => array
                                        (
                                        'label' => 'Edit',
                                        'url' => 'Yii::app()->createUrl("adminPrize/update", array("id"=>$data->id))',
                                    ),
                                    'enableOn' => array
                                        (
                                        'label' => 'Publish',
                                        //'imageUrl' => '/webassets/images/iconEnable.png',
                                        'url' => 'Yii::app()->createUrl("adminPrize/enable", array("id"=>$data->id))',
                                        'visible' => '$data->enabled == 0',
                                    ),
                                    'enableOff' => array
                                        (
                                        'label' => '<strike>Publish</strike>',
                                        //'imageUrl' => '/webassets/images/iconEnable.png',
                                        //'url' => 'Yii::app()->createUrl("adminPrize/enable", array("id"=>$data->id))',
                                        'visible' => '$data->enabled == 1',
                                    ),
                                    'disableOn' => array
                                        (
                                        'label' => 'Unpublish',
                                        //'imageUrl' => '/webassets/images/iconDisable.png',
                                        'url' => 'Yii::app()->createUrl("adminPrize/disable", array("id"=>$data->id))',
                                        'visible' => '$data->enabled == 1',
                                    ),
                                    'disableOff' => array
                                        (
                                        'label' => '<strike>Unpublish</strike>',
                                        //'imageUrl' => '/webassets/images/iconDisable.png',
                                        //'url' => 'Yii::app()->createUrl("adminPrize/disable", array("id"=>$data->id))',
                                        'visible' => '$data->enabled == 0',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>


