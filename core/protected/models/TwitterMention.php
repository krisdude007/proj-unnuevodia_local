<?php

/**
 * This is the model class for table "twitter_mention".
 *
 * The followings are the available columns in table 'twitter_mention':
 * @property string $id
 * @property integer $user_id
 * @property string $twitter_user_id
 * @property string $tweet_id
 * @property string $tweet
 * @property integer $payment_received
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class TwitterMention extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'twitter_mention';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, twitter_user_id, tweet_id, tweet, payment_received, created_on', 'required'),
			array('user_id, payment_received', 'numerical', 'integerOnly'=>true),
			array('twitter_user_id, tweet_id', 'length', 'max'=>24),
			array('tweet', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, twitter_user_id, tweet_id, tweet, payment_received created_on', 'safe', 'on'=>'search'),
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
			'twitter_user_id' => 'Twitter User',
			'tweet_id' => 'Tweet',
			'tweet' => 'Tweet',
            'payment_received' => 'Payment Received',
			'created_on' => 'Created On',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('twitter_user_id',$this->twitter_user_id,true);
		$criteria->compare('tweet_id',$this->tweet_id,true);
		$criteria->compare('tweet',$this->tweet,true);
        $criteria->compare('payment_received',$this->payment_received,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TwitterMention the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
