<?php
$cs = Yii::app()->getClientScript();
?>
<div id="pageContainer" class="container">
    <div class="subContainer">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <h1><?php echo Yii::t('youtoo', 'Payment Method') ?></h1>
                <?php if (isset(Yii::app()->session['twitter'])): ?>
                    <p>
                        <img src="/webassets/images/progress/3.png" style="max-width: 500px;"/>
                    </p>
                <?php endif; ?>
                <p class="lead">
                    <?php echo Yii::t('youtoo', 'Please authorize payment to be able to participate in the competition.') ?>
                </p>
            </div>
        </div>
        
        <div class="row">
            <div style="max-width:800px;margin: 0 auto;">
                
            </div>

        </div>
    </div>
</div>

<script>
    function twit_check(me) {
        checked = document.getElementById('');
    }

</script>

