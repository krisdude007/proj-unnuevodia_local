<?php

/**
 * This is the model class for table "prize".
 *
 * The followings are the available columns in table 'prize':
 * @property string $id
 * @property string $question_id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $quantity
 * @property string $credits_required
 * @property double $market_value
 * @property string $sponsor
 * @property integer $enabled
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class ePrize extends Prize {

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Prize the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name, quantity, credits_required, enabled, created_on, updated_on', 'required'),
            array('image', 'required', 'on' => 'insert'),
            array('user_id, enabled', 'numerical', 'integerOnly' => true),
            array('market_value', 'numerical'),
            array('type', 'length', 'max'=>7),
            array('question_id', 'safe'),
            array('image', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'),
            array('name, sponsor', 'length', 'max' => 32),
            array('description, image', 'length', 'max' => 255),
            array('quantity, credits_required', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, question_id, user_id, name, description, image, type, quantity, credits_required, market_value, sponsor, enabled, created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    public static function getActivePrizes() {
        return self::model()->isActive()->hasQuantity()->findAll();
    }

    public function scopes() {
        return array(
            'isActive' => array(
                'condition' => "enabled = 1"
            ),
            'hasQuantity' => array(
                'condition' => "quantity >= 1"
            ),
        );
    }

}
