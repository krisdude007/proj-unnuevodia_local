<?php

class eTickerSearchStats extends TickerSearchStats {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, question_id, num', 'numerical', 'integerOnly' => true),
            array('hashtag', 'length', 'max' => 64),
            array('num', 'default', 'value' => 0),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('user_id, question_id, hashtag, num, created_on', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'eUser', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'question_id' => 'Question',
            'hashtag' => 'hashtag',
            'num' => 'Num',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('hashtag', $this->hashtag);
        $criteria->compare('num', $this->num);
        $criteria->compare('created_on', $this->created_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->created_on)) : null);
        $criteria->compare('updated_on', $this->updated_on !== null ? gmdate("Y-m-d H:i:s", strtotime($this->updated_on)) : null);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }
    
    public function scopes() {
        $defaultScopes = array(
            'recent' => array('order' => '`t`.`id` DESC'),
        );
        
        return $defaultScopes;
    }
}