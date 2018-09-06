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
    <div class="clearfix">
        <br/>
        <?php echo CHtml::label('Sliding Speed', ''); ?>
        <br/>
        <?php echo $form->hiddenField($formTvScreenSettingModel, 'slide_speed'); ?>
        <div class="graph">
            <div style="height: 8px;" class="bar" barValue="30"></div>
            <div style="height: 15px;" class="bar" barValue="50"></div>
            <div style="height: 20px;" class="bar" barValue="70"></div>
            <div style="height: 25px;" class="bar" barValue="90"></div>
            <div style="height: 30px;" class="bar" barValue="110"></div>
            <div style="height: 35px;" class="bar" barValue="220"></div>
            <div style="height: 40px;" class="bar" barValue="300"></div>
            <div style="height: 45px;" class="bar" barValue="400"></div>
        </div>
    </div>
    <div class="clearfix">
        <?php echo CHtml::label('Language', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'lang', $langs, array('onchange' => 'languageSelected(this);')) ?>
    </div>
    <div class="clearfix">
        <?php echo CHtml::label('Font-Family', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_family', $fontFamily);
        ?>
    </div>
    <div class="clearfix">
        <?php echo CHtml::label('Font-Size', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_size', $fontSize) ?> PX
    </div>
    <div class="clearfix">
        <?php echo CHtml::label('Font-Weight', ''); ?>
        <br/>
        <?php echo $form->DropDownList($formTvScreenSettingModel, 'font_weight', array('normal'=>'normal','bold'=>'bold')) ?>
    </div>
    <div class="clearfix">
        <?php echo CHtml::label('Font-Color', ''); ?>
        <br/>
        <?php echo $form->textField($formTvScreenSettingModel, 'font_color', array('id' => 'fontColorPicker','class'=>'spectrumColorPicker', 'style' => 'width: 50px', 'maxlength' => 5)) ?>
    </div>
    <div class="clearfix" style="padding: 4px 0px;">
        <?php echo CHtml::label('Ticker Position', ''); ?>
        <div style="position: relative;height: 60px;">
            <span style="position: absolute; top: 0px; left: 30px;"><input type='button' value='&uarr;' class='qtyminusTopContainer' field='quantity' /></span>
            <span style="position: absolute; top: 30px; left: 30px;"><input type='button' value='&darr;' class='qtyplusTopContainer' field='quantity' /></span>
            <div style="position: absolute; top: 14px; left: 100px;">
                <?php echo $form->textField($formTvScreenSettingModel, 'offset_y', array('id' => 'offset_y','style' => 'width: 35px', 'maxlength' => 5)) ?> PX
            </div>
        </div>
    </div>
    <div class="clearfix" style="padding: 4px 0px;">
        <?php echo CHtml::label('Ticker Text Position', ''); ?>
        <div style="position: relative;height: 60px;">
            <span style="position: absolute; top: 0px; left: 30px;"><input type='button' value='&uarr;' class='qtyminusTopText' field='quantity' /></span>
            <span style="position: absolute; top: 30px; left: 30px;"><input type='button' value='&darr;' class='qtyplusTopText' field='quantity' /></span>
            <div style="position: absolute; top: 14px; left: 100px;">
                <?php echo $form->textField($formTvScreenSettingModel, 'offset_y_text', array('id' => 'offset_y_text','style' => 'width: 35px', 'maxlength' => 5)) ?> PX
            </div>
        </div>
    </div>
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
</div>