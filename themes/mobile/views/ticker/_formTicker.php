<?php
/* @var $this TickerController */
/* @var $model Ticker */
/* @var $form CActiveForm */
?>
<div class="col-sm-10 col-sm-offset-1 col-xs-12">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ticker-form',
    ));
    ?>
    <div class='col-sm-8 col-xs-8' <?php echo (!Yii::app()->params['useMobileTheme']) ? 'style="padding-top: 10px;"' : 'style="padding-top: 10px; padding-right: 0px;"';?>>
        <div class="input-group">
            <?php
            echo $form->textField($tickerModel, 'ticker', array(
                'class' => 'form-control counter',
                'style' => 'height: 32px; border-right: none;',
                'data-toggle' => 'popover',
                'data-container' => 'body',
                'data-placement' => 'bottom',
                'onfocus' => '$(this).popover();',
                'maxlength' => 140,
            ));
            ?>
        </div>
        <?php echo $form->error($tickerModel, 'ticker', array('style' => 'margin-top:-2px;')); ?>
    </div>
    <div class='col-sm-2 col-xs-4' style="padding-top: 10px">
        <?php if (!Yii::app()->params['useMobileTheme'] == true ) : ?>
        <?php
        echo CHtml::submitButton('Post', array('class' => 'btn btn-inverse', 'style' => 'min-width: 113px !important;height:32px; text-transform: capitalize;',
            'onclick' => "if($('input[type=text]').val().length > 140) { alert('Maximum 140 characters'); return false;} else {return true;}"
        ));
        ?>
        <?php else: ?>
        <?php
        echo CHtml::submitButton('Post', array('class' => 'btn btn-inverse', 'style' => 'min-width: 75px !important;height:32px; text-transform: capitalize;',
            'onclick' => "if($('input[type=text]').val().length > 140) { alert('Maximum 140 characters'); return false;} else {return true;}"
        ));
        ?>
        <?php endif; ?>
    </div>
    <div class="col-sm-8 col-sm-offset-2 col-xs-12" style="padding-top: 10px;padding-left:0px; padding-right: 0px;">
        <div class="pull-right" style="color: #696969; font-size: 15px;">
            Post to: &nbsp;&nbsp;
            <span style="color: #696969;">
                <?php echo $form->checkbox($tickerModel, 'to_facebook'); ?>
                Twitter
            </span>
            <span style="color: #696969;">
                <?php echo $form->checkbox($tickerModel, 'to_twitter'); ?>
                Facebook
            </span>
            <div>
                <?php echo $form->error($tickerModel, 'to_facebook'); ?>
                <?php echo $form->error($tickerModel, 'to_twitter'); ?>
            </div>
        </div>
    </div>
    <?php echo $form->hiddenField($tickerModel, 'source', Array('value' => 'web')); ?>
    <?php $this->endWidget(); ?>
</div><!-- form -->