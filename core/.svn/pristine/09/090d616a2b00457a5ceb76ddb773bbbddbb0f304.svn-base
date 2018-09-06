<?php
class AdUtility{
    public static function createAdRecord($ad, $url = null){
        $adDestonation = new eAdDestination('create');
        $adDestonation->setIsNewRecord(true);
        $adDestonation->setPrimaryKey(NULL);
        $adDestonation->ad_id = $ad->id;
        if($user = ClientUtility::getUser()) {
            $adDestonation->user_id = $user->id;
        }
        $adDestonation->ip = $_SERVER['REMOTE_ADDR'];
        if(!is_null($url)){
            $adDestonation->type = 'click';
            $adDestonation->url = base64_decode($url);
        }else{
            $adDestonation->type = 'impression';
            $adDestonation->url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        $adDestonation->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $adDestonation->save();
        if(!is_null($url))
            header( "Location: $ad->url" );
    }
}
?>
