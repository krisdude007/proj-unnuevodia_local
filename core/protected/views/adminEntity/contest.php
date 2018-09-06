<?php
// page specific css
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/chosen.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/bootstrap-toggle-buttons.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminEntity/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-timepicker-addon.css');
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$cs->registerCssFile('/core/webassets/css/adminEntity/index.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminEntity/index.js', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/adminEntity/index.js', CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
?>
<div class="fab-page-content">
    <!-- flash messages -->
    <?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        $messageFormat = '<div class="flashes"><div class="flash-%s">%s</div></div>';
        foreach ($flashMessages as $key => $message) {
            echo sprintf($messageFormat, $key, $message);
        }
    }
    ?>
    <!-- flash messages -->
    <div id="fab-top">
        <h2 class="fab-title"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>Contest Editor</h2>
    </div>
    <div class="fab-container-fluid">
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div class="pollHolder" style="padding-top:20px;">
                        <h2>Create/Edit Contest:</h2>
                        <div class="form" style="overflow: hidden;">
                            <div class="fab-left fab-voting-left">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'admin-entity-form',
                                    'enableAjaxValidation' => true,
                                ));
                                ?>
                                <div>
                                    <?php echo CHtml::label('Name *', false); ?>
                                    <?php echo $form->textField($poll,'question'); ?>
                                    <?php echo $form->error($poll, 'question'); ?>
                                </div>
                                <div style="overflow: hidden;">
                                    <div style="float:left;">
                                    <?php echo $form->labelEx($poll,'start_time'); ?>
                                    <?php echo $form->textField($poll, 'start_time', array('class' => 'ui-timepicker-input')); ?> <?php echo(date('T')); ?>
                                    <?php echo $form->error($poll, 'start_time'); ?>
                                    </div>
                                    <div style="float:left; width: 40px;">&nbsp;</div>
                                    <div style="float:left;">
                                    <?php echo $form->labelEx($poll,'end_time'); ?>
                                    <?php echo $form->textField($poll, 'end_time', array('class' => 'ui-timepicker-input')); ?> <?php echo(date('T')); ?>
                                    <?php echo $form->error($poll, 'end_time'); ?>
                                        </div>
                                </div>
                                <div>
                                    <?php echo CHtml::submitButton('Submit'); ?>
                                    <button type="button" onclick="window.location.href = '/admin/entity/contest';">Reset</button>
                                </div>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                        <div style="padding-top:40px">
                            <h2>Previous/Current Contest</h2>
                            <table id="entityTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width:30%">Name</th>
                                        <th style="width:15%">Contestants</th>
                                        <th style="width:35%">Duration</th>
                                        <th style="width:20%">Responses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($polls as $poll) : ?>
                                    <tr>
                                        <td><?php echo(CHtml::link($poll->question,array('contest','id'=>$poll->id))) ?></td>
                                        <td style="text-align: right;"><?php echo(CHtml::link(count($poll->entityAnswers).' contestants',array('contestants','id'=>$poll->id))) ?></td>
                                        <td style="text-align: center;"><?php echo date("Y-m-d h:i a",strtotime($poll->start_time))." ".date('T')." to ".date("Y-m-d h:i a",strtotime($poll->end_time))." ".date('T') ?></td>
                                        <td style="text-align: right;"><?php echo($poll->entityTally) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
