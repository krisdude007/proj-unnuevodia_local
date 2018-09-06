<?php

/**
 * This is the model class for table "credit_transaction".
 *
 * The followings are the available columns in table 'credit_transaction':
 * @property integer $id
 * @property integer $user_id
 * @property string $game_type
 * @property integer $game_id
 * @property string $prize_id
 * @property integer $trans_id
 * @property string $type
 * @property string $credits
 * @property integer $is_deleted
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eCreditTransaction extends CreditTransaction {

    public $sum;
    public $total_plays;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'default', 'value' => Yii::app()->user->getId()),
            array('user_id, type, credits', 'required'),
            array('user_id, game_id, prize_id, trans_id, credits, is_deleted', 'numerical', 'integerOnly' => true),
            array('game_type', 'length', 'max' => 24),
            array('type', 'length', 'max' => 12),
            array('credits', 'length', 'max' => 11),
            array('is_deleted', 'default', 'value' => 0),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('id, user_id, game_type, game_id, prize_id, type, credits, is_deleted, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'game_type' => 'Game Type',
            'game_id' => 'Game',
            'prize_id' => 'Prize',
            'type' => 'Type',
            'credits' => 'Credits',
            'is_deleted' => 'Is Deleted',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        );
    }

    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` DESC'),
            'notDeleted' => array(
                'condition' => "is_deleted = '0'"
            ),
            'isDeleted' => array(
                'condition' => "is_deleted = '1'"
            ),
            'earned' => array(
                'condition' => "type = 'earned'"
            ),
            'purchased' => array(
                'condition' => "type = 'purchased'"
            ),
            'spent' => array(
                'condition' => $this->getTableAlias().".type = 'spent'"
            ),
            'gameChoice' => array(
                'condition' => "game_type = 'game_choice'"
            ),
            'productPurchase' => array(
                'condition' => "game_type = 'product_purchase'"
            ),
            'gameReveal' => array(
                'condition' => "game_type = 'game_reveal'"
            ),
        );
    }



    public static function getUserTransactions($user_id) {
        return self::model()->recent()->notDeleted()->findAllByAttributes(array('user_id' => $user_id));
    }

    public static function getUserEarnedTransactions($user_id) {
        return self::model()->recent()->notDeleted()->earned()->findAllByAttributes(array('user_id' => $user_id));
    }

    public static function getUserSpentTransactions($user_id) {
        return self::model()->recent()->notDeleted()->spent()->findAllByAttributes(array('user_id' => $user_id));
    }

    public function beforeSave() {
        $balance = eCreditBalance::model()->findByAttributes(array('user_id' => $this->user_id));

        if ($balance == NULL) {
            $balance = new eCreditBalance();
            $balance->user_id = $this->user_id;
            $balance->credits = 0;
            $balance->earned = 0;
            $balance->spent = 0;
        }

        if ($this->type == 'earned') {
            $balance->credits = $balance->credits + $this->credits;
            $balance->earned = $balance->earned + $this->credits;
        } else {
            $balance->credits = $balance->credits - $this->credits;
            $balance->spent = $balance->spent + $this->credits;
        }

        $balance->save();

        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CreditTransaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public static function getSpentCreditTransactions() {
        $with = array('user','prize','trans');
        return self::model()->with($with)->spent()->notDeleted()->recent()->findAll();
    }

}
