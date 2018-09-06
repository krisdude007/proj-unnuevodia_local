<?php

/**
 * This is the model class for table "image_destination".
 *
 * The followings are the available columns in table 'image_destination':
 * @property integer $id
 * @property integer $image_id
 * @property integer $user_id
 * @property integer $destination_id
 * @property string $response
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property Destination $destination
 * @property Image $image
 * @property User $user
 */
class eImageDestination extends ImageDestination {

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ImageDestination the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image_id, user_id, destination_id, response', 'required'),
            array('image_id, user_id, destination_id', 'numerical', 'integerOnly'=>true),
            array('response', 'length', 'max'=>255),
            array('created_on, updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, image_id, user_id, destination_id, response, created_on, updated_on', 'safe', 'on'=>'search'),
        );
    }

}