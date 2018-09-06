<?php

class FormSendSMS extends CFormModel {

    public $user_id;
    public $phone;
    public $message;
    
    public function rules() {
        return array(
            array('message', 'required'),
            array('user_id, phone', 'numerical', 'integerOnly' => true),
            array('message', 'length', 'max' => 160),
            array('user_id, phone, message', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User ID',
            'phone' => 'Phone Number',
            'message' => 'Message',
        );
    }

}
