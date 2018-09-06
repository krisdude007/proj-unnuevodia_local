<?php

class GeoUtility {
    public static function GeoLocation() {
        $user_id = Yii::app()->user->getId();
        $ip_address = ClientUtility::getClientIpAddress();
        
        $validGeoUser = eGeoLocationInfo::model()->findbyAttributes(array('user_id' => $user_id, 'ip_address' => $ip_address));
        
        $geoLocation = array('isExists' => 0, 'isShared' => 0, 'isValid' => 0, 'isPreshare' => 0, 'isOtherGeoLocationShare' => 0, 'geo_id' => 0);
        
        if(!is_null($validGeoUser)) {
            $geoLocation['isExists'] = 1;
            $geoLocation['geo_id'] = $validGeoUser->id;
        } else {
            $otherGeoLocationShare = eGeoLocationInfo::model()->findbyAttributes(array('user_id' => $user_id, 'is_share' => 1));
            
            if(!is_null($otherGeoLocationShare)){
                $geoLocation['isOtherGeoLocationShare'] = 1;
            }
        }
        
        if(!is_null($validGeoUser) && $validGeoUser->is_share) {
            $geoLocation['isShared'] = 1;
        }
        
        if(!is_null($validGeoUser) && $validGeoUser->is_validlocation == 1) {
            $geoLocation['isValid'] = 1;
        }
        
        if(!is_null($validGeoUser) && $validGeoUser->is_preshare == 1) {
            $geoLocation['isPreshare'] = 1;
        }
        
        return $geoLocation;
    }
}

?>
