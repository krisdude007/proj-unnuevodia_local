<?php
//if(!isset($width)) $width = '528';
//if(!isset($height)) $height = '297';
?>
<!--<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="528" height="297" allowFullScreen="true">
    <param name="flashvars" value="file=<?php //print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->filename; ?><?php //echo VIDEO_POST_FILE_EXT;?>&image=<?php //print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->thumbnail; ?><?php //echo VIDEO_IMAGE_FILE_EXT;?>&controlbar=none&dock=false&autostart=false&stretching=exactfit" />
    <param name="movie" value="/webassets/swf/player.swf" />
    <param name="wmode" value="transparent" />
    <embed src="/webassets/swf/player.swf"
           width="<?php //echo $width;?>"
           height="<?php //echo $height;?>"
           wmode="transparent"
           type="application/x-shockwave-flash"
           pluginspage="http://www.macromedia.com/go/getflashplayer"
           allowFullScreen="true"
           flashvars="file=<?php //print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->filename; ?><?php //echo VIDEO_POST_FILE_EXT;?>&image=<?php //print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->thumbnail; ?><?php //echo VIDEO_IMAGE_FILE_EXT;?>&controlbar=none&dock=false&autostart=false&stretching=exactfit" />
</object>-->


<?php
if (!isset($width))
    $width = '528';
if (!isset($height))
    $height = '297';
$image = Yii::app()->createAbsoluteUrl('/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->thumbnail . Yii::app()->params['video']['imageExt']);
$file = Yii::app()->createAbsoluteUrl('/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->filename . Yii::app()->params['video']['postExt']);
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="<?php echo($width) ?>" height="<?php echo($height) ?>">
    <param name="movie" value="/core/webassets/swf/StrobeMediaPlayback.swf"></param>
    <param name="FlashVars" value="src=<?php echo(rawurldecode($file)) ?>&poster=<?php echo(rawurldecode($image)) ?>&backgroundColor=FFFFFF&scaleMode=stretch"></param>
    <param name="allowFullScreen" value="true"></param>
    <param name="allowscriptaccess" value="always"></param>
    <embed src="/core/webassets/swf/StrobeMediaPlayback.swf"
           type="application/x-shockwave-flash"
           allowscriptaccess="always" allowfullscreen="true"
           width="<?php echo($width) ?>"
           height="<?php echo($height) ?>"
           FlashVars="src=<?php echo(rawurldecode($file)) ?>&poster=<?php echo(rawurldecode($image)) ?>&backgroundColor=FFFFFF&scaleMode=stretch">
    </embed>
</object>