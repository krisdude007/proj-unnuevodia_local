<?php

/**
 * This is the model class for table "ticker_run".
 *
 * The followings are the available columns in table 'ticker_run':
 * @property integer $id
 * @property integer $ticker_id
 * @property integer $user_id
 * @property integer $web_runs
 * @property integer $mobile_runs
 * @property integer $tv_runs
 * @property integer $web_ran
 * @property integer $mobile_ran
 * @property integer $tv_ran
 * @property integer $stopped
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Ticker $ticker
 * @property User $user
 */
class TickerRun extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticker_run';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ticker_id, user_id, web_runs, mobile_runs, tv_runs, web_ran, mobile_ran, tv_ran, created_on', 'required'),
			array('ticker_id, user_id, web_runs, mobile_runs, tv_runs, web_ran, mobile_ran, tv_ran, stopped', 'numerical', 'integerOnly'=>true),
			array('updated_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ticker_id, user_id, web_runs, mobile_runs, tv_runs, web_ran, mobile_ran, tv_ran, stopped, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'ticker' => array(self::BELONGS_TO, 'Ticker', 'ticker_id'),
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
			'ticker_id' => 'Ticker',
			'user_id' => 'User',
			'web_runs' => 'Web Runs',
			'mobile_runs' => 'Mobile Runs',
			'tv_runs' => 'Tv Runs',
			'web_ran' => 'Web Ran',
			'mobile_ran' => 'Mobile Ran',
			'tv_ran' => 'Tv Ran',
			'stopped' => 'Stopped',
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
		$criteria->compare('ticker_id',$this->ticker_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('web_runs',$this->web_runs);
		$criteria->compare('mobile_runs',$this->mobile_runs);
		$criteria->compare('tv_runs',$this->tv_runs);
		$criteria->compare('web_ran',$this->web_ran);
		$criteria->compare('mobile_ran',$this->mobile_ran);
		$criteria->compare('tv_ran',$this->tv_ran);
		$criteria->compare('stopped',$this->stopped);
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
	 * @return TickerRun the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
