<?php

/**
 * This is the model class for table "prize".
 *
 * The followings are the available columns in table 'prize':
 * @property string $id
 * @property integer $question_id
 * @property integer $user_id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $quantity
 * @property string $credits_required
 * @property double $market_value
 * @property string $sponsor
 * @property integer $enabled
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property CreditTransaction[] $creditTransactions
 * @property Question $question
 * @property User $user
 * @property Ticker[] $tickers
 */
class Prize extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prize';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, name, image, quantity, credits_required, enabled, created_on, updated_on', 'required'),
			array('question_id, user_id, enabled', 'numerical', 'integerOnly'=>true),
			array('market_value', 'numerical'),
			array('type', 'length', 'max'=>7),
			array('name, sponsor', 'length', 'max'=>32),
			array('description, image', 'length', 'max'=>255),
			array('quantity, credits_required', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question_id, user_id, type, name, description, image, quantity, credits_required, market_value, sponsor, enabled, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'creditTransactions' => array(self::HAS_MANY, 'CreditTransaction', 'prize_id'),
			'question' => array(self::BELONGS_TO, 'Question', 'question_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'tickers' => array(self::HAS_MANY, 'Ticker', 'prize_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question_id' => 'Question',
			'user_id' => 'User',
			'type' => 'Type',
			'name' => 'Name',
			'description' => 'Description',
			'image' => 'Image',
			'quantity' => 'Quantity',
			'credits_required' => 'Credits Required',
			'market_value' => 'Market Value',
			'sponsor' => 'Sponsor',
			'enabled' => 'Enabled',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('credits_required',$this->credits_required,true);
		$criteria->compare('market_value',$this->market_value);
		$criteria->compare('sponsor',$this->sponsor,true);
		$criteria->compare('enabled',$this->enabled);
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
	 * @return Prize the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
