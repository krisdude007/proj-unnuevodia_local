<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/core/webassets/js/adminLanguage/index.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/adminLanguage/index.css');
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$this->renderPartial('/admin/_csrfToken');
?>

<div class="fab-page-content">
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 class="fab-title"><img class="floatLeft" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png" style="margin-right: 10px;"/>Language Filter</h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- BEGIN PAGE HEADER-->

        <!-- END PAGE HEADER-->
        <div id="fab-dashboard">
            <div style="padding:0px 20px 0px 20px;">
                <div>
                    <h2>Create New Language Filter:</h2>
                    <div>
                        Supports regex patterns for matching.
                        Anything that matches this pattern will be flagged.
                    </div>
                    <?php
                    /* @var $this AdminController */
                    /* @var $model Language */
                    /* @var $form CActiveForm */
                    ?>

                    <div class="form">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'admin-language-form',
                            'enableAjaxValidation' => true,
                                ));
                        ?>
                        <?php echo $form->errorSummary($model); ?>
                        <div class="clearfix">
                            <?php echo $form->labelEx($model, 'pattern'); ?>
                            <?php echo $form->textField($model, 'pattern'); ?>
                            <?php echo $form->error($model, 'pattern'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo CHtml::submitButton('Submit'); ?>
                        </div>

                        <?php $this->endWidget(); ?>

                    </div><!-- form -->

                </div>
                <div style="margin-top:40px;">
                    <h2>Edit Language Filters:</h2>
                    <div style="margin-bottom:20px">
                        Click on the column title to sort by that column.<br>
                        Click on any details to edit them.
                    </div>
                    <table id="languageTable">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>Filter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowFormat = "
                                <tr class='%s'>
                                    <td style='text-align:center;width:100px'>
                                        <button type='button' class='setFilterState' rel='%s' rev='%s'>%s</button>
                                    </td>
                                    <td><a href='#' class='edit' rel='pattern' rev='%s'>%s</a></td>
                                </tr>
                            ";
                            $i = 0;
                            foreach ($filters as $k => $v) {
                                $active = ($v->active == 1) ? 'active' : '';
                                echo sprintf($rowFormat, $active, $v->id, ($v->active == 1) ? 0 : 1, ($v->active == 1) ? 'Deactivate' : 'Activate', $v->id, (!empty($v->pattern)) ? $v->pattern : '*'
                                );
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>