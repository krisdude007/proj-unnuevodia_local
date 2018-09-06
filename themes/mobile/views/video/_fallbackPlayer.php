<video width="100%" controls preload="none" poster="<?php print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->thumbnail; ?><?php echo VIDEO_IMAGE_FILE_EXT; ?>">
    <source src="<?php print '/' . basename(Yii::app()->params['paths']['video']) . '/' . $video->filename; ?><?php echo VIDEO_POST_FILE_EXT; ?>" type="video/mp4">
    Your browser does not support the <code>video</code> element.
</video>