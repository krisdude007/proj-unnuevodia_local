
<?php
$cs = Yii::app()->clientScript;
$cs->registerScript('grid_id', "var grid_id = $game->id", CClientScript::POS_END);
$cs->registerScript('total_squares', "var total_squares = $game->total_squares", CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/adminGame/index.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/adminQuestion/index.js', CClientScript::POS_END);
$cs->registerCssFile('/core/webassets/css/adminQuestion/index.css');
$cs->registerCssFile('/core/webassets/css/adminGame/index.css');
$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);

$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$this->renderPartial('/admin/_csrfToken');

?>

<style type="text/css">
    
.buttonMain {
    position: relative;
    width: <?php echo $game->button_main_w; ?>px; 
    height: <?php echo $game->button_main_h; ?>px; 
    margin: 20px auto;
    background-size: <?php echo $game->button_main_w; ?>px <?php echo $game->button_main_h; ?>px; 
    background-image: url('<?php echo $game->grid_background; ?>');
    color: black;
    font-weight: bold;
}

.buttonSection {
    float: left; 
    width: <?php echo $game->button_section_w; ?>px; 
    height: <?php echo $game->button_section_h; ?>px;
    text-align: center;
    border: 1px solid gray;
    cursor: pointer;
}

.buttonSection p {
    margin: <?php echo $game->button_section_w/2-10; ?>px 0px 0px 0px;
}

.button {
    text-align: center;
    font-weight: bold;
    cursor: pointer; 
}

.buttonOpaque {
    background: <?php echo $game->square_color; ?>;
    opacity: .8;
    cursor:auto;
}
    
</style>

<div class="fab-page-content">
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
                        ));
                        ?>
                        <?php echo $form->errorSummary($game); ?>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'title', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'title', array('style' => 'width: 300px', 'maxlength' => 100)); ?>
                            <?php echo $form->error($game, 'title'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'grid_w_squares', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'grid_w_squares', array('style' => 'width: 70px', 'maxlength' => 3)); ?>
                            <?php echo $form->error($game, 'grid_w_squares'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'grid_h_squares', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'grid_h_squares', array('style' => 'width: 70px', 'maxlength' => 3)); ?>
                            <?php echo $form->error($game, 'grid_h_squares'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'square_color', array('style' => 'width: 150px')); ?>
                            <?php echo $form->textField($game, 'square_color', array('id' => 'colorpickerField', 'style' => 'width: 70px', 'maxlength' => 7, 'value' => '#CCCCCC')); ?>
                            <?php echo $form->error($game, 'square_color'); ?>
                        </div>
                        <div class="clearfix">
                            <?php echo $form->labelEx($game, 'grid_background');//CHtml::label('Choose an image to upload', ''); ?>
                            <?php echo $form->fileField($game, 'grid_background'); ?>
                            <div class="hintTxt">Supported File type: <?php echo Yii::app()->params['gameReveal']['imageAllowedType'] ?> Note: <?php echo Yii::app()->params['gameReveal']['imageNote'] ?>.</div>

                        </div>
                        <div class="clearfix">
                            <?php echo $form->hiddenField($game, 'grid_w', array('value' => 800)); ?>
                            <?php echo $form->hiddenField($game, 'grid_h', array('value' => 600)); ?>
                            <?php echo $form->hiddenField($game, 'control_scale', array('value' => 2)); ?>
                            <?php echo CHtml::submitButton('Submit'); ?>
                        </div>

                        <?php $this->endWidget(); ?>

                    </div><!-- form -->

                </div>
                <div class="buttonMain">
                    <?php
                    for($i=1; $i<=$game->total_squares; $i++)
                    {
                        echo '<div id="gridButton'.$i.'" class="buttonSection"><p>'.$i.'</p></div>';
                    }
                    ?>
                </div>
                <div id="showAll" class="button">Show All</div>
                <div id="hideAll" class="button">Hide All</div>
                
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
                                $active = ($v->is_active == 1) ? 'active' : 'inactive';
                                $deleted = ($v->is_deleted == 0) ? '' : 'deleted';
                                
                                echo "<td style='text-align:center;width:50px' class='%s'>";
                                echo "  <button type='button' class='setQuestionState' rel='".$v->id."' rev='".($v->is_active == 0) ? '1' : '0'."'>".($active == 'active') ? 'Stop' : 'Start'."</button>";
                                echo "</td>";
                                
                                echo "<td style='text-align:center;width:50px' class='%s'>";
                                echo "  <button type='button' class='setQuestionDeleted' rel='".$v->id."' rev='".($v->is_deleted == 0) ? '1' : '0'."'>".($v->is_deleted == 0) ? 'Delete' : 'Restore'."</button>";
                                echo "</td>";
                                
                                echo "<td><a href='/admin/gamereveal/".$v->id."' rel='title' rev='%s'>".$v->title."</a></td>";
                                echo "<td><a href='/game/reveal/".$v->id."' rel='".$v->id."' target='_blank' rev='%s'>/game/reveal/".$v->id."</a></td>";
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