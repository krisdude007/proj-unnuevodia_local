<?php

class twitterStreamCommand extends CConsoleCommand {
    public function run($args){
        if(empty($args)){
            echo 'Please call with args!'."\r\n";
            exit;
        }
        
        $config['consumerkey']=Yii::app()->twitter->consumer_key;
        $config['consumersecret']=Yii::app()->twitter->consumer_secret;
        $config['accesstoken']=Yii::app()->twitter->adminAccessToken;
        $config['tokensecret']=Yii::app()->twitter->adminTokenSecret;

        $file = Yii::app()->twitter->streamFile;
               
        $track = '';
        foreach($args as $k=>$v){            
            $track .= $v.',';
        }
        $track = rtrim($track,',');
        
        $query = Array(
            'track'=>$track,
        );

        $oauth = Array(
            'oauth_consumer_key'=>$config['consumerkey'],
            'oauth_nonce'=>md5(uniqid(rand(), true)),
            'oauth_signature_method'=>'HMAC-SHA1',
            'oauth_timestamp'=>time(),
            'oauth_token'=>$config['accesstoken'],
            'oauth_version'=>'1.0',
        );

        $url = 'https://stream.twitter.com/1.1/statuses/filter.json';
        $params = array_merge($oauth,$query);
        ksort($params);
        $oauthString = 'POST&'.rawurlencode($url).'&'.rawurlencode(http_build_query($params));
        $oauthKey = rawurlencode($config['consumersecret']).'&'.rawurlencode($config['tokensecret']);
        $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $oauthString, $oauthKey, true));
        $oauthHeader = '';
        foreach($oauth as $k=>$v){
            $oauthHeader .= rawurlencode($k).'='.'"'.rawurlencode($v).'", ';
        }
        $oauthHeader = rtrim($oauthHeader,', ');

        $fp = fopen($file, 'w+');
        if(!$fp){
            die('cant open stream file!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth '.$oauthHeader,
        ));
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);                
    }
}

?>
