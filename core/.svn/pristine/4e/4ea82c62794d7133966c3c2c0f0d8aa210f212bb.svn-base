<?php

class FormFilterVideoScheduler extends CFormModel {

    public $show;
    public $date;

    public function rules() {

        return array(
            array('show', 'required'),
            array('show', 'numerical', 'integerOnly' => true),
            array('date', 'checkDate'),
        );

        return $rules;
    }
    
    public function checkDate($attribute, $params) {
        if (!$this->hasErrors()) {
            if (strtotime($this->dateStart) > strtotime($this->dateStop))
                //$this->addError($attribute, '"From" date should be lest than than or equal to To date.');
                Yii::app()->user->setFlash('error', '"From" date should be lest than than or equal to To date.');
        }
    }


    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'show' => 'Show',
            'date' => 'Date',
        );
    }

}