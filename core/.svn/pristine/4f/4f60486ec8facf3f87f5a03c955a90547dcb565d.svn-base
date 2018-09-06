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

// page specific js
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/adminVoting/index.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/spectrum.js', CClientScript::POS_END);

$cs->registerScriptFile('/core/webassets/js/adminGame/choice.js', CClientScript::POS_END);
//$cs->registerCssFile('/core/webassets/css/adminQuestion/index.css');

$cs->registerScriptFile('/core/webassets/js/jquery.dataTables.min.js', CClientScript::POS_END);
$this->renderPartial('/admin/_csrfToken');
?>


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
    ?>
    <!-- flash messages -->

    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
    <div id="fab-top" style="background:#852b99;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="marginRight10 floatLeft" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/voting-image.png"/>Game Admin: <?php echo ucfirst($type); ?></h2>
    </div>
    <!-- END PAGE TITLE & BREADCRUMB-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="fab-container-fluid">
        <!-- END PAGE HEADER-->
        <div class="fab-row-fluid">
            <div id="fab-voting">
                <div class="fab-tab-content">
                    <div class="pollHolder" style="clear:both;padding-top:20px;">
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
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'description'); ?>
                                    <?php echo $form->textArea($game, 'description', array('maxlength' => '512', 'style' => 'width: 500px', 'class' => 'counter')); ?>
                                    <?php echo $form->error($game, 'description'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'price'); ?>
                                    <?php echo $form->textField($game, 'price', array('maxlength' => '6', 'style' => 'width: 50px', 'class' => 'counter', 'value' => 5, 'disabled'=>'true')); ?>
                                    <span><?php echo $currencySymbol; ?></span>
                                    <?php echo $form->error($game, 'price'); ?>
                                </div>
                                <div style="margin: 0px 0px 10px 0px;">
                                    <?php echo $form->labelEx($game, 'prize'); ?>
                                    <?php echo $form->textField($game, 'prize', array('maxlength' => '50', 'style' => 'width: 500px', 'class' => 'counter')); ?>
                                    <?php echo $form->error($game, 'prize'); ?>
                                </div>


                                <?php
                                
                                foreach($gameChoiceAnswers as $i => $answer) { 
                                    echo '<div id="gameChoiceAnswers'.$i.'" style="clear:both; padding-top: 20px">';
                                    echo '<div style="margin: 0px 0px 10px 0px;">';
                                    echo $form->labelEx($answer, "[$i]answer");
                                    echo $form->textField($answer, "[$i]answer", array('maxlength' => '100', 'class' => 'counter'));
                                    echo $form->error($answer, "[$i]answer");
                                    echo '</div>';
                                    echo '<div style="margin: 0px 0px 10px 0px;">';
                                    echo $form->labelEx($answer, "[$i]point_value");
                                    echo $form->textField($answer, "[$i]point_value", array('id' => 'fab-point' . $i, 'style' => 'width: 30px', 'maxlength' => 19, 'value' => '10', 'class' => 'fab-m-wrap xsmall'));
                                    echo $form->error($answer, "[$i]point_value");
                                    echo '</div>';
                                    echo '<div style="margin: 0px 0px 10px 0px;">';
                                    echo $form->labelEx($answer,"[$i]is_correct");
                                    echo $form->checkBox($answer,"[$i]is_correct");
                                    echo $form->error($answer,"[$i]is_correct");
                                    echo '</div>';
                                    echo '</div>';
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
                    <div style="clear:both;padding-top:40px">
                        <h2>Previous/Current Choice Games</h2>
                        <table id="votingTable">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>Delete</th>
                                    <th>Question</th>
                                    <th>Price</th>
                                    <th>Feed</th>
                                    <th>Answers</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php

                            foreach($games as $game)
                            {
                                $activeDisabled = '';
                                        
                                if($game->is_active == 1) {
                                    $active = 'active';
                                    $activeAction = 'Stop';
                                    $activeNewState = 0;
                                }
                                else {
                                    if($game->num_plays > 0) {
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
                                
                                echo "<tr>";
                                echo "<td style='text-align:center; width:50px' class='".$active."'>";
                                echo "  <button type='button' $activeDisabled class='setGameState' rel='".$game->id."' rev='".$activeNewState."'>".$activeAction."</button>";
                                echo "</td>";
                                
                                echo "<td style='text-align:center; width:50px' class='".$deleted."'>";
                                echo "  <button type='button' class='setGameDeleted' rel='".$game->id."' rev='".$deletedNewState."'>".$deletedAction."</button>";
                                echo "</td>";
                                
                                echo "<td><a href='/admin/gamechoice/".$type."/".$game->id."' rel='question' rev=''>".$game->question."</a></td>";
                                
                                echo "<td>".$currencySymbol." ".$game->price."</td>";
                                
                                echo "<td>";
                                echo "<a href='/game/".$type."/".$game->id."' rel='".$game->id."' target='_blank' rev=''>Game</a>";
                                echo " | ";
                                echo "<a href='/XML/gamechoice/".$game->id."' rel='".$game->id."' target='_blank' rev=''>".$game->id.".XML</a>";
                                echo "</td>";
                                    
                                echo "<td style='background-color:transparent !important; border:0px; padding:0px !important;'>";
                                echo "  <table style='width: 100%'>";
                                echo "      <tr style='background: #FFF'>";
                                echo "          <th>Answer</th>";
                                echo "          <th>Correct</th>";
                                echo "          <th>Points</th>";
                                echo "          <th>Responses</th>";
                                echo "      </tr>";
                                echo "<tbody>";
                                
                                foreach ($game->gameChoiceAnswers as $answer)
                                {
                                    if($answer->is_correct) {
                                        $style = 'style="background-color: green;"';
                                    }
                                    else {
                                        $style = '';
                                    }
                                    echo "<tr ".$style.">";
                                    echo "<td>".$answer->answer."</td>";
                                    echo "<td>".$answer->is_correct."</td>";
                                    echo "<td>".$answer->point_value."</td>";
                                    echo "<td>".$answer->responses."</td>";
                                    echo "</tr>";
                                }
                                
                                echo "</tbody>";
                                echo "  </table>";
                                
                                echo "  <table style='width: 100%'>";
                                echo "      <tr style='background: #FFF'>";
                                echo "          <th>Winner</th>";
                                echo "          <th>Total Plays</th>";
                                echo "          <th>Unique Users</th>";
                                echo "          <th>Total Revenue</th>";
                                echo "      </tr>";
                                echo "<tbody>";
                                echo "<tr>";
                                if(isset($game->winner_id))
                                {
                                    $user = eUser::model()->findByPk($game->winner_id);
                                    $username = $user->username;
                                }
                                else {
                                    $username = 'No Winner';
                                }
                                echo "<td>".$username." <a target=\"_blank\" href=\"/admin/sendSMS/".$game->winner_id."\">SMS</a></td>";
                                echo "<td><a href='/adminReport/GamePlayesReport?game_id=".$game->id."' target='_blank'>".$game->num_plays."</a></td>";
                                echo "<td>".$game->num_users."</td>";
                                echo "<td>".$currencySymbol." ".$game->spent."</td>";
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
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<!-- END PAGE -->

