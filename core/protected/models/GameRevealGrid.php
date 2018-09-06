<?php

/**
 * This is the model class for table "game_reveal_grid".
 *
 * The followings are the available columns in table 'game_reveal_grid':
 * @property integer $id
 * @property integer $user_id
 * @property integer $reveal_id
 * @property string $grid_section
 * @property integer $is_shown
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property GameReveal $reveal
 * @property User $user
 */
class GameRevealGrid extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'game_reveal_grid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('grid_section, created_on, updated_on', 'required'),
			array('user_id, reveal_id, is_shown', 'numerical', 'integerOnly'=>true),
			array('grid_section', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, reveal_id, grid_section, is_shown, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'reveal' => array(self::BELONGS_TO, 'GameReveal', 'reveal_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
			'reveal_id' => 'Reveal',
			'grid_section' => 'Grid Section',
			'is_shown' => 'Is Shown',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('reveal_id',$this->reveal_id);
		$criteria->compare('grid_section',$this->grid_section,true);
		$criteria->compare('is_shown',$this->is_shown);
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
	 * @return GameRevealGrid the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
