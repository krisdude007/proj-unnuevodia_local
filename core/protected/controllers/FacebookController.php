<?php

class FacebookController extends Controller {

    public $layout = false;

    protected function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        $secret = Yii::app()->facebook->secret;
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            return null;
        }
        return $data;
    }
    /*
    public function actionPublicFeed() {
        $post = trim(file_get_contents('php://input'));
        if(!empty($post)) {
            $fb_data = new FBIncomingData();
            $fb_data->post_data = $post;
            $fb_data->ip = Yii::app()->request->getUserHostAddress();
            $fb_data->created_on = new CDbExpression('NOW()');
            //if($fb_data->save()) {
            //    print 'Data saved';
            //} else {
            //    print 'Unable to save data';
            //}
        }
    }
    */

    protected function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function actionIndex() {
        Yii::app()->request->cookies['fbapp'] = new CHttpCookie('fbapp', 1);
        if (Yii::app()->user->isGuest) {
            $facebook = Yii::app()->facebook;
            $request = $this->parse_signed_request($_POST['signed_request']);
            $facebook->setAccessToken($request['oauth_token']);
            try {
                $facebookData = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                $canvasURL = "http://apps.facebook.com/" . Yii::app()->facebook->appNamespace;
                $authURL = "https://www.facebook.com/dialog/oauth?client_id=" . Yii::app()->facebook->appId . "&redirect_uri=" . $canvasURL . "&scope=user_location,user_birthday,email,publish_stream,publish_actions,status_update";
                echo("<script> top.location.href='" . $authURL . "'</script>");
                exit;
            }
            if ($userFacebook = eUserFacebook::model()->findByAttributes(array('facebook_user_id' => $facebookData['id']))) {
                $user = eUser::model()->findByPK($userFacebook->user_id);
            } else {
                $userFacebook = new eUserFacebook;
                $user = eUser::Model()->findByAttributes(Array('username' => $facebookData['email']));
            }
            if (!$user) {
                $user = new eUser;
                $userEmail = new eUserEmail;
                $userLocation = new eUserLocation;
                $user->setScenario('facebook');
                $userLocation->setScenario('facebook');
                $user->username = (!empty($facebookData['email'])) ? $facebookData['email'] : $facebookData['id'];
                $user->password = uniqid('', true);
                $user->birthday = date('Y-m-d', strtotime($facebookData['birthday']));
                $user->gender = ($facebookData['gender'] == 'male') ? 'M' : 'F';
                $user->first_name = $facebookData['first_name'];
                $user->last_name = $facebookData['last_name'];
                $user->source = 'facebook';
                $userEmail->user_id = $user->id;
                $userEmail->email = $user->username;
                $userEmail->type = 'primary';
                $location = preg_split('/, /', $facebookData['location']['name']);
                $userLocation->user_id = $user->id;
                $userLocation->city = $location[0];
                $userLocation->state = $location[1];
                $userLocation->timezone = $facebookData['timezone'];
                $userLocation->type = 'primary';
                UserUtility::register($user, $userEmail, $userLocation);
                //MailUtility::send('welcome', $userEmail->email);
            }
            $user->setScenario('facebook');
            UserUtility::login($user);
            FacebookUtility::connect($userFacebook);
            $namespace = Yii::app()->facebook->appNamespace;
            echo("<script>top.location.href='https://apps.facebook.com/$namespace'</script>");
        } else {
            $this->redirect('/you');
        }
    }

}

?>
