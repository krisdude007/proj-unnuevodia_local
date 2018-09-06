<?php

class eEntity extends Entity
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('name, type','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),                    
			array('name, link', 'required'),
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),                    
                        array('active', 'numerical', 'integerOnly'=>true),
			array('name, link, type', 'length', 'max'=>255),
                        array('data, description', 'length', 'max'=>10000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, link, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'entityFacebooks' => array(self::HAS_MANY, 'eEntityFacebook', 'entity_id'),
			'entityResponses' => array(self::HAS_MANY, 'eEntityResponses', 'entity_id'),
			'entityTwitters' => array(self::HAS_MANY, 'eEntityTwitter', 'entity_id'),
			'images' => array(self::HAS_MANY, 'eImage', 'entity_id'),
			'tickers' => array(self::HAS_MANY, 'eTicker', 'entity_id'),
		);
	}
        
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
