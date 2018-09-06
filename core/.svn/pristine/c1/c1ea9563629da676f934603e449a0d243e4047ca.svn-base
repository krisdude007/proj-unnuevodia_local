<?php

/**
 * This is the model class for table "question_destination".
 *
 * The followings are the available columns in table 'question_destination':
 * @property integer $id
 * @property integer $question_id
 * @property integer $user_id
 * @property integer $destination_id
 * @property string $response
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Destination $destination
 * @property Question $question
 * @property User $user
 */
class eQuestionDestination extends QuestionDestination
{

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id, user_id, destination_id, response', 'required'),
			array('question_id, user_id, destination_id', 'numerical', 'integerOnly'=>true),
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			array('response', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question_id, user_id, destination_id, response, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}
}
