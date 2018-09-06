<?php

/**
 * This is the model class for table "game_choice".
 *
 * The followings are the available columns in table 'game_choice':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $question
 * @property string $description
 * @property double $price
 * @property string $prize
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property GameChoiceAnswer[] $gameChoiceAnswers
 * @property GameChoiceResponse[] $gameChoiceResponses
 * @property GameChoiceSmsinbound[] $gameChoiceSmsinbounds
 * @property GamingTransaction[] $gamingTransactions
 */
class GameChoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'game_choice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, question, description, created_on, updated_on', 'required'),
			array('user_id, g_parant_id, reveal_id, is_active, is_deleted', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('type', 'length', 'max'=>8),
			array('question, prize', 'length', 'max'=>256),
			array('description', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, g_parant_id, reveal_id, question, description, price, prize, is_active, is_deleted, start_date, close_date, open_date, end_date, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'gameChoiceAnswers' => array(self::HAS_MANY, 'GameChoiceAnswer', 'game_choice_id'),
			'gameChoiceResponses' => array(self::HAS_MANY, 'GameChoiceResponse', 'game_choice_id'),
			'gameChoiceSmsinbounds' => array(self::HAS_MANY, 'GameChoiceSmsinbound', 'game_choice_id'),
			'gamingTransactions' => array(self::HAS_MANY, 'GamingTransaction', 'game_choice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
                        'g_parant_id' => 'Game Parant ID',
                        'reveal_id' => 'Reveal ID',
			'question' => 'Question',
			'description' => 'Description',
			'price' => 'Price',
                        'prize' => 'Prize',
			'is_active' => 'Is Active',
			'is_deleted' => 'Is Deleted',
                        'start_date' => 'Start Date',
                        'close_date' => 'Close Date',
                        'open_date' => 'Open Date',
                        'end_date' => 'End Date',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
                $criteria->compare('g_parant_id',$this->g_parant_id,true);
                $criteria->compare('reveal_id',$this->type,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price);
                $criteria->compare('prize',$this->prize);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_deleted',$this->is_deleted);
                $criteria->compare('start_date',$this->start_date,true);
                $criteria->compare('close_date',$this->close_date,true);
                $criteria->compare('open_date',$this->open_date,true);
                $criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('updated_on',$this->updated_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameChoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
