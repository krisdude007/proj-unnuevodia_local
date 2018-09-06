<?php if(is_array($videoInfo['videofile'])): ?>
<?php else: ?>
<div class="entry">
    <video controls style='width:100%; height:auto;'>
        <source src='<?php echo  $videoInfo['videofile'];?>' type='video/mp4'>
    </video>
</div>
<?php endif; ?>