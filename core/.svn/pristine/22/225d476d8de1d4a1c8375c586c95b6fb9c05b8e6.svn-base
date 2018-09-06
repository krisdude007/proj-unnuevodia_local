<?php

class LanguageUtility {
    public static function filter($language){
        $pass = true;
        if(!$filters = Yii::app()->cache->get('language_filters')) {
            $filters = eLanguageFilter::model()->findAllByAttributes(Array('active'=>1));
            Yii::app()->cache->set('language_filters', $filters, 3600);
        }
        foreach($filters as $filter){
            $test = preg_replace('/\b'.$filter->pattern.'\b/i','',$language);
            if($test != $language){
                $pass = false;
                break;
            }
        }
        $filter = ($pass) ? '' : $filter;
        return array(
            'result'=>$pass,
            'filter'=>$filter,
        );
    }        
}
