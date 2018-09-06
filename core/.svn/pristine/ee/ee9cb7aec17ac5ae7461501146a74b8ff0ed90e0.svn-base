<?php

class eUserLogin extends UserLogin {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'userTeches' => array(self::HAS_MANY, 'UserTech', 'login_id'),
        );
    }

    public function scopes() {
        $alias = $this->getTableAlias();
        return array(
            'latest' => array('order' => $alias.'.created_on desc'),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, result', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('ip_address, ip_basedcity, ip_basedstate', 'length', 'max' => 255),
            array('result', 'length', 'max' => 4),
            array('ip_address', 'default', 'value' => Yii::app()->request->getUserHostAddress()),
            array('ip_basedcity', 'default', 'value' => 'unknown'),
            array('ip_basedstate', 'default', 'value' => 'unknown'),
            array('created_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, ip_address, ip_basedcity, ip_basedstate, result, created_on', 'safe', 'on' => 'search'),
        );
    }

}