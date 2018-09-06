<?php
/* @var $this UserController */
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseurl.'/webassets/js/jquery.jscrollpane.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl.'/webassets/js/jquery.mousewheel.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl.'/webassets/js/mwheelIntent.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseurl.'/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
$cs->registerScript('scrollpane', "$('.scroll-pane').jScrollPane({scrollbarWidth:18,verticalDragMinHeight: 60,verticalDragMaxHeight: 60,horizontalDragMinWidth: 18,horizontalDragMaxWidth: 18,hideFocus: true});");
?>

<div id="content">
    <div class="you">
        <?php
        $this->renderPartial('/user/_sidebar', array(
            'user' => $user,
                )
        );
        ?>
        <div class="verticalRule">
        </div>
        <div class="youContent">
            <h1 style="text-align:left;">Política de Privacidad</h1>
            <div style="background-color: #fff;padding:20px;width:504px;height:349px;overflow:auto" class="jspScrollable scroll-pane">                    
                <?php $this->renderPartial('/user/_privacy'); ?>                    
            </div>
        </div>        
    </div>
</div>
