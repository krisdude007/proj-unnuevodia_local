<?php

class PaymentController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $activeNavLink = 'pay';
    public $activeSubNavLink = '';

    function init() {
        parent::init();
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'process', 'thankyou', 'cancelpayment', 'processstripe', 'processpaypaldirect', 'processstripeajax', 'processstripeproduct', 'processpaypalproduct','processstripeprepay','processpaypalprepay'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($modelName = NULL, $id = 1) {
        $maxAmount = 30;
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('/user/login'));
            return;
        }

        $id = (int)$id;

        if($modelName == "game_choice") {
            $model = eGameChoice::model()->findByPk($id);
        } else if($modelName == "game_choice_response") {
            $model = eGameChoiceResponse::model()->findByPk($id);
        }

        $key = '';
        if(!Yii::app()->user->isGuest){
            $user = clientUser::model()->findByPk(Yii::app()->user->id);
            $criteria = new CDbCriteria();
            $criteria->select = 'SUM(t.price) AS amount';
            $criteria->condition = "t.key='".$user->paypal_preapproval_key."'";
            $transactions = eTransaction::model()->findAll($criteria);
            if(empty($transactions[0]->amount))
                $transactions[0]->amount = 0;
            if(!empty($user->paypal_preapproval_key) && $user->paypal_preapproval_endingdate >= date('Y-m-d') && $transactions[0]->amount < $maxAmount){
                $key = $user->paypal_preapproval_key;
            }
        }

        $this->render('payment', array(
            'model' => $model,
            'key' => $key
        ));
    }

    public function actionIndex2($ci = 1, $gid = NULL) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('/user/login'));
            return;
        }

//        $geoLocation = GeoUtility::GeoLocation();
//
//        if(!$geoLocation['isValid']) {
//            $this->redirect($this->createUrl('/geocoordinates'));
//            return;
//        }

        $user = clientUser::model()->findByPK(Yii::app()->user->getId());
        $balance = eCreditBalance::getTotalUserBalance($user->id);

        $payCashArray   = Array(1 => 5, 2 => 10, 3 => 25, 4 => 50); //0 index with default key as 5
        $payCreditArray = Array(1 => 5, 2 => 13, 3 => 32, 4 => 65); //0 index with default key as 5

        $key = '';
