<?php
class AdController extends Controller{
    public function actionClick($adId, $url){
        $ad = eAd::model()->findByPk($adId);
        AdUtility::createAdRecord($ad, $url);
    }
}