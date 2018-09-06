<?php

class FormVideoImportVine extends CFormModel {

    public $source;
    public $categoryIdentifier; // #hashtag etc
    public $numVideos;

    public function rules() {

        return array(
            array('source, categoryIdentifier, numVideos', 'required'),
            array('numVideos', 'numerical', 'integerOnly' => true),
        );

        return $rules;
    }
    
    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'categoryIdentifier' => '#Hashtag',
            'numVideos' => 'Number of Videos',
            'source' => 'Source'
        );
    }

}