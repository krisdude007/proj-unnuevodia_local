<?php

class eUserPhoto extends UserPhoto {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public $image;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
            array('type', 'default', 'value' => 'primary'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('filename, type', 'length', 'max' => 255),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg,jpeg,gif,png'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, filename, type, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'filename' => 'Filename',
            'image' => 'Avatar',
            'type' => 'Type',
            'created_on' => 'Created',
            'updated_on' => 'Updated',
        );
    }

    public function scopes() {
        return array(
            'primary' => array('condition' => 'type="primary"')
        );
    }

}