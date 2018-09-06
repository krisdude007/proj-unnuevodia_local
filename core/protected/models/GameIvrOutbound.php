<?php

/**
 * This is the model class for table "game_ivr_outbound".
 *
 * The followings are the available columns in table 'game_ivr_outbound':
 * @property integer $id
 * @property string $guid
 * @property string $opid
 * @property string $shortcode
 * @property string $phonenumber
 * @property string $pincode
 * @property integer $reset
 * @property integer $duration
 * @property integer $gameplay
 * @property string $return_value
 * @property string $created_on
 */
class GameIvrOutbound extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'game_ivr_outbound';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guid, opid, shortcode, phonenumber, duration, return_value, created_on', 'required'),
			array('reset, duration, gameplay', 'numerical', 'integerOnly'=>true),
			array('guid, return_value', 'length', 'max'=>255),
			array('opid, shortcode, phonenumber', 'length', 'max'=>20),
			array('pincode', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, guid, opid, shortcode, phonenumber, pincode, reset, duration, gameplay, return_value, created_on', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'guid' => 'Guid',
			'opid' => 'Opid',
			'shortcode' => 'Shortcode',
			'phonenumber' => 'Phonenumber',
			'pincode' => 'Pincode',
			'reset' => 'Reset',
			'duration' => 'Duration',
			'gameplay' => 'Gameplay',
			'return_value' => 'Return Value',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('opid',$this->opid,true);
		$criteria->compare('shortcode',$this->shortcode,true);
		$criteria->compare('phonenumber',$this->phonenumber,true);
		$criteria->compare('pincode',$this->pincode,true);
		$criteria->compare('reset',$this->reset);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('gameplay',$this->gameplay);
		$criteria->compare('return_value',$this->return_value,true);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameIvrOutbound the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
