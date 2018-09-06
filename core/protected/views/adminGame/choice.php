<?php
// page specific css
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/chosen.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery.tagsinput.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/bootstrap-toggle-buttons.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/DT_bootstrap.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-1.10.0.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminVoting/index.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/spectrum.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/jquery-ui-timepicker-addon.css');
$cs->registerCssFile('/core/webassets/css/jquery.dataTables_themeroller.css');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminGame/index.css');

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
//$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminVoting/index.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/spectrum.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/adminGame/choice.js', CClientScript::POS_END);
//$cs->registerCssFile('/core/webassets/css/adminQuestion/index.css');

$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
?>


<script>
$(document).ready(function() {
    $("#datetimepickerClose").datetimepicker({
        maxDate: "0",
        onSelect: function () {
            $(this).attr('value', this.value);
        }
    });
    
    $("#datetimepickerOpen").datetimepicker({
        maxDate: "0",
        onSelect: function () {
            $(this).attr('value', this.value);
        }
    });
});

</script>

<!-- BEGIN PAGE -->
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
    
    if(!$g) {
        $showHideEditor = "";
    } else {
        $showHideEditor = "display: none;";
    }
    ?>
    <!-- flash messages -->

    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top" style="background:#852b99;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="marginRight10 floatLeft" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/voting-image.png"/>Game Admin: <?php echo ucfirst($type); echo " (".CHtml::link('Weekly/Monthly Winners', array('admin/periodwinner'), array('title' => 'Weekly/Monthly Winners')).")";?></h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- END PAGE HEADER-->
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div class="pollHolder" style="clear:both;padding-top:20px;">
                        <div style="margin: 0px 0px 10px 0px; font-weight: bold;">
                            View Games: 
                            <a style="color:#000000" href="/admin/gamechoice/<?php echo $type; ?>?g=open">Open</a> |
                            <a style="color:#000000" href="/admin/gamechoice/<?php echo $type; ?>?g=ended">Ended</a>
                        </div>
                    </div>
                    <div class="pollHolder" style="clear:both;padding-top:10px;">
                        <div style="margin: 0px 0px 10px 0px; font-weight: bold;">
                            Create New Game (Select Number of Answers): 
                            <a style="color:#000000" href="/admin/gamechoice/<?php echo $type; ?>/2">2</a> |
                            <a style="color:#000000" href="/admin/gamechoice/<?php echo $type; ?>/3">3</a> |
                            <a style="color:#000000" href="/admin/gamechoice/<?php echo $type; ?>/4">4</a>
                        </div>
                        
                        <div id="createEditGame" style="<?php echo $showHideEditor; ?>">
                        <h2>Create/Edit Game</h2>
                            
                        <?php
                        
                        $game = $models['game'];
                        $gameChoiceAnswers = $models['gameChoiceAnswers'];

                        if(isset(Yii::app()->params['currencySymbol'])) {
                            $currencySymbol = Yii::app()->params['currencySymbol'];
                        }
                        else {
                            $currencySymbol = "$";
                        }
                        
                        $game->open_date = date("m/d/Y H:i:s", strtotime($game->open_date));
                        $game->close_date = date("m/d/Y H:i:s", strtotime($game->close_date));
                        ?>

                        <div class="form">
                            <div style="width:600px" class="fab-left fab-voting-left">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'admin-game-choice-form',
                                    'enableAjaxValidation' => true,
                                ));
                                ?>

                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'question'); ?>
                                    <?php echo $form->textField($game, 'question', array('maxlength' => '140', 'style' => 'width: 500px', 'class' => 'counter')); ?>
                                    <?php echo $form->error($game, 'question'); ?>
                                    <?php echo $form->hiddenField($game, 'type', array('value' => $type)); ?>
                                </div>
                                
                                <?php if($type == "sub") {
                                    
                                ?>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'g_parant_id'); ?>
                                    <?php echo $form->dropDownList($game, 'g_parant_id', $mainGames, array('style' => 'width: 500px', 'class' => 'fab-select-accept')); ?>
                                    <?php echo $form->error($game, 'g_parant_id'); ?>
                                </div>
                                
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php //echo GameUtility::getRandomSubGames(52, 7);?>
                                    <?php //echo $form->labelEx($game, 'g_parant_id'); ?>
                                    <?php //echo $form->textField($game, 'g_parant_id', array('maxlength' => '4', 'style' => 'width: 50px', 'class' => 'counter')); ?>
                                    <?php //echo $form->error($game, 'g_parant_id'); ?>
                                </div>
                                <?php
                                }
                                ?>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'description'); ?>
                                    <?php echo $form->textArea($game, 'description', array('maxlength' => '512', 'style' => 'width: 500px', 'class' => 'counter')); ?>
                                    <?php echo $form->error($game, 'description'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'price'); ?>
                                    <span><?php echo $currencySymbol; ?></span>
                                    <?php if (Yii::app()->name == 'Albousalah Games'): ?>
                                    <?php echo $form->textField($game, 'price', array('maxlength' => '6', 'style' => 'width: 50px', 'class' => 'counter', 'value' => 5, 'readonly' => true)); ?>
                                    <?php else: ?>
                                    <?php echo $form->textField($game, 'price', array('maxlength' => '6', 'style' => 'width: 50px', 'class' => 'counter', 'readonly' => false)); ?>
                                    <?php endif; ?>
                                    <?php echo $form->error($game, 'price'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'prize'); ?>
                                    <?php echo $form->textField($game, 'prize', array('maxlength' => '50', 'style' => 'width: 500px', 'class' => 'counter')); ?>
                                    <?php echo $form->error($game, 'prize'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'open_date'); ?>
                                    <?php echo $form->textField($game, 'open_date', array('id' => 'datetimepickerOpen', 'style' => 'width: 140px;', 'class' => ' datetimepicker')); ?>
                                    <?php echo $form->error($game, 'open_date'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'close_date'); ?>
                                    <?php echo $form->textField($game, 'close_date', array('id' => 'datetimepickerClose', 'style' => 'width: 140px;', 'class' => ' datetimepicker')); ?>
                                    <?php echo $form->error($game, 'close_date'); ?>
                                </div>
                                


                                <?php

                                foreach($gameChoiceAnswers as $i => $answer) {

                                    if($i == 0) {
                                        $label = 'A';
                                    } else if($i == 1) {
                                        $label = 'B';
                                    } else if($i == 2) {
                                        $label = 'C';
                                    } else if($i == 3) {
                                        $label = 'D';
                                    } else {
                                        $label = '';
                                    }

                                    if($i < $anum)
                                    {
                                        echo '<div id="gameChoiceAnswers'.$i.'" style="clear:both; padding-top: 20px">';
                                        echo '<div style="margin: 0px 0px 10px 0px;">';
                                        echo $form->labelEx($answer, "[$i]label");
                                        echo $form->textField($answer, "[$i]label", array('id' => 'fab-point' . $i, 'style' => 'width: 30px', 'maxlength' => 19, 'value' => $label, 'readonly' => true, 'class' => 'fab-m-wrap xsmall'));
                                        echo $form->error($answer, "[$i]label");
                                        echo '</div>';
                                        echo '<div style="margin: 0px 0px 10px 0px;">';
                                        echo $form->labelEx($answer, "[$i]answer");
                                        echo $form->textField($answer, "[$i]answer", array('maxlength' => '100', 'class' => 'counter'));
                                        echo $form->error($answer, "[$i]answer");
                                        echo '</div>';
                                        echo '<div style="margin: 0px 0px 10px 0px;">';
                                        echo $form->labelEx($answer, "[$i]point_value");
                                        echo $form->textField($answer, "[$i]point_value", array('id' => 'fab-point' . $i, 'style' => 'width: 30px', 'maxlength' => 19, 'value' => '10', 'readonly' => true, 'class' => 'fab-m-wrap xsmall'));
                                        echo $form->error($answer, "[$i]point_value");
                                        echo '</div>';
                                        echo '<div style="margin: 0px 0px 10px 0px;">';
                                        echo $form->labelEx($answer,"[$i]is_correct");
                                        echo $form->checkBox($answer,"[$i]is_correct");
                                        echo $form->error($answer,"[$i]is_correct");
                                        echo '</div>';
                                        echo '<div style="margin: 0px 0px 10px 0px;">';
                                        echo $form->labelEx($answer, "[$i]img_url");
                                        echo $form->textField($answer, "[$i]img_url", array('maxlength' => '100', 'class' => 'counter'));
                                        echo $form->error($answer, "[$i]img_url");
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }

                                ?>
                                <div style="clear:both">
                                    <?php echo CHtml::submitButton('Submit'); ?>
                                    <button type="button" onclick="window.location.href = '/admin/gamechoice/<?php echo $type; ?>';">Reset</button>
                                </div>
                            </div>

                            <?php $this->endWidget(); ?>
                        </div>
                        </div>

                    </div>
                    <?php 
                    if(!empty($games)) {
                    ?>
                    <div style="clear:both;padding-top:40px">
                        <h2><?php echo ucfirst($g); ?> Choice Games</h2>
                        <table id="gameTable">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>Start/End</th>
                                    <th>Delete</th>
                                    <th>Question</th>
                                    <th>Description</th>
                                    <th style="width: 40px;">Price</th>
                                    <th>Prize</th>
                                    <th>Feed</th>
                                    <th>Answers</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                            foreach($games as $game)
                            {
                                $activeDisabled = '';
                                $anum = 0;
                                foreach($game->gameChoiceAnswers as $answer)
                                {
                                    if(in_array($answer->label, array('A','B','C','D'))) {
                                        $anum++;
                                    }
                                }

                                if($game->is_active == 1) {
                                    $active = 'active';
                                    $activeAction = 'Stop';
                                    $activeNewState = 0;
                                }
                                else {
                                    if($game->num_plays_paid > 0) {
                                        $activeDisabled = 'disabled';
                                        $activeAction = 'Ended';
                                    }
                                    else {
                                        $activeAction = 'Start';
                                    }
                                    $active = 'inactive';
                                    $activeNewState = 1;
                                }

                                if($game->is_deleted == 1) {
                                    $deleted = 'deleted';
                                    $deletedAction = 'Restore';
                                    $deletedNewState = 0;
                                }
                                else {
                                    $deleted = '';
                                    $deletedAction = 'Delete';
                                    $deletedNewState = 1;
                                }

                                if($game->start_date != NULL) {
                                    $start_date = date("m/d/Y H:i:s", strtotime($game->start_date))." <div>".date_default_timezone_get()."</div>";
                                }
                                else {
                                    $start_date = 'N/A';
                                }
                                
                                if($game->open_date != NULL) {
                                    $open_date = date("m/d/Y H:i:s", strtotime($game->open_date))." <div>".date_default_timezone_get()."</div>";
                                }
                                else {
                                    $open_date = 'N/A';
                                }
                                
                                if($game->close_date != NULL) {
                                    $close_date = date("m/d/Y H:i:s", strtotime($game->close_date))." <div>".date_default_timezone_get()."</div>";
                                }
                                else {
                                    $close_date = 'N/A';
                                }

                                if($game->end_date != NULL) {
                                    $end_date = date("m/d/Y H:i:s", strtotime($game->end_date))." <div>".date_default_timezone_get()."</div>";
                                }
                                else {
                                    $end_date = 'N/A';
                                }

                                echo "<tr>";
                                echo "<td style='text-align:center; width:50px;' class='".$active."'>";
                                echo "  <button type='button' $activeDisabled class='setGameState' rel='".$game->id."' rev='".$activeNewState."'>".$activeAction."</button>";
                                echo "</td>";

                                echo "<td>";
                                echo '<div style="margin: 0px 0px 30px 0px; font-size:10px; line-height: 120%;"><div style="font-weight: bold;">Start</div>'.$start_date.'</div>';
                                echo '<div style="margin: 0px 0px 30px 0px; font-size:10px; line-height: 120%;"><div style="font-weight: bold;">Open Game Play</div>'.$open_date.'</div>';
                                echo '<div style="margin: 0px 0px 30px 0px; font-size:10px; line-height: 120%;"><div style="font-weight: bold;">Close Game Play</div>'.$close_date.'</div>';
                                echo '<div style="margin: 0px 0px 30px 0px; font-size:10px; line-height: 120%;"><div style="font-weight: bold;">End</div>'.$end_date.'</div>';
                                echo "</td>";

                                echo "<td style='text-align:center; width:50px' class='".$deleted."'>";
                                echo "  <button type='button' class='setGameDeleted' rel='".$game->id."' rev='".$deletedNewState."'>".$deletedAction."</button>";
                                echo "</td>";
                                
                                echo "<td><a href='/admin/gamechoice/{$type}/{$anum}/{$game->id}' rel='question' rev=''>".$game->question."</a></td>";

                                echo "<td>".$game->description."</td>";

                                echo "<td>".$currencySymbol." ".$game->price."</td>";

                                echo "<td>".$game->prize."</td>";

                                echo "<td>";
                                echo "<a href='/game/".$type."/".$game->id."' rel='".$game->id."' target='_blank' rev=''>Game</a>";
                                echo " | ";
                                echo "<a href='/XML/gamechoice/".$game->id."' rel='".$game->id."' target='_blank' rev=''>".$game->id.".XML</a>";
                                echo "</td>";

                                echo "<td style='background-color:transparent !important; border:0px; padding:0px !important;'>";
                                echo "  <table style='width: 100%'>";
                                echo "      <tr style='background: #FFF'>";
                                echo "          <th>Label</th>";
                                echo "          <th>Answer</th>";
                                echo "          <th>Correct</th>";
                                echo "          <th>Points</th>";
                                echo "          <th>Res. Paid</th>";
                                echo "          <th>Res. Free</th>";
                                echo "      </tr>";
                                echo "<tbody>";

                                $i = 0;

                                foreach ($game->gameChoiceAnswers as $answer)
                                {
                                    if($i != sizeof($game->gameChoiceAnswers)-1) {
                                        if($answer->is_correct) {
                                            $style = 'class="correct"';
                                        }
                                        else {
                                            $style = '';
                                        }
                                        echo "<tr ".$style.">";
                                        echo "<td>".$answer->label."</td>";
                                        echo "<td>".$answer->answer."</td>";
                                        echo "<td>".$answer->is_correct."</td>";
                                        echo "<td>".$answer->point_value."</td>";
                                        echo "<td>".$answer->responses_paid."</td>";
                                        echo "<td>".$answer->responses_free."</td>";
                                        echo "</tr>";
                                    }

                                    $i++;
                                }

                                echo "</tbody>";
                                echo "  </table>";

                                echo "  <table style='width: 100%'>";
                                echo "      <tr style='background: #FFF'>";
                                echo "          <th>Paid Plays</th>";
                                echo "          <th>Non-Paid Plays</th>";
                                echo "          <th>Paid Unique Users</th>";
                                echo "          <th>Non-Paid Unique Users</th>";
                                echo "      </tr>";
                                echo "<tbody>";
                                echo "<tr>";


                                echo "<td>".$game->num_plays_paid."</td>";
                                echo "<td>".$game->num_plays_free."</td>";
                                echo "<td>".$game->num_users_paid."</td>";
                                echo "<td>".$game->num_users_free."</td>";
                                echo "</tr>";
                                echo "</tbody>";
                                echo "  </table>";

                                echo "  <table style='width: 100%'>";
                                echo "      <tr style='background: #FFF'>";
                                echo "          <th>Winner</th>";
                                echo "          <th>Total Revenue</th>";
                                echo "          <th>Export</th>";
                                echo "      </tr>";
                                echo "<tbody>";
                                echo "<tr>";
                                if(isset($game->winner_id))
                                {
                                    $user = eUser::model()->findByPk($game->winner_id);
                                    $username = $username = CHtml::link($user->username, array('admin/user/'.$game->winner_id), array('target'=>'_blank'), array('title' => $user->username));
                                }
                                else {
                                    $username = 'No Winner';
                                }

                                echo "<td>";
                                echo $username;

                                if(isset($game->winner_id))
                                {
                                    echo " (<a target=\"_blank\" href=\"/admin/sendSMS/".$game->winner_id."\">SMS</a>";
                                    echo ' / <a target="_blank" href="'.$this->createUrl('adminGame/printInvoice', array('type' => 'game', 'id' => $game->id)).'"><i class="icon-print"></i></a>)';
                                }
                                echo "</td>";
                                echo "<td>".$currencySymbol." ".$game->spent."</td>";

                                echo "<td>";
                                echo "<a style=\"font-size:7pt;\" href='/adminReport/GamePlayesReport?game_id=".$game->id."' target='_blank'>csv</a>";
                                if(Yii::app()->user->isSuperAdmin()) {
                                    echo ", <a style=\"font-size:7pt;\" href='/admin/gamereport/".$game->id."' target='_blank'>html</a>";
                                    echo ", <a style=\"font-size:7pt;\" href='/adminReport/GamePlayReportByHour?game_id=".$game->id."' target='_blank'>csv</a>";
                                }
                                echo "</td>";

                                echo "</tr>";
                                echo "</tbody>";
                                echo "  </table>";

                                echo "</td>";
                                echo "</tr>";
                            }
                            

                            ?>
                            </tbody>
                        </table>
                        
                        <div class="clearFix"></div>
                    </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->

