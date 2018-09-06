<?php

/**
 * This is the model class for table "ticker_destination".
 *
 * The followings are the available columns in table 'ticker_destination':
 * @property integer $id
 * @property integer $ticker_id
 * @property integer $user_id
 * @property integer $destination_id
 * @property string $response
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Ticker $ticker
 * @property User $user
 * @property Destination $destination
 */
class eTickerDestination extends TickerDestination
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ticker_id, user_id, destination_id, response', 'required'),
			array('ticker_id, user_id, destination_id', 'numerical', 'integerOnly'=>true),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),                    
			array('response', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ticker_id, user_id, destination_id, response, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TickerDestination the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticker_destination';
	}

	
}