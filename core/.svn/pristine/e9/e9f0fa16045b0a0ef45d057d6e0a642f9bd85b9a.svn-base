<div id="pageContainer" class="container">
    <div class="subContainer">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <h1><?php echo Yii::t('youtoo','Thanks for Playing!')?></h1>
                <p class="lead">
                    <?php if($isCorrect): ?>
                    <?php echo Yii::t('youtoo',"You were charged AEDS. Congratulations, you answered correctly, and you've earned ".$credit." credits. Visti the online store to redeem your credits.");?>
                    <?php elseif($credit > 0): ?>
                    <?php echo Yii::t('youtoo',"You were charged AEDS. Unfortunatedly, you answered incorrectly, but you've still earned ".$credit." credits. Visti the online store to redeem your credits.");?>
                    <?php else: ?>
                    <?php echo Yii::t('youtoo',"You were charged AEDS. Unfortunatedly, you answered incorrectly.");?>
                    <?php endif; ?>
                </p>
                <p>
                    <a href="<?php echo $this->createUrl('/site/redeem', array()); ?>" class="btn btn-default btn-lg active" role="button"><?php echo Yii::t('youtoo','Redeem Credits')?></a>
                </p>
                <p>
                    <a href="<?php echo $this->createUrl('/actel/index', array()); ?>" class="btn btn-default btn-lg active" role="button"><?php echo Yii::t('youtoo','Play Again')?></a>
                </p>
                <br/>
                <p>
                    <table style="width: 100%;border: 1px solid #cdcdcd; text-align: left;">
                        <tr>
                        <td style='width:50%;background-color: #dedede;padding: 12px;'>
                            <h4>Thank you.</h4>
                            <h5>You've made a purchase from <?php echo Yii::app()->name ?></h5>
                            <p>
                            <h5>Order number: <?php echo $orderNo ?></h5>
                            <h5>Order Date: <?php echo(date('l dS F Y h:i:s A T', strtotime($date))) ?></h5>
                            <h5>Payment method: SMS</h5>
                            </p>
                        </td>
                        <td style='width:50%;background-color: #ffffff;padding: 12px;'>
                            <div style='overflow:hidden;'>
                                <h4 style='display: inline;'>Credits earned:</h4> <h5 style='display: inline;'><?php echo $credit ?> Credits</h5>
                            </div>
                            <br/>
                            <hr style='margin: 2px 0px;'>
                            <div style='overflow:hidden;'>
                                <h4 style='float:left;width: 50%;'>Item</h4><h4 style='float:right;'>Price</h4>
                            </div>
                            <hr style='margin: 2px 0px;'>
                            <div style='overflow:hidden;'>
                                <h4 style='float:left;width: 50%;'>(1) Game play</h4><h4 style='float:right;'>$<?php echo $price ?></h4>
                            </div>
                            <hr style='margin: 2px 0px;'>
                            <div style='overflow:hidden;'>
                                <h4 style='float:left;width: 50%;'></h4><h4 style='float:right;'>Total: $<?php echo $price ?></h4>
                            </div>
                        </td>
                        </tr>
                    </table>
                </p>
            </div>
        </div>
    </div>
</div>
