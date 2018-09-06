<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('flagVideo', "
    setFlag('video');//Better than \$video->tableName(), which can be empty
    ", CClientScript::POS_READY);
?>
<div class="video">
    <div style="overflow: hidden;">
        <div class="player" id="player">
            <?php
            $this->renderPartial('_fallbackPlayer', array(
                'video' => $video,
                'width' => 528,
                'height' => 297,
            ));
            $fullname = empty(trim($video->user->first_name . " " . $video->user->last_name)) ? "N/A" : trim($video->user->first_name . " " . $video->user->last_name);
            ?>
        </div>
        <div class="fabmob_video-copy-container">
            <img src="<?php echo UserUtility::getAvatar($video->user); ?>" style="float:left;width:40px;height:40px;border-radius: 20px;margin-right:8px;">
            <h6 style="float:right;"><?php echo date('M d, Y',  strtotime($video->created_on)); ?></h6>
            <h5 class="fabmob_video-title"><?php echo $fullname; ?></h5>
            <h6><?php echo $video->title; ?></h6>
            <img src="/webassets/mobile/images/Icon_Views.png" style="height:14px;"> <span><?php echo $video->views; ?></span> &nbsp;&nbsp;&nbsp;
            <img src="/webassets/mobile/images/Icon_Rating.png" style="height:14px;"> <span><?php echo $video->rating; ?></span>
            <div style="float:right;">
                <a class="flag" tbl="<?php echo($video->tableName()) ?>" contentId="<?php echo($video->id)  ?>" onclick="popupReport(this)">
                    <img src="/webassets/mobile/images/icon_flag.png" style="height:14px;"> Flag Video
                </a>
            </div>
        </div>
        <div class="fabmob_video-copy-container">
            <p style='font-size: 16px;'>Description</p>
            <p><?php echo $video->description ?></p>
        </div>
    </div>
</div>