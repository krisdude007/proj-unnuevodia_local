<?php

/**
 * This is the model class for table "ad".
 *
 * The followings are the available columns in table 'ad':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $filename
 * @property string $link
 * @property string $start_date
 * @property string $end_date
 * @property string $created_on
 * @property integer $created_by
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property AdDestination[] $adDestinations
 */
class eAd extends Ad {

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, filename, link, created_on, updated_on', 'required'),
            array('created_by', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 20),
            array('description, link', 'length', 'max' => 1024),
            array('filename', 'length', 'max' => 255),
            array('start_date, end_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, filename, link, start_date, end_date, created_on, created_by, updated_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'adDestinations' => array(self::HAS_MANY, 'AdDestination', 'ad_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'filename' => 'Filename',
            'link' => 'Link',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ad the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'current' => array('condition' => "start_date < NOW() and (end_date > NOW() or end_date is null)"),
        );
    }

}
