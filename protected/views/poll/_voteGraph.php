<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.core.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.tooltips.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.hbar.js', CClientScript::POS_END);
$cs->registerScript('graph',"getGraphData({$poll->id});setInterval('getGraphData({$poll->id})',1000);",CClientScript::POS_READY);
?>
<div style="float:right;width:420px;height:128px;background:url('/webassets/images/vote/graph-background3.png');">
    <canvas class="cvs" id="cvs" width="617" height="112" style="float:right; margin-top: 8px; ">[No canvas support]</canvas>
</div>
