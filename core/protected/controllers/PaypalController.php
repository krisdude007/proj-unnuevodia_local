<?php

class PaypalController extends Controller {

    public $layout = false;
    public $user;

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
        }
    }

    public function actionConfirm() {
        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);
        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);
        $transaction = eTransaction::model()->findByAttributes(Array('response' => $token));

        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $transaction->price;

        $model = Yii::app()->session['Order']['model'];
        unset(Yii::app()->session['Order']);

        //Detect errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            $model->delete();
            Yii::app()->user->setFlash('error', $error);
        } else {
            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            //Detect errors
            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                if (Yii::app()->Paypal->apiLive === false) {
                    //Live mode basic error message
                    $error = 'We were unable to process your request. Please try again later';
                } else {
                    //Sandbox output the actual error message to dive in.
                    $error = $paymentResult['L_LONGMESSAGE0'];
                }
                $model->delete();
                Yii::app()->user->setFlash('error', $error);
            } else {
                //payment was completed successfully
                $transaction->response = json_encode($paymentResult);
                $transaction->save();

                if ($transaction->item_id != 1) {
                    $response = eGameChoiceResponse::model()->findByPk($transaction->item_id);
                    $response->transaction_id = $transaction->id;
                    $response->save();
                }
            }
        }

        Yii::app()->user->setFlash('success', 'Order Successful!');

        switch ($transaction->description) {
            case 'game_choice_response':
                $this->redirect(Yii::app()->createURL("/paymentdone/thankyou/{$transaction->id}"));
                break;
            case 'video':
                $this->redirect(Yii::app()->createURL('/thanks'));
                break;
            case 'ticker':
                $this->redirect(Yii::app()->createURL('/ticker'));
                break;
            case 'image':
                $this->redirect('/image/thanks');
                break;
            case 'poll_response':
                $this->redirect('/vote/results');
                break;
        }
    }

    public function actionCancel() {
        $model = Yii::app()->session['Order']['model'];
        unset(Yii::app()->session['Order']);
        //The token of the cancelled payment typically used to cancel the payment within your application
        $token = $_GET['token'];
        $transaction = eTransaction::model()->findByAttributes(Array('response' => $token)); //var_dump($transaction);exit;
        if (!is_null($transaction)) {
            $transaction->response = 'CANCELLED';
            $transaction->save();
        }
        //$model->delete();
        $flashMessages = Yii::app()->user->getFlashes(true);
        Yii::app()->user->setFlash('error', 'Order Cancelled');
        switch ($transaction->description) {
            case 'video':
                $this->redirect(Yii::app()->createURL('/thanks'));
                break;
            case 'ticker':
                $this->redirect(Yii::app()->createURL('/ticker'));
                break;
            case 'image':
                $this->redirect('/image/thanks');
                break;
            case 'poll_response':
                $this->redirect('/vote/results');
                break;
            default:
                $this->redirect(Yii::app()->createURL('/cancelpayment'));
                break;
        }
    }

    public function actionConfirmPreapproval() {
        if (!empty(Yii::app()->session['preapprovalkey'])) {
            $user = clientUser::model()->findByPk(Yii::app()->user->id);
            $user->password = '';
            $user->paypal_preapproval_key = Yii::app()->session['preapprovalkey'];
            $user->paypal_preapproval_endingdate = date('Y-m-d', Yii::app()->session['endingTime']);
            if (!$user->save()) {
                var_dump($user->getErrors());
            }

            $chargeType = 'game_choice_response';
            $pricing = ePricing::model()->findByAttributes(Array('product' => $chargeType));
            $response = PaymentUtility::capturePaypalPreapproval(Yii::app()->session['preapprovalkey'], $pricing->price);

            if ($response['response'] == 'success') {
                $transaction = new eTransaction;
                $transaction->user_id = Yii::app()->user->id;
                $transaction->processor = 'paypal';
                $transaction->response = $response['payKey'];
                $transaction->item = $chargeType;
                $transaction->item_id = Yii::app()->session['gameChoiceResponseId'];
                $transaction->description = $chargeType;
                $transaction->key = Yii::app()->session['preapprovalkey'];
                $transaction->price = $pricing->price;

                if (!$transaction->save()) {
                    var_dump($transaction->getErrors());
                    exit();
                }

                if(Yii::app()->session['gameChoiceResponseId'] != 1) {
                    $response = eGameChoiceResponse::model()->findByPk(Yii::app()->session['gameChoiceResponseId']);
                    $response->transaction_id = $transaction->id;
                    $response->save();
                }

                $creditTransaction = new eCreditTransaction;
                $creditTransaction->game_type = "sweepstakes";
                $creditTransaction->type = "earned";
                $creditTransaction->credits = 1;
                $creditTransaction->trans_id = $transaction->id;
                $creditTransaction->save();
            }
            unset(Yii::app()->session['preapprovalkey']);
        }
        $this->redirect("/paymentdone/thankyou/{$transaction->id}");
    }

    public function actionCancelPreapproval() {
        Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Cancelled'));
        unset(Yii::app()->session['preapprovalkey']);
        unset(Yii::app()->session['gameChoiceResponseId']);
        $this->redirect('/');
    }

    /*
      public function actionDirectPayment() {//echo 'test';exit;
      $paymentInfo = array('Member' =>
      array(
      'first_name' => 'name_here',
      'last_name' => 'lastName_here',
      'billing_address' => 'address_here',
      'billing_address2' => 'address2_here',
      'billing_country' => 'country_here',
      'billing_city' => 'city_here',
      'billing_state' => 'state_here',
      'billing_zip' => 'zip_here'
      ),
      'CreditCard' =>
      array(
      'card_number' => 'number_here',
      'expiration_month' => 'month_here',
      'expiration_year' => 'year_here',
      'cv_code' => 'code_here'
      ),
      'Order' =>
      array('theTotal' => 1.00)
      );

      /*
     * On Success, $result contains [AMT] [CURRENCYCODE] [AVSCODE] [CVV2MATCH]
     * [TRANSACTIONID] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD]
     *
     * On Fail, $ result contains [AMT] [CURRENCYCODE] [TIMESTAMP] [CORRELATIONID]
     * [ACK] [VERSION] [BUILD] [L_ERRORCODE0] [L_SHORTMESSAGE0] [L_LONGMESSAGE0]
     * [L_SEVERITYCODE0]
     */
    /*
      $result = Yii::app()->Paypal->DoDirectPayment($paymentInfo);

      //Detect Errors
      if (!Yii::app()->Paypal->isCallSucceeded($result)) {
      if (Yii::app()->Paypal->apiLive === true) {
      //Live mode basic error message
      $error = 'We were unable to process your request. Please try again later';
      } else {
      //Sandbox output the actual error message to dive in.
      $error = $result['L_LONGMESSAGE0'];
      }
      echo $error;
      } else {
      //Payment was completed successfully, do the rest of your stuff
      }

      Yii::app()->end();
      }
     */

    public function actionConfirmExpressPay() {
        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);
        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);
        $user = clientUser::model()->findByPk(Yii::app()->user->id);
        $transaction = eTransaction::model()->findByAttributes(Array('response' => $token));
        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $transaction->price;
        if (Yii::app()->Paypal->isCallSucceeded($result)) {
            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            //var_dump($paymentResult);exit;
            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on DoExpressCheckout'));
                $this->redirect('/');
            }
        }
        else{
            Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on '.$token));
            $this->redirect('/');
        }

        $transaction = eTransaction::model()->findByPk(Yii::app()->session['transaction_id']);
        if ($transaction->save()) {

            $credittransaction = new eCreditTransaction;

            $credittransaction->game_type = "product_purchase";
            $credittransaction->type = "purchased";
            $credittransaction->user_id = $user->id;
            $credittransaction->trans_id = Yii::app()->session['transaction_id'];
            $credittransaction->prize_id = Yii::app()->session['prize_id'];
            $credittransaction->credits = 0;

            if ($credittransaction->save()) {
                $this->redirect($this->createUrl('/site/printReceipt'));
            }
        }
    }

    public function actionCancelExpressPay() {
        Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Purchase Cancelled'));
        $this->redirect($this->createUrl('/redeem'));
    }

    public function actionConfirmExpressPay2() {
        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);
        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);
        $user = clientUser::model()->findByPk(Yii::app()->user->id);
        $transaction = eTransaction::model()->findByAttributes(Array('response' => $token));
        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $transaction->price;
        if (Yii::app()->Paypal->isCallSucceeded($result)) {
            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on DoExpressCheckout'));
                $this->redirect('/');
            }
        }
        else{
            Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on '.$token));
            $this->redirect('/');
        }

        if (!empty(Yii::app()->session['transaction_id'])) {
            $user = clientUser::model()->findByPk(Yii::app()->user->id);
            $transaction = eTransaction::model()->findByPk(Yii::app()->session['transaction_id']);
            $transaction->key = $_GET['token'];
            if ($transaction->save()) {

                if(Yii::app()->session['gameChoiceResponseId'] != 1) {
                    $response = eGameChoiceResponse::model()->findByPk(Yii::app()->session['gameChoiceResponseId']);
                    $response->transaction_id = $transaction->id;
                    $response->save();
                }

                $creditTransaction = new eCreditTransaction;
                $creditTransaction->game_type = "sweepstakes";
                $creditTransaction->type = "earned";
                $creditTransaction->credits = 1;
                $creditTransaction->user_id = $user->id;
                $creditTransaction->trans_id = $transaction->id;
                if ($creditTransaction->save()) {
                    unset(Yii::app()->session['transaction_id']);
                }
            }
            $this->redirect("/paymentdone/thankyou/{$transaction->id}");
        }
    }

    public function actionCancelExpressPay2() {
        unset(Yii::app()->session['transaction_id']);
        unset(Yii::app()->session['gameChoiceResponseId']);
        Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Cancelled'));
        $this->redirect('/');
    }

    public function actionConfirmExpressPay3() {

        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);
        $amount = Yii::app()->session['amount'];
        $model = Yii::app()->session['model'];
        $prize_id = Yii::app()->session['prizeId'];
        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);

        $user = eUser::model()->findByAttributes(array('id' => Yii::app()->user->getId()));
        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));
        $userLocation = eUserLocation::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));
        $userLocation = (is_null($userLocation)) ? new clientUserLocation : $userLocation;

        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $amount;
        if (Yii::app()->Paypal->isCallSucceeded($result)) {
            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            if ($result['ACK']) {
                if (!is_null($model)) {
                    $prizeId = PaymentUtility::paypalExpressProduct($prize_id);
                    $prize = ePrize::model()->findByPk($prizeId);
                    $mailSend = MailUtility::send('confirm', $userEmail->email, array('link' => Yii::app()->createAbsoluteUrl("redeem/", array()),'prize' => $prize->name, 'credits' => '$'.$prize->market_value.'.00' ,'firstname' => isset($user->first_name) ? $user->first_name : 'John', 'lastname' => isset($user->last_name) ? $user->last_name : 'Doe','address' => $userLocation->address1, 'city' => $userLocation->city,'state' => $userLocation->state, 'zipcode' => $userLocation->postal_code, 'image' => "/" . basename(Yii::app()->params["paths"]["image"]) . "/{$prize->image}"), false);
                    unset(Yii::app()->session['model']);
                    unset(Yii::app()->session['prizeId']);
                    if ($mailSend) {
                         $this->redirect($this->createUrl('/site/confirmation'));
                    }
                }
            $transId = PaymentUtility::paypalPaymentPrepay($amount, $token);
            }

            $trans = eTransaction::model()->findByPk($transId);
            $mailSend = MailUtility::send('thankyou', $userEmail->email, array('link' => Yii::app()->createAbsoluteUrl("/", array()), 'amount' => $trans->price), false);
            unset(Yii::app()->session['amount']);

            if ($mailSend) {
                $game_id = Yii::app()->session['game_id'];
                if (empty($game_id)) {

                    if ($this->isMobile()) {
                        Yii::app()->user->setFlash('success', Yii::t('youtoo', 'Pago Exitoso'));
                        $this->redirect(Yii::app()->createURL("/site/index"));
                    }
                    $this->redirect(Yii::app()->createURL("/index.php?f=p"));
                } else {
                    $this->redirect(Yii::app()->createURL("/winlooseordraw/{$game_id}"));
                }
            }

            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on DoExpressCheckout'));
                $this->redirect('/payment');
            }
        } else {
            Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Payment Error on ' . $token));
            $this->redirect('/payment');
        }
    }

    public function actionCancelExpressPay3() {
        unset(Yii::app()->session['transaction_id']);
        unset(Yii::app()->session['gameChoiceResponseId']);

        Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Pago Cancelado'));
        $this->redirect('/payment');
    }

    public function actionCancelExpressPayProduct() {
        unset(Yii::app()->session['model']);
        unset(Yii::app()->session['prizeId']);

        Yii::app()->user->setFlash('error', Yii::t('youtoo', 'Compra producto Cancelado'));
        $this->redirect('/redeem');
    }

}