//        if(!Yii::app()->user->isGuest){
//            $user = clientUser::model()->findByPk(Yii::app()->user->id);
//            $criteria = new CDbCriteria();
//            $criteria->select = 'SUM(t.price) AS amount';
//            $criteria->condition = "t.key='".$user->paypal_preapproval_key."'";
//            $transactions = eTransaction::model()->findAll($criteria);
//            if(empty($transactions[0]->amount))
//                $transactions[0]->amount = 0;
//            if(!empty($user->paypal_preapproval_key) && $user->paypal_preapproval_endingdate >= date('Y-m-d') && $transactions[0]->amount < $maxAmount){
//                $key = $user->paypal_preapproval_key;
//            }
//        }

        $this->render('payment', array(
            'user' => $user,
            'game_id' => $gid,
            'balance' => $balance,
            'key' => $key,
            'payCashArray' => $payCashArray,
            'payCreditArray' => $payCreditArray,
            'cashIndex' => $ci
        ));
    }

    public function actionProcessStripeProduct($id = NULL) {

        if(!empty($id)) {
            $prize = ePrize::model()->findByPk($id);
        }
        else {
            exit;
        }

        $stripe = StripeUtility::config();
        $token  = $_POST['stripeToken'];

        $user = eUser::model()->findByAttributes(array('id' => Yii::app()->user->getId()));
        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));
        $userLocation = eUserLocation::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));
        $userLocation = (is_null($userLocation)) ? new clientUserLocation : $userLocation;

        $customer = \Stripe\Customer::create(array(
            'email' => $userEmail->email,
            'card'  => $token
        ));

        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $prize->market_value*100,
            'currency' => 'usd'
        ));

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'stripe';
        $transaction->response = 'stripe';
        $transaction->description = $prize->tableName();
        $transaction->item = $prize->tableName();
        $transaction->item_id = $prize->id;
        $transaction->price = $prize->market_value;

        if($transaction->save()) {
            $creditTransaction = new eCreditTransaction;
            $creditTransaction->type = "purchased";
            $creditTransaction->user_id = Yii::app()->user->getId();
            $creditTransaction->trans_id = $transaction->id;
            $creditTransaction->prize_id = $prize->id;
            $creditTransaction->credits = 0;

            if($creditTransaction->save()) {
                Yii::app()->session['creditId'] = $creditTransaction->id;
                Yii::app()->session['transaction_id'] = $transaction->id;
                Yii::app()->session['prize_id'] = $prize->id;
                $result = MailUtility::send('confirm', $userEmail->email, array('link' => Yii::app()->createAbsoluteUrl("redeem/", array()),'prize' => $prize->name, 'credits' => '$'.$prize->market_value ,'firstname' => isset($user->first_name) ? $user->first_name : 'John', 'lastname' => isset($user->last_name) ? $user->last_name : 'Doe','address' => $userLocation->address1, 'city' => $userLocation->city,'state' => $userLocation->state, 'zipcode' => $userLocation->postal_code, 'image' => "/" . basename(Yii::app()->params["paths"]["image"]) . "/{$prize->image}"), false);
                if ($result) {
                $this->redirect($this->createUrl('/site/confirmation'));
                }
            } else {
                echo "Credit Transaction Error";
                exit;
            }
        } else {
            echo "Transaction Error";
            exit;
        }
    }

    public function actionProcessPayPalProduct($id = NULL) {

        if(!empty($id)) {
            $prize = ePrize::model()->findByPk($id);
        }
        else {
            exit;
        }

        $user = eUser::model()->findByAttributes(array('id' => Yii::app()->user->getId()));
        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));
        $userLocation = eUserLocation::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'PayPal';
        $transaction->response = 'PayPal Purchase';
        $transaction->description = $prize->tableName();
        $transaction->item = $prize->tableName();
        $transaction->item_id = $prize->id;
        $transaction->price = $prize->market_value;

        if($transaction->save()) {
            $creditTransaction = new eCreditTransaction;
            $creditTransaction->type = "purchased";
            $creditTransaction->user_id = Yii::app()->user->getId();
            $creditTransaction->trans_id = $transaction->id;
            $creditTransaction->prize_id = $prize->id;
            $creditTransaction->credits = 0;

            if($creditTransaction->save()) {
                Yii::app()->session['creditId'] = $creditTransaction->id;
                Yii::app()->session['transaction_id'] = $transaction->id;
                Yii::app()->session['prize_id'] = $prize->id;
                $result = MailUtility::send('confirm', $userEmail->email, array('link' => Yii::app()->createAbsoluteUrl("redeem/", array()),'prize' => $prize->name, 'credits' => '$'.$prize->market_value.'.00' ,'firstname' => isset($user->first_name) ? $user->first_name : 'John', 'lastname' => isset($user->last_name) ? $user->last_name : 'Doe','address' => $userLocation->address1, 'city' => $userLocation->city,'state' => $userLocation->state, 'zipcode' => $userLocation->postal_code, 'image' => "/" . basename(Yii::app()->params["paths"]["image"]) . "/{$prize->image}"), false);
                if ($result) {
                $this->redirect($this->createUrl('/site/confirmation'));
                }
            } else {
                echo "Credit Transaction Error";
                exit;
            }
        } else {
            echo "Transaction Error";
            exit;
        }
    }

    public function actionProcessStripe($modelName = NULL, $id = 1) {
        $transactionID = PaymentUtility::stripePaymentGame($modelName, $id, $_POST['stripeToken']);
        //$this->redirect(Yii::app()->createURL("/paymentdone/thankyou/{$transactionID}"));
        $this->redirect(Yii::app()->createURL("/playnow"));
    }

    public function actionProcessPayPalDirect($modelName = NULL, $id = 1) {
        $transactionID = PaymentUtility::paypalDirectPayGame($modelName, $id, Yii::app()->session['paypalTransactionID']);
        //$this->redirect(Yii::app()->createURL("/paymentdone/thankyou/{$transactionID}"));
        $this->redirect(Yii::app()->createURL("/playnow"));
    }

    public function actionProcessStripePrepay() {
        $user = clientUser::model()->findByPK(Yii::app()->user->getId());
        $userEmail = clientUserEmail::model()->findByAttributes(array('user_id' => $user->id, 'type' => 'primary'));

        $transactionID = PaymentUtility::stripePaymentPrepay($_POST['amount'], $_POST['stripeToken']);
        $result = MailUtility::send('thankyou', $userEmail->email, array('link' =>Yii::app()->createAbsoluteUrl("/", array()),'amount' => $_POST['amount']), false);
        if ($result) {
            $game_id = $_POST['game_id'];
            if(empty($game_id)) {

                if ($this->isMobile()) {
                    $this->redirect(Yii::app()->createURL("/site/index"));
                }
                $this->redirect(Yii::app()->createURL("/index.php?f=p"));
            } else {
                $this->redirect(Yii::app()->createURL("/winlooseordraw/{$game_id}"));
            }
        }
        //$this->redirect(Yii::app()->createURL("/playnow"));
    }

    public function actionProcessPayPalPrepay() {
        $user = clientUser::model()->findByPK(Yii::app()->user->getId());
        $userEmail = clientUserEmail::model()->findByAttributes(array('user_id' => $user->id, 'type' => 'primary'));

        $transactionID = PaymentUtility::paypalPaymentPrepay(Yii::app()->session['amount'], Yii::app()->session['paypalTransactionID']);
        $result = MailUtility::send('thankyou', $userEmail->email, array('link' =>Yii::app()->createAbsoluteUrl("/", array()),'amount' => Yii::app()->session['amount']), false);
        if ($result) {
            unset(Yii::app()->session['paypalTransactionID']);
            unset(Yii::app()->session['amount']);
            if ($this->isMobile()) {
            $this->redirect(Yii::app()->createURL("/paymentdone/thankyou"));
            }
            $this->redirect(Yii::app()->createURL("/index.php?f=p"));
        }
        //$this->redirect(Yii::app()->createURL("/playnow"));
    }

    public function actionPayProcess($modelName = NULL, $id = 1) {
        $maxAmount = 30;
        $model = eGameChoiceResponse::model()->findByPk((int) $id);
        Yii::app()->session['gameChoiceResponseId'] = $id;
        if (Yii::app()->Paypal->active) {
            $user = clientUser::model()->findByPk(Yii::app()->user->id);
            $pricing = ePricing::model()->findByAttributes(Array('product'=>$model->tableName()));
            $response = PaymentUtility::capturePaypalPreapproval($user->paypal_preapproval_key,$pricing->price);
            if($response['response'] != 'success'){
                $startingTime = strtotime("now");
                $endingTime = strtotime("+1 year");
                $response = PaymentUtility::getPaypalPreapproval($maxAmount,$startingTime,$endingTime);
                if($response['response'] == 'success'){
                    Yii::app()->session['preapprovalkey'] = $response['key'];
                    Yii::app()->session['endingTime'] = $endingTime;
                    $this->redirect('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-preapproval&preapprovalkey='.$response['key']);
                }
            }
            else{
                $transaction = new eTransaction;
                $transaction->user_id = Yii::app()->user->getId();
                $transaction->processor = 'paypal';
                $transaction->response = $response['payKey'];
                $transaction->item = $model->tableName();
                $transaction->item_id = $model->id;
                $transaction->description = $model->tableName();
                $transaction->key = $user->paypal_preapproval_key;
                $transaction->price = $pricing->price;

                if(!$transaction->save()){
                    var_dump($transaction->getErrors());
                    exit();
                }

                if($transaction->item_id != 1) {
                    $response = eGameChoiceResponse::model()->findByPk($transaction->item_id);
                    $response->transaction_id = $transaction->id;
                    $response->save();
                }

                $creditTransaction = new eCreditTransaction;
                $creditTransaction->game_type = "sweepstakes";
                $creditTransaction->type = "earned";
                $creditTransaction->credits = 1;
                $creditTransaction->trans_id = $transaction->id;
                $creditTransaction->save();

                $this->redirect("/paymentdone/thankyou");
            }
        }
    }

    public function actionThankYou($id = NULL)
    {
        $game_id = 0;
        if($id == NULL) {
//            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
//        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        if ($game) {
            $game_id = $game->id;
        }
        //$gameManager = GameUtility::managerPayPlay(Yii::app()->user->getId());

        //new code
        //$isCorrect = 0;
        //$transaction = eTransaction::model()->findByPk((int) $id);

        //if($transaction->item_id != 1)
        {
            //$response = eGameChoiceResponse::model()->findByPk($transaction->item_id);
            //$answer = eGameChoiceAnswer::model()->findByPk($response->game_choice_answer_id);
            //$isCorrect = $answer->is_correct;
        }

        $this->render('thankyou', array(
              'game_id' => $game_id,
//            'isCorrect' => $isCorrect,
//            'credits' => 1,
//            'order_date' => $transaction->created_on,
//            'order_num' => $transaction->id,
//            'payment_method' => $transaction->processor,
//            'payment_from' => 'web',
//            'price' => number_format($transaction->price, 2, '.', ','),
//            'next_game_id' => $gameManager['game_id']
        ));
    }

    public function actionCancelPayment() {

        $this->render('cancelpayment', array(
        ));
    }

    public function actionExpressCheckOut($amount = NULL, $id = NULL, $modelName = NULL, $prizeId = NULL){
        if (!is_null($modelName)) {
        Yii::app()->Paypal->cancelUrlExpress = Yii::app()->createAbsoluteUrl("paypal/cancelExpresspayProduct/");
        }
        $paypal = PaymentUtility::paypal2($amount, $modelName);
        if ($paypal['response'] == 'success') {
            Yii::app()->session['amount'] = $amount;
            Yii::app()->session['game_id'] = $id;
            Yii::app()->session['model'] = $modelName;
            Yii::app()->session['prizeId'] = $prizeId;

            $this->redirect($paypal['url']);
        }
    }

    public function actionExpressCheckOut2($modelName = NULL, $id = NULL){
        $model = eGameChoiceResponse::model()->findByPk((int) $id);
        Yii::app()->session['gameChoiceResponseId'] = $id;
        Yii::app()->Paypal->returnUrlExpress = Yii::app()->createAbsoluteUrl("paypal/confirmExpresspay2/");
        Yii::app()->Paypal->cancelUrlExpress = Yii::app()->createAbsoluteUrl("paypal/cancelExpresspay2/");
        $paypal = PaymentUtility::paypal($model);
        if ($paypal['response'] == 'success') {
            $this->redirect($paypal['url']);
        }
    }

}

