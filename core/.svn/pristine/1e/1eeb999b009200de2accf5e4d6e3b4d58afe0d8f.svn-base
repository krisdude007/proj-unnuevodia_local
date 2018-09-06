<?php

 
class eCampaignPackage extends ActiveRecord
{
     
	 
	public function tableName()
	{
		return 'campaign_package';
	}

	 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, package_name, facebook_post_count, twitter_post_count, price', 'safe'),
	 	);
	}
	
	 
	 
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

 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        
		$criteria->compare('id',$this->id);
		 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	 
}
