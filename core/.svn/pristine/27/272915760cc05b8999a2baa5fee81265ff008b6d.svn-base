<?php

/**
 * This is the model class for table "credit_transaction".
 *
 * The followings are the available columns in table 'credit_transaction':
 * @property integer $id
 * @property integer $user_id
 * @property string $game_type
 * @property integer $game_id
 * @property string $prize_id
 * @property integer $trans_id
 * @property string $type
 * @property string $credits
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property GamingTransaction $trans
 * @property User $user
 * @property Prize $prize
 */
class CreditTransaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'credit_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, type, credits, created_on, updated_on', 'required'),
			array('user_id, game_id, trans_id, is_deleted', 'numerical', 'integerOnly'=>true),
			array('game_type, prize_id, credits', 'length', 'max'=>11),
			array('type', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, game_type, game_id, prize_id, trans_id, type, credits, is_deleted, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'trans' => array(self::BELONGS_TO, 'GamingTransaction', 'trans_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'prize' => array(self::BELONGS_TO, 'Prize', 'prize_id'),
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
			'game_type' => 'Game Type',
			'game_id' => 'Game',
			'prize_id' => 'Prize',
			'trans_id' => 'Trans',
			'type' => 'Type',
			'credits' => 'Credits',
			'is_deleted' => 'Is Deleted',
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
		$criteria->compare('game_type',$this->game_type,true);
		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('prize_id',$this->prize_id,true);
		$criteria->compare('trans_id',$this->trans_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('credits',$this->credits,true);
		$criteria->compare('is_deleted',$this->is_deleted);
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
	 * @return CreditTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
