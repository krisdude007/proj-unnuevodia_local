<?php

class eEntityAnswer extends EntityAnswer
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poll_id, user_id, eliminated', 'required'),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
			array('poll_id, user_id, entity_id, eliminated', 'numerical', 'integerOnly'=>true),
			array('hashtag', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, poll_id, user_id, entity_id, eliminated, hashtag, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

        public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ePoll' => array(self::BELONGS_TO, 'ePoll', 'poll_id'),
			'eUser' => array(self::BELONGS_TO, 'eUser', 'user_id'),
			'eEntity' => array(self::BELONGS_TO, 'eEntity', 'entity_id'),
			'entityResponses' => array(self::HAS_MANY, 'eEntityResponse', 'entity_answer_id'),
                        'contest' => array(self::BELONGS_TO, 'ePoll', 'poll_id', 'on' => 'contest.id is not null', 'joinType'=>'INNER JOIN'),
		);
	}
        
        public function scopes() {
            return array(
                'orderNotEliminatedASC' => array('order' => 'eliminated = 1'),
            );
        }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
