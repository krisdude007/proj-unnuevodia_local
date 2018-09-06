<?php

class eTransaction extends Transaction {

    public $amount;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
