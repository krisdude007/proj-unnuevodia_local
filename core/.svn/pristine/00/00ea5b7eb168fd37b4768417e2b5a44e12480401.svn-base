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
			array('user_id, processor, response, item, item_id, description, price', 'required'),
			array('user_id, item_id, raffle_value', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('processor, response, description, item, key', 'length', 'max'=>255),
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, processor, response, item, item_id, description, key, price, raffle_value, created_on, updated_on', 'safe', 'on'=>'search'),
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
                        'response' => array(self::BELONGS_TO, 'GameChoiceResponse', 'item_id'),
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
			'processor' => 'Processor',
                        'response' => 'Response',
                        'item' => 'Item',
                        'item_id' => 'Item ID',
                        'description' => 'Description',
                        'key' => 'Key',
			'price' => 'Price',
                        'raffle_value' => 'Raffle Value',
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
		$criteria->compare('processor',$this->processor,true);
                $criteria->compare('response',$this->response,true);
                $criteria->compare('item',$this->item);
                $criteria->compare('item_id',$this->item_id);
                $criteria->compare('description',$this->description);
                $criteria->compare('key',$this->key);
		$criteria->compare('price',$this->price);
                $criteria->compare('raffle_value',$this->raffle_value);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('updated_on',$this->updated_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function scopes() {
            return array(
                'recent' => array('order' => '`t`.`id` DESC'),
                'asc' => array('order' => '`t`.`id` ASC'),
                'isResponse' => array(
                    'condition' => "response IS NOT NULL",
                ),
                'game' => array(
                    'condition' => "description = 'game_choice_response'",
                ),
                'gameChoice' => array(
                    'condition' => "description = 'game_choice'",
                ),
                'prepay' => array(
                    'condition' => "description = 'prepay'",
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
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
