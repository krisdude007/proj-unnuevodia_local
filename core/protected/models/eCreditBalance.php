<?php

/**
 * This is the model class for table "credit_balance".
 *
 * The followings are the available columns in table 'credit_balance':
 * @property integer $id
 * @property integer $user_id
 * @property string $credits
 * @property string $earned
 * @property string $spent
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eCreditBalance extends CreditBalance
{
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('user_id', 'default', 'value' => Yii::app()->user->getId()),
			array('user_id', 'required'),
			array('user_id, credits, earned, spent', 'numerical', 'integerOnly'=>true),
			array('credits, earned, spent', 'length', 'max'=>11),
			array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
                        array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
			array('id, user_id, credits, earned, spent, created_on, updated_on', 'safe', 'on'=>'search'),
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
			'credits' => 'Credits',
                        'earned' => 'Earned',
                        'spent' => 'Spent',
			'created_on' => 'Created On',
			'updated_on' => 'Updated On',
		);
	}

        
        public static function getTotalUserBalance($user_id)
        {
            $arr = array('credits_spent' => 0, 'credits_earned' => 0, 'credits_total' => 0);
            $balance = eCreditBalance::model()->findByAttributes(array('user_id' => $user_id));
            
            if(!is_null($balance)) {
                $arr['credits_spent'] = $balance->spent;
                $arr['credits_earned'] = $balance->earned;
                $arr['credits_total'] = $balance->credits;
            }
            return $arr;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CreditBalance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
