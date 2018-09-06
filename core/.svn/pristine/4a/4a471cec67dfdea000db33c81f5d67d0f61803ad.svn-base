<?php

/**
 * This is the model class for table "ad_destination".
 *
 * The followings are the available columns in table 'ad_destination':
 * @property integer $id
 * @property integer $ad_id
 * @property integer $user_id
 * @property string $ip
 * @property string $url
 * @property string $type
 * @property string $user_agent
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Ad $ad
 */
class eAdDestination extends AdDestination
{
    public function beforeValidate() {
        if ($this->isNewRecord)
            $this->created_on = date('Y-m-d H:i:s');
        return parent::beforeValidate();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ad_id, ip, url, type, user_agent, created_on', 'required'),
            array('ad_id, user_id', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>15),
            array('url', 'length', 'max'=>1024),
            array('type', 'length', 'max'=>10),
            array('user_agent', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, ad_id, user_id, ip, url, type, user_agent, created_on, updated_on', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'ad' => array(self::BELONGS_TO, 'Ad', 'ad_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'ad_id' => 'Ad',
            'user_id' => 'User',
            'ip' => 'Ip',
            'url' => 'Url',
            'type' => 'Type',
            'user_agent' => 'User Agent',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdDestination the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}