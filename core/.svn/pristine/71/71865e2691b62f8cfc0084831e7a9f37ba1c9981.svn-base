<?php

class FormEmailAssistance extends CFormModel {

    public $name;
    public $email;
    public $phone;
    public $description;
    
    public function rules() {
      
      $email_regex_pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z](?:[a-zA-Z]*[a-zA-Z])?$/';

        return array(
            array('name, email, phone, description', 'required'),
            array('email', 'email', 'pattern' => $email_regex_pattern),
            array('name, email, phone, description', 'safe')
        );

        return $rules;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'description' => 'Description'
        );
    }

}
