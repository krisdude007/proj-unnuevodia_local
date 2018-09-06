<?php

class FormBannerUpload extends CFormModel {

    public $file1;
    public $file2;
    public $file3;
    public $file4;
    public $file5;
    public $file6;
    public $file7;
    public $file8;
    public $file9;
    public $file10;
    public $eBanner1;
    public $eBanner2;
    public $eBanner3;
    public $eBanner4;
    public $eBanner5;
    public $eBanner6;
    public $eBanner7;
    public $eBanner8;
    public $eBanner9;
    public $eBanner10;

    public function rules() {

        return array(
            array('file1, file2, file3, file4, file5, file6, file7, file8, file9, file10', 'file', 'allowEmpty' => true, 'maxSize' => 1024 * 1024, 'tooLarge' => 'The File is Too large to be uploaded.'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'file1' => 'Banner 1',
            'file2' => 'Banner 2',
            'file3' => 'Banner 3',
            'file4' => 'Banner 4',
            'file5' => 'Banner 5',
            'file6' => 'Banner 6',
            'file7' => 'Banner 7',
            'file8' => 'Banner 8',
            'file9' => 'Banner 9',
            'file10' => 'Banner 10',
        );
    }

}
