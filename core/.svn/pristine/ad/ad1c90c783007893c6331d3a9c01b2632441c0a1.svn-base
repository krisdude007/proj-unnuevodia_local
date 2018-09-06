<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile('/core/webassets/css/preview/preview.css');
$cs->registerCSS('body', 'body{margin:0px;overflow: hidden;}');
$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerScriptFile('/core/webassets/js/preview/preview.js', CClientScript::POS_HEAD);
 
$speed = ''; 
if($tvScreenSetting->slide_speed)
    $speed = $tvScreenSetting->slide_speed;
else
    $speed =  35;
 
if($tvScreenSetting->direction == null || $tvScreenSetting->direction == 1)
    $direction = 1;
else
    $direction = 0;

if ($direction == 1) { 
    $cs->registerScript('previewRev', 'sliderHandlerReverse('.$speed.');', CClientScript::POS_READY);
} else { 

    $cs->registerScript('preview', 'sliderHandler('.$speed.');', CClientScript::POS_READY);
}
//  echo 'background:rgba(13, 172, 26, 1);'; 
?>
<style>
body {
    <?php 
    switch($tvScreenSetting->screen_type){
        case 'transparent': 
            echo 'background: rgba(0, 0, 0, 0.0);'; 
        break;
        case 'green': 
            echo 'background-color: #0DAC1A;'; 
        break;
        case 'background': 
            echo 'background-image:url("/userimages/tvscreensetting/'.$tvScreenSetting->filename.'") ;background-repeat:repeat-y;'; 
        break; 
        default: 
            echo 'background: rgba(0, 0, 0, 0.0);'; 
        break;
    }
    ?> 
}
.dynamicFontStyle { 
    font-size: <?php echo ($tvScreenSetting->font_size) ? $tvScreenSetting->font_size : '35'; ?>px;
    color: <?php echo ($tvScreenSetting->font_color) ?  $tvScreenSetting->font_color : '#fff' ; ?>;
    margin-top:8px; 
    margin-left:60px;
    position: relative; 
    width: 2600px;
}
 
<?php 
    $gradientStartColor =  ($tvScreenSetting->gradient_start_color) ? $tvScreenSetting->gradient_start_color :  '#00c6ff'; 
    $gradientEndColor =  ($tvScreenSetting->gradient_end_color) ? $tvScreenSetting->gradient_end_color :  '#fa00ff';
?>
#sliderContainer {
    <?php if($tvScreenSetting->forebg_filename == "") :?>
    background: -webkit-linear-gradient(<?php echo $gradientStartColor.','.$gradientEndColor ?>); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(<?php echo $gradientStartColor.','.$gradientEndColor ?>); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(<?php echo $gradientStartColor.','.$gradientEndColor ?>); /* For Firefox 3.6 to 15 */
    background: linear-gradient(<?php echo $gradientStartColor.','.$gradientEndColor ?>); /* Standard syntax */
     filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo $gradientStartColor?>, endColorstr=<?php echo $gradientEndColor?>);
        /* For Internet Explorer 8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=<?php echo $gradientStartColor?>, endColorstr=<?php echo $gradientEndColor?>)";
    <?php else : 
    echo 'background-image:url("/userimages/tvscreensetting/'.$tvScreenSetting->forebg_filename.'");'; 
    endif; ?>

}
</style>

<?php echo CHtml::hiddenField('slide_speed',$speed);?>
<!--<div class="message">Broadcast Signal</div>-->

<?php if ($direction == 1): ?> 
   <div id="sliderContainer"> 
        <div class="slidersRev">
            <?php foreach ($tickers as $t) { ?>
                <div class="sliderRev">
                    <div class="avatar"><img src="<?php echo TickerUtility::getAvatar($t); ?>" alt="avatar"></div>
                    

                    <div class="dynamicFontStyle"><?php echo TickerUtility::getUsername($t); ?> &nbsp; <?php echo $t->ticker; ?></div>
                </div>
            <?php } ?>

            <?php if (sizeof($tickers) == 0) { ?>
                <div class="sliderRev">
                    <div class="dynamicFontStyle">There are no tickers approved for this question.</div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php else: ?> 
   <div id="sliderContainer"> 
        <div class="sliders">
            <?php foreach ($tickers as $t) { ?>
                <div class="slider">
                    <div class="avatar"><img src="<?php echo TickerUtility::getAvatar($t); ?>" alt="avatar"></div>
                    
                    <div class="dynamicFontStyle"><?php echo TickerUtility::getUsername($t); ?>&nbsp;<?php echo $t->ticker; ?></div>
                </div>
            <?php } ?>

            <?php if (sizeof($tickers) == 0) { ?>
                <div class="slider">
                    <div class="dynamicFontStyle">There are no tickers approved for this question.</div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>