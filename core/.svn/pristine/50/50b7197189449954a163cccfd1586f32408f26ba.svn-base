<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property integer $id
 * @property integer $user_id
 * @property integer $video_id
 * @property integer $image_id
 * @property string $processor
 * @property string $txn_id
 * @property string $order_id
 * @property string $txn_status
 * @property double $price
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Image $image
 * @property User $user
 * @property Video $video
 */
class Transaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, processor, txn_id, order_id, txn_status, price, created_on, updated_on', 'required'),
			array('user_id, video_id, image_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('processor, order_id, txn_status', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, video_id, image_id, processor, txn_id, order_id, txn_status, price, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'image' => array(self::BELONGS_TO, 'Image', 'image_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'video' => array(self::BELONGS_TO, 'Video', 'video_id'),
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
			'video_id' => 'Video',
			'image_id' => 'Image',
			'processor' => 'Processor',
			'txn_id' => 'Txn',
			'order_id' => 'Order',
			'txn_status' => 'Txn Status',
			'price' => 'Price',
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
		$criteria->compare('video_id',$this->video_id);
		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('processor',$this->processor,true);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('txn_status',$this->txn_status,true);
		$criteria->compare('price',$this->price);
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
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
