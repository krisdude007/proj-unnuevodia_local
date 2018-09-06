<?php

/**
 * This is the model class for table "SweepStakeUser".
 *
 * The followings are the available columns in table 'sweepstake_user':
 * @property integer $id
 * @property integer $sweepstake_id
 * @property integer $user_id
 * @property integer $accepted
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property sweepstake_user[] $sweepstake_id
 * @property User $user
 *
 */

class SweepStakeUser extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SweepStakeUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sweepstake_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sweepstake_id, user_id, accepted, created_on', 'required'),
                        array('sweepstake_id, user_id, accepted', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sweepstake_id, user_id, accepted, created_on', 'safe', 'on'=>'search'),
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
                    'user' => array(self::BELONGS_TO, 'User', 'user_id'),
                    'sweepstake' => array(self::BELONGS_TO, 'SweepStake', 'sweepstake_id'),
		);
	}
        /**
	 * @return array customized attribute labels (name=>label)
	 */

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sweepstake_id' => 'Sweepstake ID',
			'user_id' => 'User',
                        'accepted' => 'Accept',
			'created_on' => 'Created',
		);
	}

        	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sweepstake_id',$this->sweepstake_id,true);
		$criteria->compare('user_id',$this->user_id,true);
                $criteria->compare('accepted',$this->accepted,true);
		$criteria->compare('created_on',$this->created_on!==null?gmdate("Y-m-d H:i:s",strtotime($this->created_on)):null);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>
