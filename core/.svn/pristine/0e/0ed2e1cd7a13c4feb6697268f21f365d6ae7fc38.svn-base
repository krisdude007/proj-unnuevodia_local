<?php

/**
 * This is the model class for table "geolocation_info".
 *
 * The followings are the available columns in table 'geolocation_info':
 * @property integer $id
 * @property string $latitude
 * @property string $longitude
 * @property string $ip_address
 * @property string $is_validlocation
 * @property string $city
 * @property string $state
 * @property string $created_on
 * @property string $updated_on
 */
class eGeoLocationInfo extends GeoLocationInfo {

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('latitude, longitude', 'length', 'max' => 20),
            array('ip_address, city, state', 'length', 'max' => 255),
            array('user_id, is_validlocation, is_preshare, is_share', 'numerical', 'integerOnly'=>true),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, latitude, longitude, ip_address, is_preshare, is_share, city, state, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'ip_address' => 'Ip Address',
            'is_validlocation' => 'Is Valid Location',
            'is_preshare' => 'Is Preshare',
            'is_share' => 'Is Share',
            'city' => 'City',
            'state' => 'State',
            'created_on' => 'Created',
            'updated_on' => 'Updated',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('longitude', $this->longitude, true);
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('is_validlocation',$this->is_validlocation,true);
        $criteria->compare('is_preshare',$this->is_preshare,true);
        $criteria->compare('is_share',$this->is_share,true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('state', $this->state, true);
        $criteria->compare('created_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->created_on)):null);
        $criteria->compare('updated_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->updated_on)):null);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GeoLocationInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
