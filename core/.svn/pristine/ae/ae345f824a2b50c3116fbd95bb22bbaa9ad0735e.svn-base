<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/core/webassets/css/adminEmail/index.css');
?>
<?php $this->renderPartial('/admin/_csrfToken', array()); ?>
<div class="fab-page-content">
    <div id="fab-top" style="background:#E02222;margin-bottom:0px;">
        <h2 class="fab-title" style="color:white"><img class="floatLeft marginRight10" src="<?php echo Yii::app()->request->baseUrl; ?>/core/webassets/images/video-admin-image.jpg"/>Email Template Admin</h2>
    </div>
    <?php $this->renderPartial('/admin/_flashMessages', array()); ?>
    <div class="fab-container-fluid">
        <h2>Email List:</h2>
        <ul>
            <?php foreach ($emailTemplates as $emailTemplate) : ?>
            <?php
                $name = $emailTemplate->name;
                if($name == 'video submit')
                    $name = 'video submitted';
                else if($name == 'video approve')
                    $name = 'video approved';
                else if($name == 'video_approved')
                    $name = 'video approved(admin)';
            ?>
            <li><h3><a href="/adminEmail/template/<?php echo($emailTemplate->name);?>"><?php echo($name);?></a></h3></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
