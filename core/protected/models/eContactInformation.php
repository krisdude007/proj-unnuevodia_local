<?php

/**
 * This is the model class for table "contact_information".
 *
 * The followings are the available columns in table 'contact_information':
 * @property integer $id
 * @property string $attribute
 * @property string $description
 */
class eContactInformation extends ContactInformation
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute, description', 'required'),
			array('attribute, description', 'length', 'max'=>255),
                        array('value','length','max'=>1000),
                        array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, attribute, description, value', 'safe', 'on'=>'search'),
		);
	}
}
