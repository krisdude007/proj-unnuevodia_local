<div class='as-table'>
<!--    <div class="homeTop">
        <h4>Be On TV</h4>
    </div>-->
    <div style='background-color:#f1f1f1;padding: 10% 25%;'>
        <img class=homeImage src="/webassets/mobile/images/Image_Logo_Landing.png"/>
    </div>
    <div class="homeFooter text-center as-table-row">
        <div style='height:33%;background-color:#ec992e;'>
            <div style='height:100%;'>
                <button class="filledButton" onclick="window.location='<?php echo Yii::app()->createUrl('poll/index'); ?>'"><img src="/webassets/mobile/images/Icon_Vote.png" style="max-width: 45px; width: 100%; margin-top: 10px;"/><h2>votación</h2><h5>vota ahora</h5></button>
            </div>
        </div>
        <div style='height:33%;background-color:#d8512b;'>
            <div style='height:100%;'>
                <button class="filledButton" onclick="window.location='<?php echo Yii::app()->createUrl('questions/'); ?>'"><img src="/webassets/mobile/images/Icon_Video.png" style="max-width: 45px; width: 100%; margin-top: 10px;"/><h2>video</h2><h5>sube un video</h5></button>
            </div>
        </div>
        <div style='height:34%;background-color:#d83227;'>
            <div style='height:100%;'>
                <button class="filledButton" onclick="window.location='<?php echo Yii::app()->createUrl('upload/'); ?>'"><img src="/webassets/mobile/images/Icon_Photo.png" style="max-width: 45px; width: 100%; margin-top: 10px;"/><h2>foto</h2><h5>sube una foto</h5></button>
            </div>
        </div>
    </div>
</div>
