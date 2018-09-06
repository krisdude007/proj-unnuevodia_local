<?php

/**
 * This is the model class for table "game_choice_answer".
 *
 * The followings are the available columns in table 'game_choice_answer':
 * @property integer $id
 * @property integer $game_choice_id
 * @property integer $user_id
 * @property string $answer
 * @property integer $point_value
 * @property integer $is_correct
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property GameChoice $gameChoice
 * @property GameChoiceResponse[] $gameChoiceResponses
 */
class eGameChoiceAnswer extends GameChoiceAnswer {

    public $responses;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'default', 'value' => Yii::app()->user->getId()),
            array('user_id, answer', 'required'),
            array('game_choice_id, user_id, point_value, is_correct', 'numerical', 'integerOnly' => true),
            array('answer', 'length', 'max' => 256),
            array('is_correct, point_value', 'default', 'value' => 0),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('id, game_choice_id, user_id, answer, point_value, is_correct, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'gameChoice' => array(self::BELONGS_TO, 'GameChoice', 'game_choice_id'),
            'gameChoiceResponse' => array(self::HAS_MANY, 'eGameChoiceResponse', 'game_choice_answer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_choice_id' => 'Game Choice',
            'user_id' => 'User',
            'answer' => 'Answer',
            'point_value' => 'Credit Value',
            'is_correct' => 'Is Correct',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'isCorrect' => array(
                'condition' => "is_correct = '1'",
            ),
        );
    }



    public function afterFind() {

        $this->responses = eGameChoiceResponse::model()->count("game_choice_id={$this->game_choice_id} AND game_choice_answer_id={$this->id}");

        return parent::afterFind();
    }

    public function filterByDates($startDate, $endDate) {
        return DateTimeUtility::filterByDates($this, $startDate, $endDate);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GameChoiceAnswer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
