<?php

/**
 * This is the model class for table "postal_code".
 *
 * The followings are the available columns in table 'postal_code':
 * @property integer $id
 * @property string $identifier
 * @property string $latitude
 * @property string $longitude
 * @property string $city
 * @property string $state
 * @property string $county
 * @property string $type
 * @property string $income
 * @property string $last_checked_on
 * @property string $created_on
 * @property string $updated_on
 */
class PostalCode extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'postal_code';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('identifier, latitude, longitude, city, state, county, type, income, last_checked_on, created_on, updated_on', 'required'),
            array('identifier', 'length', 'max'=>16),
            array('latitude, longitude, city, county, type', 'length', 'max'=>255),
            array('state', 'length', 'max'=>2),
            array('income', 'length', 'max'=>11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, identifier, latitude, longitude, city, state, county, type, income, last_checked_on, created_on, updated_on', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'identifier' => 'Identifier',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'city' => 'City',
            'state' => 'State',
            'county' => 'County',
            'type' => 'Type',
            'income' => 'Income',
            'last_checked_on' => 'Last Checked On',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('identifier',$this->identifier,true);
        $criteria->compare('latitude',$this->latitude,true);
        $criteria->compare('longitude',$this->longitude,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('state',$this->state,true);
        $criteria->compare('county',$this->county,true);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('income',$this->income,true);
        $criteria->compare('last_checked_on',$this->last_checked_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->last_checked_on)):null);
        $criteria->compare('created_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->created_on)):null);
        $criteria->compare('updated_on',$this->updated_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->updated_on)):null);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PostalCode the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}