<?php

class FormManualUpload extends CFormModel {

    public $uploadfile;

    public function rules() {
        return array(
            array('uploadfile', 'required'),
            array('uploadfile', 'file', 'types' => 'pdf'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'uploadfile' => 'Upload File',
        );
    }

}
