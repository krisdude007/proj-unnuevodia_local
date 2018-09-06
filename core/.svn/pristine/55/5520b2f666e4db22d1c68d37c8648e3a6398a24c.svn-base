<?php

class eGameChoiceSmsOutbound extends GameChoiceSmsOutbound {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('smsid, opid, destination, smssender, smstext, idlang, return_value, created_on', 'required'),
            array('smsid', 'unique'),
            array('smssender, destination, opid', 'numerical'),
            array('opid, destination', 'length', 'max' => 11),
            array('smssender', 'length', 'max' => 20),
            array('idlang', 'in', 'range' => array('0', '1'), 'allowEmpty' => false),
            array('smstext, smsdecodetext', 'length', 'max' => 512),
            array('return_value', 'length', 'max' => 255),
            array('created_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, smsid, opid, destination, smssender, smstext, smsdecodetext, idlang, return_value, created_on', 'safe', 'on' => 'search'),
        );
    }

}
