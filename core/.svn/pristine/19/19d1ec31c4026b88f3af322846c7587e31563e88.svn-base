<?php

/**
 * This is the model class for table "campaign".
 * 
 */
class eCampaign extends ActiveRecord
{
    public $hour;
    public $minute;
    public $am;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'campaign';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('campaign_title, show_title, day, show_airing_time, start_date, end_date', 'required'),
			array('hour,minute,am,occurrence,show_info,package, tags, hashtags, status', 'safe'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, campaign_title, show_title, package,show_info, tags, hashtags, connect_facebook, status,connect_twitter, connect_google_plus, connect_youtube, connect_tumblr, show_airing_time, occurrence, day,start_date, end_date, create_time, updated_time, created_by, updated_by', 'safe', 'on'=>'search'),
		);
	}
	
	 
	protected function beforeValidate()
	{
	    parent::beforeValidate();
	    //  for am and pm, 0 is 12
	    if($this->hour == 0) {  
	        $this->hour = 12;   
	    }
	    $this->show_airing_time = date('H:i:s', strtotime('today '.$this->hour.':'.$this->minute.':00 '. $this->am));
	    
	    if($this->isNewRecord) {
	        $this->created_by = Yii::app()->user->id;
	        $this->created_time = date('Y-m-d H:i:s');
	    }  
	    $this->updated_by = Yii::app()->user->id;
	    $this->updated_time = date('Y-m-d H:i:s');
	    return true;
	}
	 
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'posts' => array(SELF::HAS_MANY, 'eCampaignPost', 'id'),
		    'campaign_package'=> array(SELF::HAS_ONE, 'eCampaignPackage', array('package_name'=>'package')),
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
	
	public function getReoccurrenceWeeks()
	{
	    $start = new DateTime($this->start_date);
	    $end = new DateTime($this->end_date);
	    $interval =  $end->diff($start);
	    return ceil($interval->format('%d') / 7);
	}
	
	public function getWeeksArray()
	{
	    $weeks = $this->getReoccurrenceWeeks();
	    $return[1] = '1 week';
	    for( $i=2; $i<= $weeks; $i++) {
	        $return[$i] = $i. ' weeks';
	    }
	    return $return;
	}
}
