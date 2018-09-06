<?php

/**
 * This is the model class for table "content_report".
 *
 * The followings are the available columns in table 'content_report':
 * @property integer $id
 * @property integer $user_id
 * @property integer $content_id
 * @property string $content_tbl
 * @property string $issue
 * @property integer $is_accepted
 * @property integer $is_denied
 * @property integer $is_deleted
 * @property integer $admin_id
 * @property string $created_on
 * @property string $updated_on
 */
class eContentReport extends ContentReport
{
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('user_id', 'default', 'value' => Yii::app()->user->getId()),
			array('user_id, content_id, content_tbl', 'required'),
			array('id, user_id, content_id, is_accepted, is_denied, is_deleted, admin_id', 'numerical', 'integerOnly'=>true),
			array('content_tbl', 'length', 'max'=>32),
			array('issue', 'length', 'max'=>20),
			array('is_accepted, is_denied, is_deleted', 'default', 'value' => 0),
                        array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			array('id, user_id, content_id, content_tbl, issue, is_accepted, is_denied, is_deleted, admin_id, created_on, updated_on', 'safe', 'on'=>'search'),
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
                    'userAdmin' => array(self::BELONGS_TO, 'User', 'admin_id'),
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
			'content_id' => 'Content',
			'content_tbl' => 'Content Tbl',
			'issue' => 'Issue',
			'is_accepted' => 'Is Accepted',
			'is_denied' => 'Is Denied',
			'is_deleted' => 'Is Deleted',
			'admin_id' => 'Admin',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
		);
	}

        public function scopes() {
            return array(
                'recent' => array('order' => '`t`.`id` DESC'),
                'isDeleted' => array(
                    'condition' => "is_deleted = '1'"
                ),
                'isNotDeleted' => array(
                    'condition' => "is_deleted = '0'"
                ),
                'isAccepted' => array(
                    'condition' => "is_accepted = '1'"
                ),
                'isNotAccepted' => array(
                    'condition' => "is_accepted = '0'"
                ),
                'isDenied' => array(
                    'condition' => "is_denied = '1'"
                ),
                'isNotDenied' => array(
                    'condition' => "is_denied = '0'"
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
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('content_tbl',$this->content_tbl,true);
		$criteria->compare('issue',$this->issue,true);
		$criteria->compare('is_accepted',$this->is_accepted);
		$criteria->compare('is_denied',$this->is_denied);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('admin_id',$this->admin_id);
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
	 * @return ContentReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
