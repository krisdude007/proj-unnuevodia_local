<?php

class ClientUtility {
    
    // get user stats to display on each page
    public static function getUser() {
        return eUser::model()->with('images:isAvatar')->findByPK(Yii::app()->user->id);
    }
    
    public static function getNumVideos($user_id = null) {
        
        if(is_null($user_id)) {
            $user_id = Yii::app()->user->id;
        } 
        
        return eVideo::model()->processed()->accepted()->countByAttributes(array('user_id' => $user_id));
    }
    
    public static function getNumVotes($user_id = null) {
        
        if(is_null($user_id)) {
            $user_id = Yii::app()->user->id;
        }
        
        return ePollResponse::model()->countByAttributes(array('user_id' => $user_id));
    }
    
    public static function getNumTexts($user_id = null) {
        
        if(is_null($user_id)) {
            $user_id = Yii::app()->user->id;
        }
        
        return eTicker::model()->accepted()->countByAttributes(array('user_id' => $user_id));
    }
    
    public static function getNumImages($user_id = null) {
        
        if(is_null($user_id)) {
            $user_id = Yii::app()->user->id;
        }
        
        return eImage::model()->accepted()->isNotAvatar()->countByAttributes(array('user_id' => $user_id));
    }

}
?>
