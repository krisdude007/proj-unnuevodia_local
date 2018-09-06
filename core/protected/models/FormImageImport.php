<?php

class FormImageImport extends CFormModel {

    public $source;
    public $categoryIdentifier; // #hashtag etc
    public $numVideos;

    public function rules() {

        return array(
            array('source, categoryIdentifier, numImages', 'required'),
            array('numImages', 'numerical', 'integerOnly' => true),
        );

        return $rules;
    }
    
    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'categoryIdentifier' => '#Hashtag',
            'numImages' => 'Number of Videos',
            'source' => 'Source'
        );
    }

}