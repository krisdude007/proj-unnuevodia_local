<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $role
 * @property string $birthday
 * @property string $gender
 * @property string $first_name
 * @property string $last_name
 * @property integer $terms_accepted
 * @property string $source
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Audit[] $audits
 * @property Image[] $images
 * @property Image[] $images1
 * @property ImageDestination[] $imageDestinations
 * @property ImageRating[] $imageRatings
 * @property ImageView[] $imageViews
 * @property LanguageFilter[] $languageFilters
 * @property Notification[] $notifications
 * @property Poll[] $polls
 * @property PollAnswer[] $pollAnswers
 * @property PollResponse[] $pollResponses
 * @property Question[] $questions
 * @property QuestionDestination[] $questionDestinations
 * @property Ticker[] $tickers
 * @property Ticker[] $tickers1
 * @property TickerDestination[] $tickerDestinations
 * @property TickerImpression[] $tickerImpressions
 * @property TickerRun[] $tickerRuns
 * @property UserEmail[] $userEmails
 * @property UserFacebook[] $userFacebooks
 * @property UserLocation[] $userLocations
 * @property UserLogin[] $userLogins
 * @property UserPermission[] $userPermissions
 * @property UserPhone[] $userPhones
 * @property UserPhoto[] $userPhotos
 * @property UserReset[] $userResets
 * @property UserTech[] $userTeches
 * @property UserTwitter[] $userTwitters
 * @property Video[] $videos
 * @property Video[] $videos1
 * @property VideoDestination[] $videoDestinations
 * @property VideoRating[] $videoRatings
 * @property VideoView[] $videoViews
 */
class User extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, salt, birthday, gender, first_name, last_name, terms_accepted, source, created_on, updated_on', 'required'),
			array('terms_accepted', 'numerical', 'integerOnly'=>true),
			array('username, password, salt, first_name, last_name, source', 'length', 'max'=>255),
			array('role', 'length', 'max'=>14),
			array('gender', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, salt, role, birthday, gender, first_name, last_name, terms_accepted, source, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'audits' => array(self::HAS_MANY, 'Audit', 'user_id'),
			'images' => array(self::HAS_MANY, 'Image', 'user_id'),
			'images1' => array(self::HAS_MANY, 'Image', 'arbitrator_id'),
			'imageDestinations' => array(self::HAS_MANY, 'ImageDestination', 'user_id'),
			'imageRatings' => array(self::HAS_MANY, 'ImageRating', 'user_id'),
			'imageViews' => array(self::HAS_MANY, 'ImageView', 'user_id'),
			'languageFilters' => array(self::HAS_MANY, 'LanguageFilter', 'user_id'),
			'notifications' => array(self::HAS_MANY, 'Notification', 'user_id'),
			'polls' => array(self::HAS_MANY, 'Poll', 'user_id'),
			'pollAnswers' => array(self::HAS_MANY, 'PollAnswer', 'user_id'),
			'pollResponses' => array(self::HAS_MANY, 'PollResponse', 'user_id'),
			'questions' => array(self::HAS_MANY, 'Question', 'user_id'),
			'questionDestinations' => array(self::HAS_MANY, 'QuestionDestination', 'user_id'),
			'tickers' => array(self::HAS_MANY, 'Ticker', 'user_id'),
			'tickers1' => array(self::HAS_MANY, 'Ticker', 'arbitrator_id'),
			'tickerDestinations' => array(self::HAS_MANY, 'TickerDestination', 'user_id'),
			'tickerImpressions' => array(self::HAS_MANY, 'TickerImpression', 'user_id'),
			'tickerRuns' => array(self::HAS_MANY, 'TickerRun', 'user_id'),
			'userEmails' => array(self::HAS_MANY, 'UserEmail', 'user_id'),
			'userFacebooks' => array(self::HAS_MANY, 'UserFacebook', 'user_id'),
			'userLocations' => array(self::HAS_MANY, 'UserLocation', 'user_id'),
			'userLogins' => array(self::HAS_MANY, 'UserLogin', 'user_id'),
			'userPermissions' => array(self::HAS_MANY, 'UserPermission', 'user_id'),
			'userPhones' => array(self::HAS_MANY, 'UserPhone', 'user_id'),
			'userPhotos' => array(self::HAS_MANY, 'UserPhoto', 'user_id'),
			'userResets' => array(self::HAS_MANY, 'UserReset', 'user_id'),
			'userTeches' => array(self::HAS_MANY, 'UserTech', 'user_id'),
			'userTwitters' => array(self::HAS_MANY, 'UserTwitter', 'user_id'),
			'videos' => array(self::HAS_MANY, 'Video', 'user_id'),
			'videos1' => array(self::HAS_MANY, 'Video', 'arbitrator_id'),
			'videoDestinations' => array(self::HAS_MANY, 'VideoDestination', 'user_id'),
			'videoRatings' => array(self::HAS_MANY, 'VideoRating', 'user_id'),
			'videoViews' => array(self::HAS_MANY, 'VideoView', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'salt' => 'Salt',
			'role' => 'Role',
			'birthday' => 'Birthday',
			'gender' => 'Gender',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'terms_accepted' => 'Terms Accepted',
			'source' => 'Source',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('birthday',$this->birthday!==null?gmdate("Y-m-d",strtotime($this->birthday)):null);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('terms_accepted',$this->terms_accepted);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('created_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->created_on)):null);
		$criteria->compare('updated_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->updated_on)):null);

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
