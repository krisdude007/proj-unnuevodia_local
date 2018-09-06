<?php

class ContactUtility {
    // gets values for image status dropdown
    public static function getAdminEmail() {
        $contact = eContactInformation::model()->findByAttributes(array('attribute' => 'admin_email'));
        if(!is_null($contact))
            return $contact->value;
        return "";
    }
    public static function getFTPEmail() {
        $contact = eContactInformation::model()->findByAttributes(array('attribute' => 'ftp_file_transfer_emails'));
        if(!is_null($contact))
            return explode(";",$contact->value);
        return "";
    }


    public static function getOpIdAndShortCode($phonenumber = NULL) {
        $user = ClientUtility::getUser();

        $url = "http://clients.actelme.com/DeliverClients/youtootech_deliver.aspx?method=get" .
                "&sender=" . $phonenumber;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $xml = simplexml_load_string($response);

        $json = json_decode(json_encode($xml), TRUE);
        return $json;
    }

    public static function sendSMS($id = NULL, $phone, $message = NULL) {
        //To-do: Id is sent to this function, from where we can pull all the rest of the information to send SMS to the user, it will be global
        if (!Yii::app()->user->isGuest) {
        $user = ClientUtility::getUser();
        } else {
        $userRecord = eUser::model()->findByAttributes(array('username' => $phone));
        }
        $phonenumber = isset($phone) ? $phone : $user->username;

        $userInfo = ContactUtility::getOpIdAndShortCode($phonenumber);
        $opId = !empty($userInfo['node'][0]['opid']) ? $userInfo['node'][0]['opid'] : $userInfo['node']['opid'];
        $originator = !empty($userInfo['node'][0]['shortcode']) ? $userInfo['node'][0]['shortcode'] : $userInfo['node']['shortcode'];

        $response = NULL;

        $contentTypeDetails = Yii::app()->params['actel']['contentTypeDetails'];
        $contentBody = $message;

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $contentId = uniqid();

        $url = "http://clients.actelme.com/MainSMS/push_content.aspx?username=" . urlencode(Yii::app()->params['actel']['username']) .
                "&password=" . urlencode(Yii::app()->params['actel']['password']) .
                "&receiver=" . urlencode($phonenumber) .
                "&contentbody=" . urlencode($contentBody) .
                "&originator=" . urlencode($originator) .
                "&opid=" . urlencode($opId) .
                "&contentid=" . urlencode($contentId) .
                "&contentsubtype=" . Yii::app()->params['actel']['contentSubType'] .
                "&contenttypedetails=" . $contentTypeDetails .
                "&id_application=" . urlencode(Yii::app()->params['actel']['id_application']);
        //echo $url;exit();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        //print_r($response);

        $smssend = new eGameChoiceSmsInbound();
        $smssend->user_id = isset($user->id) ? $user->id : $userRecord->id;
        $smssend->game_choice_id = $game->id;
        $smssend->smsreceiver = $phonenumber;
        $smssend->contentbody = $contentBody;
        $smssend->processor = 'actel';

        $smssend->response = $response;

        $smssend->request = $url;
        $smssend->description = json_encode(array('contentId' => $contentId, 'smsreceiver' => $phonenumber, 'originator' => $originator));
        $smssend->created_on = new CDbExpression('NOW()');
        if ($smssend->validate()) {
            $smssend->save();
            $contact = true;
        } else {
            $contact = false;
        }

        if ($contact) {
            $response = 'success';
        } else {
            $response = 'fail';
        }

        return $response;
    }
}

?>
