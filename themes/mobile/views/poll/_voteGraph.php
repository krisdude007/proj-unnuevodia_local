<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.core.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.tooltips.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.hbar.js', CClientScript::POS_END);
$cs->registerScript('graph',"getGraphData({$poll->id});setInterval('getGraphData({$poll->id})',1000);",CClientScript::POS_READY);
?>
<div class="tcenter centerBlock" style="margin-left:auto;margin-right:auto;width:388px;height:128px;background:url('/webassets/images/vote/graph-background3.png');background-repeat:no-repeat; background-size: 100% 100%;">
    <canvas class="cvs" id="cvs" width="600" height="110" style="margin-left:-197px; padding-top:10px">[No canvas support]</canvas>
</div>





<script>
    var bar = new RGraph.Bar('cvs', [[3,4,6],[2,5,3],[1,5,2],[1,4,6],[1,6,8]])
        .set('labels', ['Mal', 'Barry', 'Gary', 'Neil', 'Kim'])
        .set('colors', ['Gradient(#99f:#27afe9:#058DC7:#058DC7)', 'Gradient(#94f776:#50B332:#B1E59F)', 'Gradient(#fe783e:#EC561B:#F59F7D)'])
        .set('hmargin', 15)
        .set('strokestyle', 'white')
        .set('linewidth', 1)
        .set('shadow', true)
        .set('shadow.color', '#ccc')
        .set('shadow.offsetx', 0)
        .set('shadow.offsety', 0)
        .set('shadow.blur', 10)
        .draw();
</script>