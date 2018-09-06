<?php
$tmpFontSize = range(30, 40);
$fontSize = array();
foreach ($tmpFontSize as $key => $value) {
    $fontSize[$value] = $value;
}
$langs = array(
    'en' => 'English',
);
$fontFamily = $enFamilys = array(
    'Arial' => 'Arial',
    'Helvetica' => 'Helvetica',
    'Times New Roman' => 'Times New Roman',
    'Times' => 'Times',
    'Courier New' => 'Courier New',
    'Courier' => 'Courier',
    'Impact' => 'Impact',
    'Georgia' => 'Georgia',
    'Palatino Linotype' => 'Palatino Linotype',
    'Tahoma' => 'Tahoma',
    'Century Gothic' => 'Century Gothic',
    'Lucida Sans Unicode' => 'Lucida Sans Unicode',
    'Arial Black' => 'Arial Black',
    'Verdana' => 'Verdana',
    'Lucida Console' => 'Lucida Console',
);
$arFamilys = array();
$esFamilys = array();
if (Yii::app()->language == "ar") {
    $langs['ar'] = 'Arabic';
    $arFamilys = array('' => '');
}
if ($formTvScreenSettingModel->lang == 'ar') {
    $fontFamily = $arFamilys;
}
if (Yii::app()->language == "es") {
    $langs['es'] = 'Spanish';
    $esFamilys = array(
        'Arial' => 'Arial',
        'Helvetica' => 'Helvetica',
        'Times New Roman' => 'Times New Roman',
        'Times' => 'Times',
        'Courier New' => 'Courier New',
        'Courier' => 'Courier',
        'Impact' => 'Impact',
        'Georgia' => 'Georgia',
        'Palatino Linotype' => 'Palatino Linotype',
        'Tahoma' => 'Tahoma',
        'Century Gothic' => 'Century Gothic',
        'Lucida Sans Unicode' => 'Lucida Sans Unicode',
        'Arial Black' => 'Arial Black',
        'Verdana' => 'Verdana',
        'Lucida Console' => 'Lucida Console',
    );
}
if ($formTvScreenSettingModel->lang == 'es') {
    $fontFamily = $esFamilys;
}
?>
<script>
    var enFamilys = <?php echo json_encode($enFamilys) ?>;
    var arFamilys = <?php echo json_encode($arFamilys) ?>;
    var esFamilys = <?php echo json_encode($esFamilys) ?>;
    var initLang = document.getElementById('eTvScreenAppearSetting_lang').value;
    var initFont = document.getElementById('eTvScreenAppearSetting_font_family').value;
    function languageSelected(me) {
        fontFamily = document.getElementById('eTvScreenAppearSetting_font_family');
        fontFamily.options.length = 0;
        if (me.value === 'en') {
            for (var key in enFamilys) {
                fontFamily.options[fontFamily.length] = new Option(enFamilys[key], key);
            }
        }
        else if (me.value === 'ar') {
            for (var key in arFamilys) {
                fontFamily.options[fontFamily.length] = new Option(arFamilys[key], key);
            }
        }
        else if (me.value === 'es') {
            for (var key in esFamilys) {
                fontFamily.options[fontFamily.length] = new Option(esFamilys[key], key);
            }
        }
        //select back on change to initital select
        if (me.value === initLang) {
            fontFamily.value = initFont;
        }
    }
</script>
<div id="toolsFormContainer" class="content" style="display:none">
    <div>
        <?php echo CHtml::label('Language', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'lang', $langs, array('onchange' => 'languageSelected(this);')) ?>
    </div>
    <div>
        <?php echo CHtml::label('Font-Family', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_family', $fontFamily);
        ?>
    </div>
    <div>
         <?php echo CHtml::label('Poll Title', ''); ?>
        <br/>
        <?php echo $form->textField($formTvScreenSettingModel, 'poll_title', array());
        ?>
    </div>
    <div style="vertical-align: middle;">
        <label>Poll Question :</label>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php echo CHtml::label('Font-Size', ''); ?>
            <br/>
            <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_size', $fontSize) ?> PX
        </div>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php echo CHtml::label('Font-Color', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'font_color', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php //echo CHtml::label('Move-Left', ''); ?>
            <br/>
            <span style="position: absolute; top: 300px; left: 385px;"><input type='button' value='&uarr;' class='qtyminusTop' field='quantity' /></span>
            <span style="position: absolute; top: 330px; left: 355px;"><input type='button' value='&larr;' class='qtyplusLeft' field='quantity' /></span>
            <span style="position: absolute; top: 330px; left: 410px;"><input type='button' value='&rarr;' class='qtyminusLeft' field='quantity' /></span>
            <span style="position: absolute; top: 360px; left: 385px;"><input type='button' value='&darr;' class='qtyplusTop' field='quantity' /></span>
        </div>
    </div>
    <div style="vertical-align: middle;">
        <label>Answers :</label>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php echo CHtml::label('Font-Size', ''); ?>
            <br/>
            <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_size_2', $fontSize) ?> PX
        </div>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php echo CHtml::label('Font-Color', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'font_color_2', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
        <div style="display:inline-block;vertical-align: top;padding: 0px 2%;">
            <?php echo CHtml::label('Graph Position', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'offset_x', array('id' => 'offset_x', 'style' => 'width: 35px', 'maxlength' => 5)) ?> PX
            <?php echo $form->textField($formTvScreenSettingModel, 'offset_y', array('id' => 'offset_y','style' => 'width: 35px', 'maxlength' => 5)) ?> PX
        </div>
    </div>
    <div>
        <label>Bar Colors :</label>
        <div style="display:inline-block;vertical-align: top;">
            <?php echo CHtml::label('Color 1', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'bar_color_1', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
        <div style="display:inline-block;vertical-align: top;">
            <?php echo CHtml::label('Color 2', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'bar_color_2', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
        <div style="display:inline-block;vertical-align: top;">
            <?php echo CHtml::label('Color 3', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'bar_color_3', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
        <div style="display:inline-block;vertical-align: top;">
            <?php echo CHtml::label('Color 4', ''); ?>
            <br/>
            <?php echo $form->textField($formTvScreenSettingModel, 'bar_color_4', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
        </div>
    </div>
    <!--
    <div class="clearfix"><br/>
        <?php echo CHtml::label('Show Running Preview LTR OR RTL', ''); ?>
        <div class="onoffswitch">
            <?php echo $form->checkBox($formTvScreenSettingModel, 'direction', array('value' => 1, 'uncheckValue' => 0, 'class' => 'onoffswitch-checkbox', 'id' => "myonoffswitch")) ?>
            <label class="onoffswitch-label" for="myonoffswitch">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
    </div>
    -->
</div>