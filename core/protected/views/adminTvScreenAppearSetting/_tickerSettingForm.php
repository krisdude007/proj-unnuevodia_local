<div id="settingFormContainer" class="content">
    <div class="clearfix">
        <?php echo CHtml::label('Screen Type', ''); ?>
        <br/>
        <?php
        echo $form->radioButtonList($formTvScreenSettingModel, 'screen_type', array('transparent' => 'Alpha', 'green' => 'Green', 'background' => 'Background'), array('class' => 'radioLabel', 'separator' => '&nbsp;'));
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
    <div class="clearfix">
        <br/>
        <?php echo CHtml::label((($formTvScreenSettingModel->entity_type == 'ticker') ? ' Ticker' : 'Voting' ) . ' background', ''); ?>
        <br/>
        <?php
        if ($formTvScreenSettingModel->forebg_filename != "")
            $selected = 'image';
        else
            $selected = 'color';


        if ($formTvScreenSettingModel->id == "")
            $selected = 'image';
        echo CHtml::radioButtonList('foreground_type', $selected, array('image' => 'Image', 'color' => 'Color'), array('class' => 'radioLabel', 'separator' => '&nbsp;'));
        ?>
    </div>
    <div id="foreOptionColor" style="display:none">
        <br/>
        <?php echo CHtml::label('Choose bar gradient colors', ''); ?><br/>
        <?php echo CHtml::label('Start', 'StartColor'); ?>
        <?php echo $form->textField($formTvScreenSettingModel, 'gradient_start_color', array('id' => 'gradient_start_color', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        <?php echo CHtml::label('End', 'EndColor'); ?>
        <?php echo $form->textField($formTvScreenSettingModel, 'gradient_end_color', array('id' => 'gradient_end_color', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
    </div>
    <div id="foreOptionImage"  >
        <br/>
        <?php echo CHtml::label('Choose an image to upload', ''); ?><br/>
        <input id="existingForeBGImage" type="hidden" value="<?php echo $formTvScreenSettingModel->forebg_filename ?>" name="eTvScreenAppearSetting[existingForeBGImage]">
        <?php echo $form->fileField($formTvScreenSettingModel, 'forebg_filename'); ?>
        <div class="hintTxt">Supported File type: <?php echo Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'] ?> and dimension must be <?php echo Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenScrollImageAllowedDimension'] ?></div>

        <div class="clearfix  forebgImageList">
            <?php
            if (count($foreBgimageFile) > 0) {
                echo '<hr class="breakLine"></hr>';
                echo CHtml::label('Choose an image', '');
            }
            ?>
            <br/>
            <?php
            foreach ($foreBgimageFile as $key => $value) {
                ?>

                <div class="forebgImageListContainer" id="fore_<?php echo $key ?>">
                    <div class="forebgImageListInner"><a href="/userimages/tvscreensetting/<?php echo $value ?>" target="_blank"><img src="/userimages/tvscreensetting/<?php echo $value ?>"  imgid="<?php echo $value ?>"  class="<?php echo (($formTvScreenSettingModel->forebg_filename == $value ) ? 'selectedImg' : 'borderimg') ?>"/></a></div>
                    <div class="imgDelete" style="display:<?php echo (($formTvScreenSettingModel->forebg_filename == $value ) ? 'none' : 'block') ?>"><img src="/core/webassets/images/list_remove.png" deleteid="fore_<?php echo $key ?>" imagename="<?php echo $value ?>" /></div>
                </div>

                <?php
            }
            ?>
        </div>

    </div>

</div>
<?php
echo CHtml::hiddenField('foreBgcountOfFile', count($foreBgimageFile));
echo CHtml::hiddenField('countOfFile', count($BgimageFile));

