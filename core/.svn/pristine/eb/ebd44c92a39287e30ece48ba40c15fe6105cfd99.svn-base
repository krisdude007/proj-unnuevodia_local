<?php

class FormActelTransaction extends CFormModel {

    public $country;
    public $operator;

    public function rules() {

        return array(
            array('country', 'required','message'=>Yii::t('youtoo','Select Country')),
            array('operator','required', 'message'=>Yii::t('youtoo','Select Operator/Provider')),
            array('country, operator', 'safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'country' => 'Country',
            'operator' => 'Operator',
        );
    }

}
