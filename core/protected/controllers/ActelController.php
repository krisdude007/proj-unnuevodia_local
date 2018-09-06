<?php

class ActelController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $activeNavLink = 'pay';

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    public function goToLogin() {
        $this->redirect($this->createUrl('/user/login'));
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('getsms', 'getuserstatus', 'ajaxGetPinCode', 'index', 'otp', 'thankyou', 'sorry', 'payment'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            //'deniedCallback' => array($this, 'goToLogin'),
            ),
        );
    }

    public function actionIndex() {

        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('/user/login'));
            return;
        }
        $user_id = Yii::app()->user->getId();
        $user = clientUser::model()->findByPk($user_id);
        $actelForm = new FormActelTransaction();

        /* For IVR */
        Yii::app()->session['transId'] = NULL;

        $ivruser = eGameIvrOutbound::model()->findByAttributes(array('phonenumber' => $user->username), 'gameplay=0');

        if (isset($ivruser->gameplay)) {
            $trans = eGamingTransaction::model()->findByAttributes(array('user_id' => $user_id, 'ivr_id' => $ivruser->id)); //var_dump($trans);exit;

            if (!empty($trans->id) && $trans->request == 'IVR Request' && $ivruser->gameplay == 0) {
                Yii::app()->session['transId'] = $trans->id;
                $this->redirect($this->createUrl('/game/multiple'));
            }
        }
        /* end for IVR */

        $userRecord = eGamingTransaction::model()->recent()->findByAttributes(array('user_id' => $user_id)); //var_dump($userRecord);exit;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-payment-form') {
            echo CActiveForm::validate($actelForm);
            Yii::app()->end();
        }

        if (isset($_POST['FormActelTransaction']) && isset($_POST['clientUser'])) {
            $actelForm->attributes = $_POST['FormActelTransaction'];

            $user->attributes = $_POST['clientUser'];
            $country = $actelForm->country;
            $operator = $actelForm->operator;
            $phonenumber = $user->username;

            $userInfo = ContactUtility::getOpIdAndShortCode($phonenumber);
            if (isset($userInfo['node'])) {
                $opId = !empty($userInfo['node'][0]['opid']) ? $userInfo['node'][0]['opid'] : $userInfo['node']['opid'];
            } else {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Phonenumber is not verified. Please contact your administrator.'));
                $this->redirect($this->createUrl('/actel/index'));
            }

            $arr = CountryUtility::getOperatorAndCountry($opId);
            if (empty($arr[0]) || empty($arr[1])) {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Phonenumber is not verified. Please contact your administrator.'));
                $this->redirect($this->createUrl('/actel/index'));
            } elseif ($country === $arr[0] && $operator === $arr[1]) {

                $plmn = ClientUtility::getPLMNumbers($country, $operator);

                Yii::app()->session['country'] = $country;
                Yii::app()->session['operator'] = $operator;
                Yii::app()->session['number'] = $phonenumber;
                Yii::app()->session['plmn'] = $plmn;

                $this->redirect('/actel/otp');
                return;
            } else {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'You have chosen an incorrect country or operator. Please try again.'));
                $this->redirect($this->createUrl('/actel/index'));
            }
        }


        if ($user->username == '111222333444') {
            Yii::app()->session['number'] = '111222333444'; // demo mode
        }

        $this->render('index', array(
            'user' => $user,
            'actelForm' => $actelForm,
        ));
    }

    public function actionOtp($id = NULL) {

        if (empty(Yii::app()->session['country']) || empty(Yii::app()->session['operator']) || empty(Yii::app()->session['number']) || empty(Yii::app()->session['plmn'])) {
            $this->redirect($this->createUrl('/actel/index'));
        }
        $country = Yii::app()->session['country'];
        $operator = Yii::app()->session['operator'];
        $phonenumber = Yii::app()->session['number'];
        $plmn = Yii::app()->session['plmn'];
        $response = NULL;

        $action = 'vcode_charge';

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }
        $price = CountryUtility::getPrice($country, $operator);
        $currency = CountryUtility::getCurrency($country);

        $userInfo = ContactUtility::getOpIdAndShortCode($phonenumber);
        $opType = !empty($userInfo['node'][0]['type']) ? $userInfo['node'][0]['type'] : $userInfo['node']['type'];


        if ($opType == 'SMS') {
            $action = 'vcode';
        }

        $orderId = uniqid();

        if (isset($_POST['otpassword'])) {

            $pincode = $_POST['otpassword'];

            $url = "http://clients.actelme.com/MainSMS/SDK/PincodeActions.aspx?pincode=" . urlencode($pincode) . "&username=" . urlencode(Yii::app()->params['actel']['username']) .
                    "&password=" . urlencode(Yii::app()->params['actel']['password']) .
                    "&id_application=" . urlencode(Yii::app()->params['actel']['id_application']) .
                    "&action=" . $action . "&mode=mobile&countryname=" . urlencode($country) .
                    "&operatorname=" . urlencode($operator) .
                    "&plmn=" . urlencode($plmn) .
                    "&receiver=" . urlencode($phonenumber) .
                    "&amount=" . urlencode($price) . "&currency=" . $currency;
            //echo $url;exit();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            //print_r($response);

            $transaction = new eGamingTransaction();

            $user = ClientUtility::getUser();
            $transaction->user_id = isset($user->id) ? $user->id : 0;
            $transaction->processor = 'actel';
            $transaction->game_choice_id = $game->id;
            $transaction->response = $response;

            $transaction->request = $url;
            $transaction->description = json_encode(array('orderid' => $orderId, 'country' => $country, 'operator' => $operator, 'phonenumber' => $phonenumber, 'plmn' => $plmn));
            $transaction->price = $price;
            $transaction->country = $country;
            $transaction->operator = $operator;
            $transaction->created_on = new CDbExpression('NOW()');

            if ($transaction->validate()) {
                if ($transaction->save()) {
                    Yii::app()->session['transId'] = $transaction->id;
                }
            } else {
                return;
            }

            if ($response == 'okdelivered') {

                $this->redirect('/game/multiple');
                return;
            } else {
                if ($response == 'okfailed') {
                    $this->redirect('/actel/sorry');
                    Yii::app()->user->setFlash('error', $response);
                }
                Yii::app()->user->setFlash('error', $response);
            }
        }

        if ($phonenumber == '111222333444') {
            Yii::app()->session['transId'] = 1234; // demo purposes
        }

        $this->render('otp', array(
            'phonenumber' => $phonenumber,
        ));
    }

    public function actionAjaxGetPinCode() {

        $user_id = Yii::app()->user->getId();
        //$userRecord = eGamingTransaction::model()->recent()->findByAttributes(array('user_id' => $user_id));
        $user = clientUser::model()->findByPk($user_id);
        $phonenumber = $user->username;
        $country = $_POST['country'];
        $operator = $_POST['operator'];

        $userInfo = ContactUtility::getOpIdAndShortCode($phonenumber);
        if (isset($userInfo['node'])) {
            $opId = !empty($userInfo['node'][0]['opid']) ? $userInfo['node'][0]['opid'] : $userInfo['node']['opid'];

            $arr = CountryUtility::getOperatorAndCountry($opId); //var_dump($arr);exit;
            if (empty($arr[0]) || empty($arr[1])) {
                echo json_encode(array('error' => Yii::t('youtoo', 'Phonenumber is not verified. Please contact your administrator.')));
            } elseif ($country === $arr[0] && $operator === $arr[1]) {

                $plmn = ClientUtility::getPLMNumbers($country, $operator);

                $url = "http://clients.actelme.com/MainSMS/SDK/PincodeActions.aspx?username=" . urlencode(Yii::app()->params['actel']['username']) .
                        "&password=" . urlencode(Yii::app()->params['actel']['password']) .
                        "&action=otp&id_application=" . urlencode(Yii::app()->params['actel']['id_application']) .
                        "&mode=mobile&countryname=" . urlencode($country) .
                        "&operatorname=" . urlencode($operator) .
                        "&plmn=" . urlencode($plmn) .
                        "&receiver=" . urlencode($phonenumber);
                //echo $url;exit();

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);

                if ($response == 'OK' || $response == 'ok') {
                    echo json_encode(array('success' => Yii::t('youtoo', 'We sent you sms pin to your mobile. Please check')));
                } else {
                    echo json_encode(array('error' => Yii::t('youtoo', 'Invalid Request. Please try again.')));
                }
            } else {
                echo json_encode(array('error' => Yii::t('youtoo', 'Invalid Request. Please try again.')));
            }
        } else {
            echo json_encode(array('error' => Yii::t('youtoo', 'Phonenumber is not verified. Please contact your administrator.')));
        }
    }

    public function actionThankYou() {

        $messageThanks = "Page has been expired";

        unset(Yii::app()->session['credittransId']);

        $creditTransaction = Yii::app()->user->getState('creditTransaction');//var_dump($creditTransaction);
        $gameChoiceAnswer = Yii::app()->user->getState('gameChoiceAnswer');//var_dump($gameChoiceAnswer);
        $game = Yii::app()->user->getState('game');//var_dump($game);exit;

        $gamechoiceresponseId = Yii::app()->session['gamechoiceresponseId']; //var_dump(Yii::app()->session['gamechoiceresponseId']);exit;
        $gameresponse = eGameChoiceResponse::model()->findByPK($gamechoiceresponseId);
        if (!empty($gameresponse)) {
            $gameresponse->transaction_id = Yii::app()->session['transId'];
            $gameresponse->save();
        }

        /* FOR IVR */

        $responseUser = clientUser::model()->findByPk($gameresponse->user_id);
        $ivruser = eGameIvrOutbound::model()->findByAttributes(array('phonenumber' => $responseUser->username), 'gameplay=0');
        if (!empty($ivruser)) {
            $ivruser->gameplay = 1;
            $ivruser->save();
        }
         /* end for IVR */

        if (!(isset($gameChoiceAnswer->is_correct) && isset($creditTransaction->credits) && isset($game->price))) {
            Yii::app()->user->setFlash('error', Yii::t('youtoo', $messageThanks));
            $this->redirect(Yii::app()->createURL('site/index'));
        }

        Yii::app()->user->setState('creditTransaction', null);
        Yii::app()->user->setState('gameChoiceAnswer', null);
        Yii::app()->user->setState('game', null);

        if ($gameChoiceAnswer->is_correct) {
            $this->render('thankyou', array(
                'isCorrect' => $gameChoiceAnswer->is_correct,
                'credit' => $creditTransaction->credits,
                'date' => $creditTransaction->created_on,
                'orderNo' => ($creditTransaction->id + 10000),
                'price' => $game->price,
            ));
        } else {
            $this->render('sorry', array(
                'isCorrect' => $gameChoiceAnswer->is_correct,
                'credit' => $creditTransaction->credits,
                'date' => $creditTransaction->created_on,
                'orderNo' => ($creditTransaction->id + 10000),
                'price' => $game->price,
            ));
        }
    }

    public function actionSorry() {

        $this->render('sorry', array(
        ));
    }

    public function actionGetSMS($id = NULL) {

        $message = "Thanks for playing.";

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $gameAnswers = eGameChoiceAnswer::model()->findAllByAttributes(array('game_choice_id' => $game->id));
        //$answerList = array('a', 'b', 'c', 'd', 'A', 'B', 'C', 'D', '1', '2', '3', '4');
        $smsoutbound = new eGameChoiceSmsOutbound();
        $idlang = 1;
        $language = '';
        $smsoutbound->created_on = new CDbExpression('NOW()');

        if (isset($_GET)) {
            $smsoutbound->attributes = $_GET;
            $smsoutbound->smsdecodetext = $smsoutbound->smstext;
            $smsoutbound->return_value = 'n/a';
            if ($smsoutbound->validate()) {
                if ($smsoutbound->idlang == '0') {
                    $smsoutbound->smsdecodetext = mb_convert_encoding(pack("H*", $smsoutbound->smstext), 'UTF-8', 'UCS-2');
                }
                $smsoutbound->return_value = 'Ok';
                $smsoutbound->save();

                $user = eUser::model()->findByAttributes(array('username' => $smsoutbound->smssender));
                $userInfo = ContactUtility::getOpIdAndShortCode($smsoutbound->smssender);
                $opId = !empty($userInfo['node'][0]['opid']) ? $userInfo['node'][0]['opid'] : $userInfo['node']['opid'];
                if (empty($user)) {//echo 'user';
                    $user = new clientUser();
                    $userLocation = new eUserLocation();

                    $arr = CountryUtility::getOperatorAndCountry($opId);
                    $user->username = $smsoutbound->smssender;
                    $user->birthday = '0000-00-00';
                    $user->source = 'sms';
                    $user->gender = '';
                    $user->first_name = '';
                    $user->last_name = '';
                    ClientUserUtility::register($user);
                    $userArr = clientUser::model()->findByAttributes(array('username' => $smsoutbound->smssender));
                    $userLocation->user_id = $userArr->id;
                    if ($userLocation->validate()) {
                        $userLocation->country = $arr[0];
                        $userLocation->save();
                    }
                }
                $flag = false;
                $replaceArr = array(' ', '.');
                foreach ($gameAnswers as $gameAnswer) {
                    if (strncasecmp(substr($gameAnswer->label, 0, strlen($smsoutbound->smstext)), str_replace($replaceArr, '', $smsoutbound->smstext), strlen($smsoutbound->smstext)) == 0 ||
                            strncasecmp(substr($gameAnswer->label, 0, strlen($smsoutbound->smstext)), str_replace($replaceArr, '', $smsoutbound->smsdecodetext), strlen($smsoutbound->smsdecodetext)) == 0) {
                        $gameChoiceResponse = new eGameChoiceResponse();

                        $gameChoiceResponse->user_id = $user->id;
                        $gameChoiceResponse->source = 'SMS';
                        $gameChoiceResponse->game_choice_id = $game->id;
                        $gameChoiceResponse->game_choice_answer_id = $gameAnswer->id;
                        $gameChoiceResponse->sms_id = $smsoutbound->id;

                        if ($gameChoiceResponse->save()) {

                            $transaction = new eCreditTransaction;
                            $transaction->game_type = "game_choice";
                            $transaction->game_id = $gameChoiceResponse->game_choice_id;
                            $transaction->type = "earned";

                            $transaction->credits = $gameAnswer->point_value;
                            $transaction->save();
                            $flag = true;
                        }
                    }
                }

                if ($flag == false) {
                    $gameChoiceResponse = new eGameChoiceResponse();

                    $gameChoiceResponse->user_id = $user->id;
                    $gameChoiceResponse->source = 'SMS';
                    $gameChoiceResponse->game_choice_id = $game->id;
                    $gameChoiceResponse->game_choice_answer_id = $gameAnswers[4]->id;
                    $gameChoiceResponse->sms_id = $smsoutbound->id;

                    if ($gameChoiceResponse->save()) {

                        $transaction = new eCreditTransaction;
                        $transaction->game_type = "game_choice";
                        $transaction->game_id = $gameChoiceResponse->game_choice_id;
                        $transaction->type = "earned";

                        $transaction->credits = $gameAnswers[4]->point_value;
                        $transaction->save();
                    }
                }


                //sending sms to user, after recording his answer
                if ($smsoutbound->idlang == 0) {
                    $armessage = 'CNBC Arabia شكرا لاشتراكك مع قناة';
                    $message = $armessage;
                    $idlang = $smsoutbound->idlang;
                }

                ContactUtility::sendSMS($id, $user->username, $message, $idlang);
                echo 'Ok';
                return;
            }

            if ($smsoutbound->hasErrors('smsid')) {
                if (empty($smsoutbound->smsid)) {
                    $smsoutbound->return_value = 'Invalid SMSID';
                    $smsoutbound->save();
                    echo 'Invalid SMSID';
                    return;
                } else {
                    $smsoutbound->return_value = 'Invalid Request duplicates';
                    $smsoutbound->save();
                    echo 'Invalid Request duplicates';
                }
                return;
            }
            if ($smsoutbound->hasErrors('opid')) {
                $smsoutbound->return_value = 'Invalid opid';
                $smsoutbound->save();
                echo 'Invalid opid';
                return;
            }
            if ($smsoutbound->hasErrors('destination')) {
                $smsoutbound->return_value = 'Invalid destination';
                $smsoutbound->save();
                echo 'Invalid destination';
                return;
            }
            if ($smsoutbound->hasErrors('smssender')) {
                $smsoutbound->return_value = 'Invalid smssender';
                $smsoutbound->save();
                echo 'Invalid smssender';
                return;
            }
            if ($smsoutbound->hasErrors('idlang')) {
                $smsoutbound->return_value = 'Invalid idlang';
                $smsoutbound->save();
                echo 'Invalid idlang';
                return;
            }
            $smsoutbound->return_value = 'Invalid Request Error & “Error Description”';
            $smsoutbound->save();
            echo 'Invalid Request Error & “Error Description”';
            return;
        }
    }

    /* For Actel IVR */

    public function actionGetUserStatus($id = NULL) {

        $message = '';

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $ivroutbound = new eGameIvrOutbound();
        $ivroutbound->created_on = new CDbExpression('NOW()');

        $orderId = uniqid();

        if (isset($_GET)) {
            $ivroutbound->attributes = $_GET;
            $ivroutbound->return_value = 'n/a';
            if ($ivroutbound->validate()) {

                $ivroutbound->return_value = 'Ok';
                $ivroutbound->save();

                $user = eUser::model()->findByAttributes(array('username' => $ivroutbound->phonenumber));
                $userInfo = ContactUtility::getOpIdAndShortCode($ivroutbound->phonenumber);
                $opId = !empty($userInfo['node'][0]['opid']) ? $userInfo['node'][0]['opid'] : $userInfo['node']['opid'];
                $arr = CountryUtility::getOperatorAndCountry($opId);
                if (empty($user)) {//echo 'user';
                    $user = new clientUser();
                    $userLocation = new eUserLocation();

                    $user->username = $ivroutbound->phonenumber;
                    $user->birthday = '0000-00-00';
                    $user->source = 'ivr';
                    $user->password = $ivroutbound->pincode;
                    $user->gender = '';
                    $user->first_name = '';
                    $user->last_name = '';
                    ClientUserUtility::register($user);

                    $userArr = clientUser::model()->findByAttributes(array('username' => $ivroutbound->phonenumber));
                    $userLocation->user_id = $userArr->id;
                    if ($userLocation->validate()) {
                        $userLocation->country = $arr[0];
                        $userLocation->save();
                    }
                } else if (!empty($user) && isset($ivroutbound->reset) == 1) {
                    $user->setScenario('changePassword');
                    $user->newPassword = $user->newPasswordConfirm = $ivroutbound->pincode;
                    $user->password = $user->newPassword;
                    if ($user->validate()) {
                        $user->save();
                    }
                }

                $transaction = new eGamingTransaction();

                $plmn = ClientUtility::getPLMNumbers($arr[0], $arr[1]);
                $price = CountryUtility::getPrice($arr[0], $arr[1]);

                $transaction->user_id = isset($user->id) ? $user->id : 0;
                $transaction->processor = 'actel';
                $transaction->game_choice_id = $game->id;
                $transaction->response = 'IVR Ok';
                $transaction->ivr_id = $ivroutbound->id;

                $transaction->request = 'IVR Request';
                $transaction->description = json_encode(array('orderid' => $orderId, 'country' => $arr[0], 'operator' => $arr[1], 'phonenumber' => $user->username, 'plmn' => $plmn));
                $transaction->country = $arr[0];
                $transaction->operator = $arr[1];
                $transaction->price = $price;
                $transaction->created_on = new CDbExpression('NOW()');

                if ($transaction->validate()) {
                    $transaction->save();
                }

                echo 'Ok';
                return;
            }

            if ($ivroutbound->hasErrors('guid')) {
                if (empty($ivroutbound->guid)) {
                    $ivroutbound->return_value = 'Invalid GUID';
                    $ivroutbound->save();
                    echo 'Invalid GUID';
                    return;
                } else {
                    $ivroutbound->return_value = 'Duplicates';
                    $ivroutbound->save();
                    echo 'Duplicates';
                }
                return;
            }
            if ($ivroutbound->hasErrors('opid')) {
                $ivroutbound->return_value = 'Invalid opid';
                $ivroutbound->save();
                echo 'Invalid opid';
                return;
            }
            if ($ivroutbound->hasErrors('shortcode')) {
                $ivroutbound->return_value = 'Invalid destination or shortcode';
                $ivroutbound->save();
                echo 'Invalid destination or shortcode';
                return;
            }
            if ($ivroutbound->hasErrors('phonenumber')) {
                $ivroutbound->return_value = 'Invalid phonenumber';
                $ivroutbound->save();
                echo 'Invalid phonenumber';
                return;
            }
            if ($ivroutbound->hasErrors('pincode')) {
                $ivroutbound->return_value = 'Invalid pincode or No pincode Sent';
                $ivroutbound->save();
                echo 'Invalid pincode or No pincode Sent';
                return;
            }
            if ($ivroutbound->hasErrors('reset')) {
                $ivroutbound->reset = 0;
                $ivroutbound->save();
                echo 'Invalid pincode or No pincode Sent';
                return;
            }
            if ($ivroutbound->hasErrors('duration')) {
                $ivroutbound->return_value = 'Duration not sent';
                if ($ivroutbound->duration > 90) {
                    $ivroutbound->save();
                }
                echo 'Duration not sent';
                return;
            }

            $ivroutbound->return_value = 'Invalid Request Error & “Error Description”';
            $ivroutbound->save();
            echo 'Invalid Request Error & “Error Description”';
            return;
        }
    }

    public function actionPayment($id = NULL) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('/user/login'));
            return;
        }

        $user_id = Yii::app()->user->getId();
        $user = clientUser::model()->findByPk($user_id);
        $actelForm = new FormActelTransaction();

        $response = NULL;
        $action = 'vcode';
        $phonenumber = $user->username;

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        if ($game) {
            $gameresponse = eGameChoiceResponse::model()->findByPK(Yii::app()->session['gamechoiceresponseId']);;
            //$gameresponse->game_choice_answer_id = Yii::app()->session['gamechoiceanswerId'];
            //$gameresponse->game_choice_id = Yii::app()->session['gamechoiceId'];
            //$gameresponse->source = Yii::app()->session['source'];
            $gameresponse->user_id = $user->id;//var_dump($gameresponse);exit;

                Yii::app()->session['gamechoiceresponseId'] = $gameresponse->id;

                $credittransaction = new eCreditTransaction;
                $credittransaction->game_type = "game_choice";
                $credittransaction->game_id = $gameresponse->game_choice_id;
                $credittransaction->type = "earned";

                $answer = eGameChoiceAnswer::model()->findByPk($gameresponse->game_choice_answer_id);//var_dump($answer);exit;
                $credittransaction->credits = $answer->point_value;
                $credittransaction->save();

                Yii::app()->user->setState('creditTransaction', $credittransaction);
                Yii::app()->user->setState('gameChoiceAnswer', $answer);
                Yii::app()->user->setState('game', $game);

                $credittransaction->trans_id = Yii::app()->session['credittransId'];

                Yii::app()->session['gamechoiceanswerId'] = NULL;
                Yii::app()->session['gamechoiceId'] = NULL;
                Yii::app()->session['source'] = NULL;

                /* For IVR */
                Yii::app()->session['transId'] = NULL;

                $ivruser = eGameIvrOutbound::model()->findByAttributes(array('phonenumber' => $user->username), 'gameplay=0'); //var_dump($ivruser);exit;

                if (isset($ivruser->gameplay)) {
                    $ivrtrans = eGamingTransaction::model()->findByAttributes(array('user_id' => $user_id, 'ivr_id' => $ivruser->id)); //var_dump($ivrtrans);exit;

                    if (!empty($ivrtrans->id) && $ivrtrans->request == 'IVR Request' && $ivruser->gameplay == 0) {
                        Yii::app()->session['transId'] = $ivrtrans->id;
                        $this->redirect($this->createUrl('/actel/thankyou'));
                    }
                }
                /* end for IVR */

        } else {
            $this->redirect('/redeem');
        }
        if (isset($_POST['otpassword'])) {

            $country = NULL;
            $operator = NULL;

            $userRecord = eGamingTransaction::model()->findByAttributes(array('user_id' => $user_id)); //var_dump($userRecord);exit;
            if (!empty($userRecord)) {
                $country = $userRecord->country;
                $operator = $userRecord->operator;
            }
            if (isset($_POST['FormActelTransaction'])) {
                $country = $_POST['FormActelTransaction']['country'];
                $operator = $_POST['FormActelTransaction']['operator'];
            }

            $phonenumber = $user->username;

            if (empty($country) || empty($operator)) {
                $this->redirect($this->createUrl('site/index'));
            }
            $plmn = ClientUtility::getPLMNumbers($country, $operator);
            $price = CountryUtility::getPrice($country, $operator);
            $currency = CountryUtility::getCurrency($country);

            $orderId = uniqid();

            $userInfo = ContactUtility::getOpIdAndShortCode($phonenumber);
            $opType1 = !empty($userInfo['node'][0]['type']) ? $userInfo['node'][0]['type'] : $userInfo['node']['type'];
            $opType2 = !empty($userInfo['node'][1]['type']) ? $userInfo['node'][1]['type'] : $userInfo['node']['type'];
            $opType3 = !empty($userInfo['node'][2]['type']) ? $userInfo['node'][2]['type'] : $userInfo['node']['type'];

            $arrOpType = array($opType1,$opType2, $opType3);

            if (array_search('SMS Direct Billing', $arrOpType)) {
                    $action = 'vcode_charge';
            }

            $pincode = $_POST['otpassword'];

            $url = "http://clients.actelme.com/MainSMS/SDK/PincodeActions.aspx?pincode=" . urlencode($pincode) . "&username=" . urlencode(Yii::app()->params['actel']['username']) .
                    "&password=" . urlencode(Yii::app()->params['actel']['password']) .
                    "&id_application=" . urlencode(Yii::app()->params['actel']['id_application']) .
                    "&action=" . $action . "&mode=mobile&countryname=" . urlencode($country) .
                    "&operatorname=" . urlencode($operator) .
                    "&plmn=" . urlencode($plmn) .
                    "&receiver=" . urlencode($phonenumber) .
                    "&amount=" . urlencode($price) . "&currency=" . $currency;
            //echo $url;exit();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            //print_r($response);

            $transaction = new eGamingTransaction();

            $user = ClientUtility::getUser();
            $transaction->user_id = isset($user->id) ? $user->id : 0;
            $transaction->processor = 'actel';
            $transaction->game_choice_id = $game->id;
            $transaction->response = $response;

            $transaction->request = $url;
            $transaction->description = json_encode(array('orderid' => $orderId, 'country' => $country, 'operator' => $operator, 'phonenumber' => $phonenumber, 'plmn' => $plmn));
            $transaction->price = $price;
            $transaction->country = $country;
            $transaction->operator = $operator;
            $transaction->created_on = new CDbExpression('NOW()');
            //var_dump($transaction);exit;

            if ($transaction->validate()) {
                if ($transaction->save()) {
                    Yii::app()->session['transId'] = $transaction->id;
                }
            }

            if ($response == 'okdelivered') {
                $this->redirect('/actel/thankyou');
            } else {
                Yii::app()->user->setFlash('error', $response);
            }
        }

        $gamingtransaction = eGamingTransaction::model()->recent()->findByAttributes(array('user_id' => $user_id)); //var_dump($transaction);exit;
        if (!empty($gamingtransaction)) {
            $selectedcountry = $gamingtransaction->country;
            $selectedoperator = $gamingtransaction->operator;
        } else {
            $selectedcountry = NULL;
            $selectedoperator = NULL;
        }

        $this->render('payment', array(
            'user' => $user,
            'actelForm' => $actelForm,
            'selectedcountry' => $selectedcountry,
            'selectedoperator' => $selectedoperator,
            'phonenumber' => $user->username,
        ));
    }

}

?>