<?php

class eEntityResponse extends EntityResponse
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_answer_id, user_id, source', 'required'),
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),                                        
			array('entity_id, user_id', 'numerical', 'integerOnly'=>true),
			array('source, source_content_id, source_user_id', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity_answer_id, user_id, source, source_content_id, source_user_id, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
