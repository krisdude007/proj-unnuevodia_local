<?php

/**
 * This is the model class for table "entity".
 *
 * The followings are the available columns in table 'entity':
 * @property integer $id
 * @property integer $active
 * @property string $type
 * @property string $name
 * @property string $link
 * @property string $description
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property EntityFacebook[] $entityFacebooks
 * @property EntityResponse[] $entityResponses
 * @property EntityTwitter[] $entityTwitters
 * @property Image[] $images
 * @property Ticker[] $tickers
 */
class Entity extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active, type, name, link, description, created_on, updated_on', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('type, name, link', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, active, type, name, link, description, created_on, updated_on', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'entityFacebooks' => array(self::HAS_MANY, 'EntityFacebook', 'entity_id'),
			'entityResponses' => array(self::HAS_MANY, 'EntityResponse', 'entity_id'),
			'entityTwitters' => array(self::HAS_MANY, 'EntityTwitter', 'entity_id'),
			'images' => array(self::HAS_MANY, 'Image', 'entity_id'),
			'tickers' => array(self::HAS_MANY, 'Ticker', 'entity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'active' => 'Active',
			'type' => 'Type',
			'name' => 'Name',
			'link' => 'Link',
			'description' => 'Description',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('active',$this->active);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->created_on)):null);
		$criteria->compare('updated_on',$this->updated_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->updated_on)):null);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
