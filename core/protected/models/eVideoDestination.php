<?php

/**
 * This is the model class for table "video_destination".
 *
 * The followings are the available columns in table 'video_destination':
 * @property integer $id
 * @property integer $video_id
 * @property integer $user_id
 * @property integer $destination_id
 * @property string $response
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Video $video
 * @property User $user
 * @property Destination $destination
 */
class eVideoDestination extends VideoDestination
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'video_destination';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_id, user_id, destination_id, response', 'required'),
			array('video_id, user_id, destination_id', 'numerical', 'integerOnly'=>true),
			array('response', 'length', 'max'=>255),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"),'setOnEmpty'=>false,'on' => 'update'),                                        
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, video_id, user_id, destination_id, response, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VideoDestination the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
