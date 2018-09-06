<?php

/**
 *
 *
 * * @property string $active
 */
class eSweepStake extends SweepStake {

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('start_date, end_date', 'required', 'on' => 'insert'),
            array('created_on,updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'insert'),
            array('updated_on', 'default', 'value' => date("Y-m-d H:i:s"), 'setOnEmpty' => false, 'on' => 'update'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, start_date, end_date,created_on, updated_on', 'safe', 'on' => 'search'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function scopes() {
        return array(
            'current' => array('condition' => "NOW() between start_date and end_date"),
        );
    }

}
