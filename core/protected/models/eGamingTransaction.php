<?php

class eGamingTransaction extends GamingTransaction {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'recent' => array('order' => '`t`.`id` desc'),
        );
    }

}
