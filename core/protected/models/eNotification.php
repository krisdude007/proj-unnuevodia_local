<?php

/**
 * This is the model class for table "eNotification".
 *
 * The followings are the available columns in table 'notification':
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property string $url
 * @property string $created_on
 * @property string $updated_on
 *
 * The followings are the available model relations:
 * @property User $user
 */
class eNotification extends Notification {

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notification the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'orderDesc' => array('order' => 't.created_on desc'),
        );
    }

    public static function notify($user_id = false, $message = '', $url = '') {
        $model = new self();
        $model->user_id = $user_id;
        $model->message = $message;
        $model->url = $url;
        $model->created_on = date("Y-m-d H:i:s");
        $model->updated_on = date("Y-m-d H:i:s");

        if ($model->validate()) {
            $model->save(false);
            return true;
        }

        return false;
    }

}

