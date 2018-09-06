<?php

/**
 * This is the model class for table "postal_code".
 *
 * The followings are the available columns in table 'postal_code':
 * @property integer $id
 * @property string $identifier
 * @property string $latitude
 * @property string $longitude
 * @property string $city
 * @property string $state
 * @property string $county
 * @property string $type
 * @property string $income
 * @property string $last_checked_on
 * @property string $created_on
 * @property string $updated_on
 */
class ePostalCode extends PostalCode
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
        );
    }
}