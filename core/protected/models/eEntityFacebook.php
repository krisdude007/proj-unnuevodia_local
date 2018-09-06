<?php

class eEntityFacebook extends EntityFacebook
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id', 'required'),                    
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),                    
			array('entity_id', 'numerical', 'integerOnly'=>true),
			array('facebook_page_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity_id, facebook_page_id, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
