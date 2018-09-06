<?php

/**
 * This is the model class for table "game_reveal".
 *
 * The followings are the available columns in table 'game_reveal':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $word
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eGameWordScramble extends GameWordScramble {

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'default', 'value' => Yii::app()->user->getId()),
            array('user_id, title, word', 'required'),
            array('user_id, is_active, is_deleted', 'numerical', 'integerOnly' => true),
            array('title, word', 'length', 'max' => 255),
            array('is_active, is_deleted', 'default', 'value' => 0),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('user_id, title, word, is_active, is_deleted, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'title' => 'Title',
            'word' => 'Word',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On'
        );
    }

    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'deleted' => array(
                'condition' => "is_deleted = '1'"
            ),
            'notdeleted' => array(
                'condition' => "is_deleted = '0'"
            ),
            'orderByCreatedDesc' => array(
                'order' => '`t`.created_on DESC',
            ),
            'orderByCreatedAsc' => array(
                'order' => '`t`.created_on ASC',
            ),
            'orderByIDDesc' => array(
                'order' => '`t`.id DESC',
            ),
        );
    }


    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    public function afterFind() {

        return parent::afterFind();
    }
    
    public function afterSave() {
        
        return parent::afterSave();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

