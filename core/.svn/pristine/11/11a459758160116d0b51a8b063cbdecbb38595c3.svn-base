<?php
class eVideoRating extends VideoRating
{
    	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_id, user_id, rating', 'required'),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),
			array('video_id, user_id, rating', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, video_id, user_id, rating, created, ts', 'safe', 'on'=>'search'),
		);
	}
}