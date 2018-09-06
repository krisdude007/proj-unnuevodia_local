<?php

/**
 * This is the model class for table "game_choice_t_response".
 *
 * The followings are the available columns in table 'game_choice_t_response':
 * @property integer $id
 * @property integer $game_choice_id
 * @property integer $game_choice_answer_id
 * @property integer $user_id
 * @property string $source
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eGameChoiceResponse extends GameChoiceResponse
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('user_id', 'default', 'value' => Yii::app()->user->getId()),
			array('user_id, source', 'required'),
			array('game_choice_id, game_choice_answer_id, user_id, is_winner', 'numerical', 'integerOnly'=>true),
                        array('is_winner', 'default', 'value' => 0),
			array('source', 'length', 'max'=>256),
			array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			array('id, game_choice_id, game_choice_answer_id, user_id, is_winner, source, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'game_choice_id' => 'Game Choice',
			'game_choice_answer_id' => 'Game Choice Answer',
			'user_id' => 'User',
                        'is_winner' => 'Winner',
			'source' => 'Source',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
		);
	}
        
        public function scopes() {
            return array(
                'recent' => array('order' => '`t`.`id` DESC'),
                'isWinner' => array(
                    'condition' => "is_winner = '1'",
                ),
            );
        }

	
        
        public function filterByDates($startDate, $endDate) {
            return DateTimeUtility::filterByDates($this, $startDate, $endDate);
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameChoiceResponse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
