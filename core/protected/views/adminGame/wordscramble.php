
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/core/webassets/js/adminGame/index.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/adminQuestion/index.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/adminQuestion/index.css');
$cs->registerCssFile('/core/webassets/css/adminGame/index.css');
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);

$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$this->renderPartial('/admin/_csrfToken');

?>

<style type="text/css">

</style>

<div class="fab-page-content">
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top">
        <h2 class="fab-title">
            <img class="floatLeft" style="margin-right: 10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/dashboard-icon.png"/>
            <div class="floatLeft">Game Editor </div>


        </h2>

    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- BEGIN PAGE HEADER-->

        <!-- END PAGE HEADER-->
        <div id="fab-dashboard">
            <div style="padding:0px 20px 0px 20px;">
                <div>
                    <h2>Create New Game:</h2>
                    <?php
                    /* @var $this AdminController */
                    /* @var $game Game */
                    /* @var $form CActiveForm */
                    ?>

                    <div class="form">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'admin-gameEditor-form',
                            'enableAjaxValidation' => true,
                            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                        ));
                        ?>
                        <?php echo $form->errorSummary($game); ?>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'title', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'title', array('style' => 'width: 300px', 'maxlength' => 100)); ?>
                            <?php echo $form->error($game, 'title'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'word', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'word', array('style' => 'width: 300px', 'maxlength' => 100)); ?>
                            <?php echo $form->error($game, 'word'); ?>
                        </div>
                        
                        <div class="clearfix">
                            <?php echo CHtml::submitButton('Submit'); ?>
                        </div>

                        <?php $this->endWidget(); ?>

                    </div><!-- form -->

                </div>
                

                <div style="margin-top:40px;">
                    <h2>Edit Question:</h2>
                    <div style="margin-bottom:20px">
                        Click on the column title to sort by that column.<br>
                        Click on any question details to edit them.
                    </div>
                    <table id="questionTable">
                        <thead>
                            <tr>
                                <th>State</th>
                                <th>Delete</th>
                                <th>Game Title</th>
                                <th>Feed</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach($games as $k => $v)
                            {
                                echo("<tr>");
                                $active = ($v->is_active == 1) ? 'active' : 'inactive';
                                $deleted = ($v->is_deleted == 0) ? '' : 'deleted';

                                echo "<td style='text-align:center;width:50px' class='%s'>";
                                echo "  <button type='button' class='setQuestionState' rel='".$v->id."' rev='".($v->is_active == 0) ? '1' : '0'."'>".($active == 'active') ? 'Stop' : 'Start'."</button>";
                                echo "</td>";

                                echo "<td style='text-align:center;width:50px' class='%s'>";
                                echo "  <button type='button' class='setQuestionDeleted' rel='".$v->id."' rev='".($v->is_deleted == 0) ? '1' : '0'."'>".($v->is_deleted == 0) ? 'Delete' : 'Restore'."</button>";
                                echo "</td>";

                                echo "<td><a href='/admin/gamewordscramble/".$v->id."' rel='title' rev='%s'>".$v->title."</a></td>";
                                echo "<td><a href='/game/wordscramble/".$v->id."' rel='".$v->id."' target='_blank' rev='%s'>/game/wordscramble/".$v->id."</a></td>";

                                echo("</tr>");
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
<?php $this->renderPartial('/adminQuestion/_linksOverlay'); ?>