<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile('/core/webassets/css/jquery-ui-timepicker-addon.css');
$cs->registerCssFile('/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile('/core/webassets/css/adminAudit/index.css');

$cs->registerScriptFile('/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/adminAudit/index.js', CClientScript::POS_END);
?>

<div class="fab-page-content">
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 class="fab-title"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>Audit Trail</h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- BEGIN PAGE HEADER-->

        <!-- END PAGE HEADER-->
        <div id="fab-dashboard">

            <div style="margin-bottom:20px">
                Click on the column title to sort by that column.
            </div>

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'admin-user-grid',
                'dataProvider' => $audits->search(),
                'filter' => $audits,
                'pager' => array(
                    'prevPageLabel' => 'Prev',
                    'nextPageLabel' => 'Next',
                ),
                'columns' => array(
                    array(
                        'name' => 'username',
                        'type' => 'raw',
                        'value' => 'CHtml::encode($data->user->username)',
                    ),
                    array(
                        'name' => 'action',
                        'type' => 'raw',
                        'value' => 'CHtml::encode(AuditUtility::translate($data->action))',
                        'filter' => ''
                    ),
                    array(
                        'name' => 'created_on',
                        'type' => 'raw',
                        'value' => '$data->created_on',
                    ),
                ),
            ));
            ?>

        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
