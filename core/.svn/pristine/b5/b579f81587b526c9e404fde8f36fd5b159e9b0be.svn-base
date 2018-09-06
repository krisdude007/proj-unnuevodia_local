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
 * @property string  $entity_type
 * @property string  $created_on
 * @property string  $updated_on
 *
 */
class TvScreenAppearSetting extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tv_screen_setting';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('screen_type, poll_title, entity_type, lang, font_family, font_color, font_size', 'required'),
            array('template, poll_title, font_size_2,font_color_2,bar_color_1,bar_color_2,bar_color_3,bar_color_4,slide_speed, offset_x, offset_y', 'safe'),
            array('direction, offset_x, offset_y', 'numerical', 'integerOnly' => true),
            array('gradient_start_color, gradient_end_color', 'length', 'min' => 2, 'max' => 10),
            array('filename', 'file', 'types' => Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'], 'allowEmpty' => true, 'maxSize' => Yii::app()->params['cloudGraphicAppearanceSetting']['fileSize'], 'tooLarge' => 'The File is Too large to be uploaded.'),
            array('forebg_filename', 'file', 'types' => Yii::app()->params['cloudGraphicAppearanceSetting']['tvScreenImageAllowedType'], 'allowEmpty' => true, 'maxSize' => Yii::app()->params['cloudGraphicAppearanceSetting']['fileSize'], 'tooLarge' => 'The File is Too large to be uploaded.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, screen_type, template, poll_title, filename, gradient_start_color,gradient_end_color,forebg_filename, entity_type, font_family, font_size, font_color, slide_speed, direction, offset_x, offset_y, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'screen_type' => 'Screen Type',
            'template' => 'Template',
            'poll_title' => 'Poll Title',
            'filename' => 'Filename',
            'gradient_start_color' => 'Gradient Start Color',
            'gradient_end_color' => 'Gradient End Color',
            'forebg_filename' => 'Forebackground Filename',
            'font_family' => 'Font Family',
            'font_size' => 'Font Size',
            'font_color' => 'Font Color',
            'font_size_2' => 'Answer Font Size',
            'font_color_2' => 'Answer Font Color',
            'bar_color_1' =>'Bar Color 1',
            'bar_color_2' =>'Bar Color 2',
            'bar_color_3' =>'Bar Color 3',
            'bar_color_4' =>'Bar Color 4',
            'slide_speed' => 'Slide Speed',
            'direction' => 'Direction',
            'offset_y' => 'Offset_X',
            'offset_x' => 'Offset_Y',
            'entity_type' => 'Entity Type',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('screen_type', $this->screen_type);
        $criteria->compare('template', $this->template);
        $criteria->compare('poll_title',$this->poll_title);
        $criteria->compare('filename', $this->filename);
        $criteria->compare('gradient_start_color', $this->gradient_start_color);
        $criteria->compare('gradient_end_color', $this->gradient_end_color);
        $criteria->compare('forebg_filename', $this->forebg_filename);
        $criteria->compare('font_family', $this->font_family);
        $criteria->compare('font_size', $this->font_size);
        $criteria->compare('font_color', $this->font_color);
        $criteria->compare('font_size_2', $this->font_size_2);
        $criteria->compare('font_color_2', $this->font_color_2);
        $criteria->compare('bar_color_1', $this->bar_color_1);
        $criteria->compare('bar_color_2', $this->bar_color_2);
        $criteria->compare('bar_color_3', $this->bar_color_3);
        $criteria->compare('bar_color_4', $this->bar_color_4);
        $criteria->compare('slide_speed', $this->slide_speed);
        $criteria->compare('direction', $this->direction);
        $criteria->compare('offset_x', $this->offset_x);
        $criteria->compare('offset_y', $this->offset_y);
        $criteria->compare('entity_type', $this->entity_type);
        $criteria->compare('created_on', $this->created_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->created_on)) : null);
        $criteria->compare('updated_on', $this->updated_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->updated_on)) : null);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TvScreenAppearSetting the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
