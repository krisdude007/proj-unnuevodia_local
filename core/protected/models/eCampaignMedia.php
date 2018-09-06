<?php

/**
 * This is the model class for table "campaign".
 * 
 */
class eCampaignMedia extends ActiveRecord
{
    public $media_file;
     
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'campaign_media';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('media_name, media_type', 'required'),
			array('media_file', 'file', 'types'=>'jpg, gif, png, mov, mp4', 'on'=>'insert'),
			array('media_file', 'required', 'on'=>'insert'),
			array('media_file', 'file', 'types'=>'jpg, gif, png, mov, mp4', 'allowEmpty'=>true, 'on'=>'update'),
			array('media_url, hash', 'safe'),
			array('media_name, media_type', 'safe', 'on'=>'search'),
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
		     
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			 
			 
		);
	}
	
	public function beforeSave()
	{
	    parent::beforeSave();
	    if($this->isNewRecord) {
	        $this->hash = md5(uniqid().$this->media_name.$this->media_url);
	    }
	    return true;
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
		$criteria->compare('media_name',$this->media_name);
		$criteria->compare('media_type', $this->media_type);
		 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	 
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
