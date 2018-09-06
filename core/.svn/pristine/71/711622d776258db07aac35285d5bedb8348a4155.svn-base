<!DOCTYPE html>
<html>
    <head>
        <?php
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery', CClientScript::POS_HEAD);
        $cs->registerCssFile(Yii::app()->request->baseurl . '//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css');
        $cs->registerScriptFile(Yii::app()->request->baseurl . '/core/webassets/js/preview/preview.js', CClientScript::POS_END);
        $cs->registerScript('graph', "getGraphDataForTV({$activePoll->id});setInterval('getGraphDataForTV({$activePoll->id})',3000);", CClientScript::POS_READY);
        if ($tvScreenSetting->template == 'horizontal') {
            $cs->registerCssFile(Yii::app()->request->baseurl . '/core/webassets/css/preview/preview.css');
        }
        ?>
        <style>
            body {
                <?php
                switch ($tvScreenSetting->screen_type) {
                    case 'transparent':
                        echo 'background: rgba(0, 0, 0, 0.0)!important;';
                        break;
                    case 'green':
                        echo 'background-color: #0DAC1A!important;';
                        break;
                    case 'black':
                        echo 'background-color: #000000! important;';
                        break;
                    case 'background':
                        echo 'background-image:url("/userimages/tvscreensetting/' . $tvScreenSetting->filename . '") ;background-repeat:no-repeat;';
                        break;
                    default:
                        echo 'background: rgba(0, 0, 0, 0.0)!important;';
                        break;
                }
                ?>
            }
            .FontStyle {
                font-family: <?php echo ("'" . $tvScreenSetting->font_family . "'"); ?>;
                font-size: <?php echo ($tvScreenSetting->font_size) ? $tvScreenSetting->font_size : '35'; ?>px;
                color: <?php echo ($tvScreenSetting->font_color) ? $tvScreenSetting->font_color : 'black'; ?>;
            }
            .FontStyle2 {
                font-family: <?php echo ("'" . $tvScreenSetting->font_family . "'"); ?>;
                font-size: <?php echo ($tvScreenSetting->font_size_2) ? $tvScreenSetting->font_size_2 : '35'; ?>px;
                color: <?php echo ($tvScreenSetting->font_color_2) ? $tvScreenSetting->font_color_2 : 'black'; ?>;
            }
            .offset{
                position: relative;
                top: <?php echo ($tvScreenSetting->offset_y) ? $tvScreenSetting->offset_y : '0'; ?>px;
                right: <?php echo ($tvScreenSetting->offset_x) ? $tvScreenSetting->offset_x : '0'; ?>px;
            }
        </style>
    </head>
    <body style="width: 1920px;height: 1080px;text-align: center; background-size: cover;">
        <?php if ($tvScreenSetting->template == 'horizontal'): ?>
            <!--                <div class="FontStyle" style='font-size: 85px;padding-top: 100px; margin-left: 5px'>Today's Poll</div>-->
            <div class="offset">
                <div class="FontStyle" style='text-align: center;background-color: #000000;'>
                    <?php echo $activePoll->question; ?>
                </div>
                <div class="FontStyle2" style="">
                    <div class="Row" style="background-color: #000000;">
                        <?php $i = 1; ?>
                        <?php foreach ($activePoll->pollAnswers as $answer): ?>
                            <div class="Column"><?php echo $answer->answer; ?></div>
                            <div class="Column">
                                <div class="progress" style="box-shadow: none;-webkit-box-shadow:none;overflow: hidden;margin-bottom: 0px;">
                                    <span class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height:46px;background-color:<?php echo(empty($tvScreenSetting->{'bar_color_' . $i}) ? 'black' : $tvScreenSetting->{'bar_color_' . $i}); ?>;"></span>
                                </div>
                            </div>
                            <div class="Column">
                                <div class='percent'>0%</div>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>

            <div class="FontStyle" style='font-size: 85px;padding-top: 100px;padding-top: 50px'><?php echo isset($tvScreenSetting->poll_title) ? $tvScreenSetting->poll_title : "Today's Poll" ?></div>
            <div style="width: 100%; height:100%;">
                <div class="FontStyle" style='margin: 2% 0px;'>
                    <?php echo $activePoll->question; ?>
                </div>
                <div class="FontStyle2" style="">
                    <?php $i = 1; ?>
                    <?php foreach ($activePoll->pollAnswers as $answer): ?>
                        <div style="margin: 0 auto;width: 400px;position: relative;">
                            <div style="text-align: right;position:absolute;right: 410px;top: 0px;width: 560px;"><?php echo $answer->answer; ?></div>
                            <div class="progress" style="height:auto;box-shadow: none;-webkit-box-shadow:none;overflow: hidden;">
                                <span class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="height:46px;background-color:<?php echo(empty($tvScreenSetting->{'bar_color_' . $i}) ? 'black' : $tvScreenSetting->{'bar_color_' . $i}); ?>;"></span>
                            </div>
                            <div class='percent' style="text-align: right;position:absolute;left: 410px;top: 0px;width: 100px;">0%</div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>