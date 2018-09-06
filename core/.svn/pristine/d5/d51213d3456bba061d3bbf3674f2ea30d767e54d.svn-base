<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.core.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.common.tooltips.js', CClientScript::POS_END);
$cs->registerScriptFile('/webassets/vendor/RGraph/libraries/RGraph.hbar.js', CClientScript::POS_END);
$cs->registerScript('graph', "getGraphDataForTV({$poll->id});setInterval('getGraphDataForTV({$poll->id})',1000);", CClientScript::POS_READY);
$cs->registerScriptFile('/core/webassets/js/preview/preview.js', CClientScript::POS_END);
?>
<div>
    <?php foreach ($poll['pollAnswers'] as $i => $answer): ?>
        <span style="position:relative; bottom: 20px;left: 100px">
            <span class="votepercentage" style="font-weight: lighter; color: #fff;"><?php echo round($answer->tally / $poll->tally * 100) . '%' ?></span>
            <span class="voteLabelsForTV" style="font-weight: lighter; color: #fff;"><?php echo $answer->answer; ?></span>
        </span>
        <span style="background-color: #ffffff;">
            <canvas class="cvs" id="cvs<?php echo $i; ?>" width="200" height="30" >[No canvas support]</canvas>
        </span>
        <span>&nbsp;
        </span>
    <?php endforeach; ?>
</div>

