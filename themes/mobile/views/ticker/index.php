<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('flagTicker', "
    setFlag('ticker');//Better than \$ticekrs[0]->tableName(), which can be empty
    ", CClientScript::POS_READY);

function timetoago($datetime) {
    $time = strtotime($datetime);
    $diff = strtotime("now") - $time;
    $diff = $diff / 60;
    $var1 = floor($diff);
    $var = $var1 <= 1 ? 'min' : 'mins';
    if ($diff >= 60) {
        $diff = $diff / 60;
        $var1 = floor($diff);
        $var = $var1 <= 1 ? 'hour' : 'hours';
    }
    else
        return $var1 . ' ' . $var;
    if ($diff >= 24) {
        $diff = $diff / 24;
        $var1 = floor($diff);
        $var = $var1 <= 1 ? 'day' : 'days';
    }
    else
        return $var1 . ' ' . $var; //hours ago
    if ($diff >= 30.4375) {
        $diff = $diff / 30.4375;
        $var1 = floor($diff);
        $var = $var1 <= 1 ? 'month' : 'months';
    }
    else
        return $var1 . ' ' . $var; //days ago
    if ($diff >= 12) {
        $diff = $diff / 12;
        $var1 = floor($diff);
        $var = $var1 <= 1 ? 'year' : 'years';
    }
    else
        return $var1 . ' ' . $var; //month ago
    return date('M j Y', $time); //years ago
}
?>
<div>
    <div class="homeTop">
        <b style="font-weight: 300;">Interactuando con</b> Un Nuevo Día
    </div>
    <div style="background-color: #dfdfdf;overflow: hidden;">
        <div style="text-align: center;">
            <?php if (Yii::app()->user->isGuest): ?>
                <div class='socialheader' style="color:#696969;">Login to join the Social Activity!</div>
                <div>
                    <a href="<?php echo Yii::app()->createUrl('/user/login'); ?>" class='btn white bold form_button' >Login</a>
                </div>
            <?php else: ?>
                <?php $this->renderPartial('_formTicker', Array('tickerModel' => $tickerModel)); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="social" style='width: 100%;'>
        <?php foreach ($tickers as $ticker): ?>
            <div class="social_list" style="font-size:100%;overflow: hidden;">
                <div style="float:left;line-height:100%;vertical-align:middle;">
                    <img src="<?php echo TickerUtility::getAvatar($ticker); ?>"/>
                </div>
                <div class="text" style="overflow:hidden;padding: 0px 6px;font-size: 0.6em;">
                    <div style="font-weight: bold;">
                        <span class="bold"><?php echo (isset($ticker->user)) ?  $ticker->user->first_name . ' ' . $ticker->user->last_name : TickerUtility::getUsername($ticker); ?></span>
                        <span style='padding: 0px 4px;'><?php echo timetoago($ticker->created_on) ?> ago</span>
                        <a style='float:right;padding: 0px 4px;' class="flag" tbl="<?php echo $ticker->tableName() ?>" contentId="<?php echo $ticker->id ?>" onclick="popupReport(this)">
                            <img style='width: auto; height: auto; border-radius: 0;' src="/webassets/mobile/images/icon_flag.png" style="height:14px;"> Flag Ticker
                        </a>
                    </div>
                    <div style="font-weight: normal;">
                        <?php echo $ticker->ticker; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

