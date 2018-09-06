<?php

$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery', CClientScript::POS_END);

?>

<style type="text/css">

</style>

<div>
    <div class="form">
        <div style="width:600px" class="fab-left fab-voting-left">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'game-choice-form',
                'enableAjaxValidation' => true,
            ));

            echo '<div>'.$game->question.'</div>';
            
            $answerArray = Array();
            $i = 0;
            foreach ($game->gameChoiceAnswers as $answer) {
                if($i < sizeof($game->gameChoiceAnswers)-1) {
                    $answerArray[$answer->id] = $answer->answer;
                }
                $i++;
            }
            
            echo $form->radioButtonList($response, 'game_choice_answer_id', $answerArray);
            
            echo $form->error($response, 'game_choice_answer_id');

            echo $form->hiddenField($response, 'game_choice_id', array('value' => $game->id));
            echo $form->hiddenField($response, 'source', array('value' => 'web'));

            ?>
            <div style="clear:both">
                <?php echo CHtml::submitButton('Submit'); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
