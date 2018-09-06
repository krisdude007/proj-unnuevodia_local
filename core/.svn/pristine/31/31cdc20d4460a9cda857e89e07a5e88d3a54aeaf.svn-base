<?php

/**
 * This is the model class for table "TvScreenAppearSetting".
 *
 * The followings are the available columns in table 'TvScreenAppearSetting':
 * @property integer $id
 * @property string  $screen_type
 * @property string  $template
 * @property string  $poll_title
 * @property string  $filename
 * @property string  $gradient_start_color
 * @property string  $gradient_end_color
 * @property string  $forebg_filename
 * @property string  $lang
 * @property string  $font_family
 * @property int     $font_size
 * @property string  $font_weight
 * @property string  $font_color
 * @property int     $font_size_2
 * @property string  $font_color_2
 * @property string  $bar_color_1
 * @property string  $bar_color_2
 * @property string  $bar_color_3
 * @property string  $bar_color_4
 * @property int     $slide_speed
 * @property int     $direction
 * @property int     $offset_x
 * @property int     $offset_y
 * @property int     $offset_y_text
 * @property string  $entity_type
 * @property string  $created_on
 * @property string  $updated_on
 *
 */
class eTvScreenAppearSetting extends TvScreenAppearSetting {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('screen_type, entity_type, lang, font_size', 'required'),
            array('font_family', 'default', 'setOnEmpty' => true, 'value' => ''),
            array('template, poll_title, font_weight, font_color,font_color_2,bar_color_1,bar_color_2,bar_color_3,bar_color_4', 'safe'),
            array('font_size_2,slide_speed, offset_x, offset_y, offset_y_text', 'safe'),
            array('direction', 'numerical', 'integerOnly' => true),
            array('gradient_start_color, gradient_end_color', 'length', 'min' => 2, 'max' => 10),
            array('filename', 'file', 'types' => Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'], 'allowEmpty' => true, 'maxSize' => Yii::app()->params['cloudGraphicAppearanceSetting']['fileSize'], 'tooLarge' => 'The File is Too large to be uploaded.'),
            array('forebg_filename', 'file', 'types' => Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'], 'allowEmpty' => true, 'maxSize' => Yii::app()->params['cloudGraphicAppearanceSetting']['fileSize'], 'tooLarge' => 'The File is Too large to be uploaded.'),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, screen_type, template, poll_title, filename, gradient_start_color,gradient_end_color,forebg_filename, entity_type, font_family, font_size, font_weight, font_color,font_size_2,font_color_2,bar_color_1,bar_color_2,bar_color_3,bar_color_4,slide_speed, direction, offset_x, offset_y, offset_y_text,created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

}