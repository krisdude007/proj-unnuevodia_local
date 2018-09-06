<?php

/**
 * This is the model class for table "poll".
 *
 * The followings are the available columns in table 'poll':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $question
 * @property string $start_time
 * @property string $end_time
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property EntityAnswer[] $entityAnswers
 * @property User $user
 * @property PollAnswer[] $pollAnswers
 * @property PollResponse[] $pollResponses
 */
class Poll extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poll';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, question, start_time, end_time, created_on, updated_on', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>8),
			array('question', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, question, start_time, end_time, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'entityAnswers' => array(self::HAS_MANY, 'EntityAnswer', 'poll_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'pollAnswers' => array(self::HAS_MANY, 'PollAnswer', 'poll_id'),
			'pollResponses' => array(self::HAS_MANY, 'PollResponse', 'poll_id'),
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
			'question' => 'Question',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
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
		$criteria->compare('question',$this->question,true);
		$criteria->compare('start_time',$this->start_time!==null?gmdate("Y-m-d H:i:s",strtotime($this->start_time)):null);
		$criteria->compare('end_time',$this->end_time!==null?gmdate("Y-m-d H:i:s",strtotime($this->end_time)):null);
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
	 * @return Poll the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
