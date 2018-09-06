<?php

/**
 * This is the model class for table "ticker_stream".
 *
 * The followings are the available columns in table 'ticker_stream':
 * @property string $id
 * @property integer $ticker_id
 * @property string $destination
 * @property string $created_on
 * @property string $updated_on
 */
class eTickerStream extends TickerStream
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticker_stream';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ticker_id, destination', 'required'),
			array('ticker_id', 'numerical', 'integerOnly'=>true),
			array('destination', 'length', 'max'=>6),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ticker_id, destination, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}
        
        public function scopes(){
            return array(
                'web' => array('condition' => 'destination="web"'),
                'mobile' => array('condition' => 'destination="mobile"'),
                'tv' => array('condition' => 'destination="tv"'),
                'current'=> array('order' => 'id DESC'),
            );            
        }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TickerStream the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
