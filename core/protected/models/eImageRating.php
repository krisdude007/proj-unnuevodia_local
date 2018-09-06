<?php

/**
 * This is the model class for table "image_rating".
 *
 * The followings are the available columns in table 'image_rating':
 * @property integer $id
 * @property integer $image_id
 * @property integer $user_id
 * @property integer $rating
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Image $image
 */
class eImageRating extends ImageRating {

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ImageRating the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image_id, user_id, rating', 'required'),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            array('image_id, user_id, rating', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, image_id, user_id, rating, created, ts', 'safe', 'on' => 'search'),
        );
    }

}