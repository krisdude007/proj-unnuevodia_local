<?php

/**
 * This is the model class for table "game_reveal".
 *
 * The followings are the available columns in table 'game_reveal':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $grid_w
 * @property string $grid_h
 * @property string $grid_w_squares
 * @property string $grid_h_squares
 * @property string $grid_background
 * @property string $square_color
 * @property integer $control_scale
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property GameRevealGrid[] $gameRevealGrs
 */
class GameReveal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'game_reveal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, grid_w, grid_h, grid_w_squares, grid_h_squares, grid_background, square_color, control_scale, created_on, updated_on', 'required'),
			array('user_id, control_scale, is_active, is_deleted', 'numerical', 'integerOnly'=>true),
			array('title, grid_background', 'length', 'max'=>255),
			array('grid_w, grid_h', 'length', 'max'=>4),
			array('grid_w_squares, grid_h_squares', 'length', 'max'=>3),
			array('square_color', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, title, grid_w, grid_h, grid_w_squares, grid_h_squares, grid_background, square_color, control_scale, is_active, is_deleted, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'gameRevealGrs' => array(self::HAS_MANY, 'GameRevealGrid', 'reveal_id'),
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
			'title' => 'Title',
			'grid_w' => 'Grid W',
			'grid_h' => 'Grid H',
			'grid_w_squares' => 'Grid W Squares',
			'grid_h_squares' => 'Grid H Squares',
			'grid_background' => 'Grid Background',
			'square_color' => 'Square Color',
			'control_scale' => 'Control Scale',
			'is_active' => 'Is Active',
			'is_deleted' => 'Is Deleted',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('grid_w',$this->grid_w,true);
		$criteria->compare('grid_h',$this->grid_h,true);
		$criteria->compare('grid_w_squares',$this->grid_w_squares,true);
		$criteria->compare('grid_h_squares',$this->grid_h_squares,true);
		$criteria->compare('grid_background',$this->grid_background,true);
		$criteria->compare('square_color',$this->square_color,true);
		$criteria->compare('control_scale',$this->control_scale);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_deleted',$this->is_deleted);
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
	 * @return GameReveal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
