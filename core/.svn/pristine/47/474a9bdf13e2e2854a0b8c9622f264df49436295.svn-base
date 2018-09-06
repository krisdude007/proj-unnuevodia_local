<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.core.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.tooltips.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.hbar.js', CClientScript::POS_END);
$cs->registerScript('graph',"getGraphData({$poll->id});setInterval('getGraphData({$poll->id})',1000);",CClientScript::POS_READY);
$cs->registerScriptFile('/core/webassets/js/preview/preview.js', CClientScript::POS_END);

?>
<?php foreach($poll['pollAnswers'] as $i=>$answer): ?>
        <div class="voteLabels" style="float:left; margin-left: 15px; width: 95%">
            <span style="float:left; font-size: 14px;"><?php echo round($answer->tally / $poll->tally * 100) . '%'?></span>
            <span style="float:right; font-size: 14px;"><?php echo $answer->answer; ?></span>
        </div>

    <canvas class="cvs voteLabels" id="cvs<?php echo $i; ?>" width="450" height="25">[No canvas support]</canvas>
<?php endforeach; ?>

