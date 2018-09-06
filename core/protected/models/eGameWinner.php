<?php

/**
 * This is the model class for table "game_winner".
 *
 * The followings are the available columns in table 'game_winner':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $contest_name
 * @property integer $is_deleted
 * @property string $from
 * @property string $to
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eGameWinner extends GameWinner
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, contest_name', 'required'),
			array('user_id, is_deleted', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>5),
			array('contest_name', 'length', 'max'=>50),
			array('from_date, to_date', 'safe'),
			array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			array('id, user_id, type, contest_name, is_deleted, from_date, to_date, created_on, updated_on', 'safe', 'on'=>'search'),
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
                        'userEmail' => array(self::BELONGS_TO, 'UserEmail', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'contest_name' => 'Contest Name',
			'is_deleted' => 'Is Deleted',
			'from_date' => 'From',
			'to_date' => 'To',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
		);
	}

        public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'deleted' => array(
                'condition' => "is_deleted = '1'"
            ),
            'week' => array(
                'condition' => "type = 'week'"
            ),
            'month' => array(
                'condition' => "type = 'month'"
            ),
            'notdeleted' => array(
                'condition' => "is_deleted = '0'"
            ),
            'orderByCreatedDesc' => array(
                'order' => '`t`.created_on DESC',
            ),
            'orderByCreatedAsc' => array(
                'order' => '`t`.created_on ASC',
            ),
            'orderByIDDesc' => array(
                'order' => '`t`.id DESC',
            ),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('contest_name',$this->contest_name,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('from_date',$this->from_date,true);
		$criteria->compare('to_date',$this->to_date,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('updated_on',$this->updated_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GameWinner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
