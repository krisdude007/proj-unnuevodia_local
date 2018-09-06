<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
?>


<div id="content">
    <?php
    $this->renderPartial('_formLogin', array(
        'model' => $model,
            )
    );
    ?>  
</div>








