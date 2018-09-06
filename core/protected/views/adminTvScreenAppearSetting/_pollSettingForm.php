<div id="settingFormContainer" class="content">
    <div class="clearfix">
        <?php echo CHtml::label('Screen Type', ''); ?>
        <br/>
        <?php
        echo $form->radioButtonList($formTvScreenSettingModel, 'screen_type', array('transparent' => 'Alpha', 'green' => 'Green', 'black' => 'Black', 'background' => 'Background'), array('class' => 'radioLabel', 'separator' => '&nbsp;'));
        ?>
    </div>
    <div id="bgOptionImage" style="display:none">
        <br/>
        <?php echo CHtml::label('Choose an image to upload', ''); ?>
        <input id="existingBGImage" type="hidden" value="<?php echo $formTvScreenSettingModel->filename ?>" name="eTvScreenAppearSetting[existingBGImage]">
        <?php echo $form->fileField($formTvScreenSettingModel, 'filename'); ?>
        <div class="hintTxt">Supported File type: <?php echo Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'] ?> and dimension must be <?php echo Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedDimension'] ?></div>
        <div class="clearfix  bgImageList">
            <?php
            if (count($BgimageFile) > 0)
                echo '<hr class="breakLine"></hr>';
            echo CHtml::label('Choose an image', '');
            ?>
            <br/>
            <?php
            foreach ($BgimageFile as $key => $value) {
                ?>
                <div class="bgImageListContainer" id="<?php echo $key ?>">
                    <div class="bgImageListInner"><img src="/userimages/tvscreensetting/<?php echo $value ?>"  imgid="<?php echo $value ?>"  class="<?php echo (($formTvScreenSettingModel->filename == $value ) ? 'selectedImg' : 'borderimg') ?>"/></div>
                    <div class="imgDelete" style="display:<?php echo (($formTvScreenSettingModel->filename == $value ) ? 'none' : 'block') ?>"><img src="/core/webassets/images/list_remove.png" deleteid="<?php echo $key ?>" imagename="<?php echo $value ?>" /></div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div id="bgOptionTemplate">
        <div class="clearfix">
            <?php echo CHtml::label('Poll Template', ''); ?>
            <br/>
            <?php
            echo $form->radioButtonList($formTvScreenSettingModel, 'template', array(
                'vertical' => '<img src="/webassets/images/poll/h.jpg" style="height: 50px"/>',
                'horizontal' => '<img src="/webassets/images/s.jpg" style="height: 50px"/>',
                'horizontal2' => '<img src="/webassets/images/h2.png" style="height: 50px"/> 1881x231px',
                'horizontal3' => '<img src="/webassets/images/h2.png" style="height: 50px"/> 1728x212px',
                'horizontal4' => '<img src="/webassets/images/h4.jpg" style="height: 26px;padding: 4px 10px;"/> 1728x212px',
                ), array('class' => 'radioLabel', 'separator' => '<div style="display: block;"></div>'));
            ?>
        </div>
    </div>
</div>
<?php
echo CHtml::hiddenField('foreBgcountOfFile', count($foreBgimageFile));
echo CHtml::hiddenField('countOfFile', count($BgimageFile));

