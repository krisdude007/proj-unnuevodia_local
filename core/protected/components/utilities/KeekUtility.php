<?php

/*
 * gstringer - 2013-12-20
 * This file is responsible for importing keek videos 
 * into the youtoo admin based on a given keyword or tag.
 */

class KeekUtility {

    private $ch;
    public $connected;

    public function __construct() {
        $this->connected = $this->login(Yii::app()->params['keek']['username'], Yii::app()->params['keek']['password']);
    }

    public function login($username, $password) {

        $url = Yii::app()->params['keek']['url'] . "/signin";
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, "username_login=$username&password_login=$password&frmtk=309f5e1703d3ad7e7c880038c07b569399408239027b9fd206fbedeedd91f216");
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        $chExec = curl_exec($this->ch);

        if ($chExec) {
            $success = true;
        } else {
            $success = false;
            curl_close($this->ch);
        }
        
        return $success;
    }

    public function getTimeline($categoryIdentifier, $numVideos) {

        $url = Yii::app()->params['keek']['url'] . "/search?q=" . $categoryIdentifier;
        curl_setopt($this->ch, CURLOPT_URL, $url);

        //execute the request
        $result = curl_exec($this->ch);

        if (!$result) {
            $returnStuff = curl_error($this->ch);
        } else {
            $returnStuff = $result;
        }

        
        return $returnStuff;
    }
    
    public function getVideo($videoId) {

        $url = Yii::app()->params['keek']['url'] . "/!" . $videoId;
        curl_setopt($this->ch, CURLOPT_URL, $url);

        //execute the request
        $result = curl_exec($this->ch);

        if (!$result) {
            $returnStuff = curl_error($this->ch);
        } else {
            $returnStuff = $result;
        }

        return $returnStuff;
    }
    
    public function close() {
        curl_close($this->ch);
    }

}

?>
