<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/js/jquery.mousewheel.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/mwheelIntent.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/js/jquery.oauthpopup.js', CClientScript::POS_END);
if (!Yii::app()->params['enablePagination'] == true) {
    $cs->registerScriptFile('/webassets/js/jquery.jscrollpane.min.js', CClientScript::POS_END);
    $cs->registerScript('scrollpane', "$('.scroll-pane').jScrollPane({autoReinitialise: true, hideFocus: true, contentWidth:'0px'});");
}
$cs->registerScriptFile(Yii::app()->request->baseurl . '/core/protected/extensions/yiinfinite-scroll/assets/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
?>
<?php if (Yii::app()->params['enablePagination'] == true): ?>
    <div id="content" style="height: 475px">
    <?php else: ?>
        <div id="content">
        <?php endif; ?>
        <div style="text-align:left;width:545px; height: 350px; margin-left:auto;margin-right:auto;">
            <div style="text-align:center;">
                <h1 style="margin-bottom: 0px">VIDEOS</h1>
                <div class="sorter" style="font-size:12px;margin-bottom:5px;">Ver por: &nbsp;&nbsp;
                    <a class="activeLink" href="<?php echo Yii::app()->request->baseurl; ?>/videos/recent">Más recientes</a> &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo Yii::app()->request->baseurl; ?>/videos/views">Más vistos</a> &nbsp;&nbsp;&nbsp;
                    <a href="<?php echo Yii::app()->request->baseurl; ?>/videos/rating">Mejor calificados</a>
                </div>
            </div>
            <?php if (Yii::app()->params['enablePagination'] == true): ?>
                <div class="fab-right" style="margin-top:-3px; margin-left:100px;margin-bottom: 5px;">
                    <?php $this->widget('CLinkPager', array('pages' => $pages, 'header' => '', 'prevPageLabel' => 'Prev', 'nextPageLabel' => 'Next')); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->params['enablePagination'] == true): ?>
                <div class="videoBlocks">
                <?php else: ?>
                    <div class="videoBlocks scroll-pane jspScrollable" style="padding-bottom: 5px">
                    <?php endif; ?>
                    <?php
                    $this->renderPartial('/video/_blocks', array('videos' => $videos)
                    );
                    ?>
                </div>
            </div>
        </div>
