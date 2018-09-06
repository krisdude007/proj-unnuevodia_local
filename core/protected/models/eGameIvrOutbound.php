<?php

class eGameIvrOutbound extends GameIvrOutbound
{
	public static function model($className = __CLASS__) {
        return parent::model($className);
    }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guid, opid, shortcode, phonenumber, pincode, duration, return_value, created_on', 'required'),
                        array('guid', 'unique'),
			array('reset, duration, gameplay', 'numerical', 'integerOnly'=>true),
			array('guid, return_value', 'length', 'max'=>255),
			array('opid, shortcode, phonenumber', 'length', 'max'=>20),
			array('pincode', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, guid, opid, shortcode, phonenumber, pincode, reset, duration, gameplay, return_value, created_on', 'safe', 'on'=>'search'),
		);
	}

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

        public function scopes() {
            return array(
                'recent' => array('order' => '`t`.`id` desc'),
                );
        }
}
