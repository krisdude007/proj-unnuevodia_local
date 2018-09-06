<?php

class FormFilterTicker extends CFormModel {

    public $question;
    public $status;
    public $perPage;

    public function rules() {

        return array(
            array('question, status, perPage', 'required'),
            array('question', 'numerical', 'integerOnly' => true),
        );

        return $rules;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'question' => 'Question',
            'status' => 'Status',
            'dateStart' => 'From',
            'perPage' => 'Items per page'
        );
    }

}
