<?php

class PaymentUtility {

    public static function paypal($model = false) {
        if (!$model) {
            return Array('response' => 'error', 'error' => 'no model passed');
        }
        $pricing = ePricing::model()->findByAttributes(Array('product' => $model->tableName()));
        // set

        if ($model->tableName() == 'prize') {
            $paymentInfo['Order']['theTotal'] = $model->credits_required;
        } else {
            $paymentInfo['Order']['theTotal'] = $pricing->price;
        }
        $paymentInfo['Order']['description'] = $model->tableName();
        $paymentInfo['Order']['quantity'] = '1';
        Yii::app()->session['Order'] = Array('model' => $model);

        // call paypal
        $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo); //var_dump($result);exit;
        //Detect Errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === false) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            return Array('response' => 'error', 'error' => $error);
            Yii::app()->end();
        } else {
            $token = urldecode($result["TOKEN"]);
            if ($model->tableName() == 'prize') {

                $transaction = new eTransaction;
                $transaction->user_id = Yii::app()->user->getId();
                $transaction->processor = 'paypal';
                $transaction->response = $token;
                $transaction->item = $model->tableName();
                $transaction->item_id = $model->id;
                $transaction->description = $paymentInfo['Order']['description'];
                $transaction->price = $paymentInfo['Order']['theTotal'];

                if ($transaction->save()) {
                    Yii::app()->session['prize_id'] = $model->id;
                    Yii::app()->session['transaction_id'] = $transaction->id;

                    return Array('response' => 'success', 'url' => Yii::app()->Paypal->paypalUrl . $token);
                }  else {
                    return Array('response' => 'error', 'error' => 'transaction not saved');
                }

            } else {
                // store order info
                $transaction = new eTransaction;
                $transaction->user_id = Yii::app()->user->getId();
                $transaction->processor = 'paypal';
                $transaction->response = $token;
                $transaction->item = $model->tableName();
                $transaction->item_id = $model->id;
                $transaction->description = $paymentInfo['Order']['description'];
                $transaction->price = $paymentInfo['Order']['theTotal'];
                if ($transaction->save()) {
                    // send user to paypal
                    Yii::app()->session['transaction_id'] = $transaction->id;
                    return Array('response' => 'success', 'url' => Yii::app()->Paypal->paypalUrl . $token);
                } else {
                    return Array('response' => 'error', 'error' => 'transaction not saved');
                }
            }
        }
    }

    public static function paypal2($amount = 5) {

        $paymentInfo['Order']['theTotal'] = $amount;
        if (Yii::app()->session['model'] == 'prize') {
          $paymentInfo['Order']['description'] = 'prize';
        }
        $paymentInfo['Order']['description'] = 'prepay';
        $paymentInfo['Order']['quantity'] = '1';

        // call paypal
        $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo); //var_dump($result);exit;
        //Detect Errors
        if (!Yii::app()->Paypal->isCallSucceeded($result)) {
            if (Yii::app()->Paypal->apiLive === false) {
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            return Array('response' => 'error', 'error' => $error);
            Yii::app()->end();
        } else {
            $token = urldecode($result["TOKEN"]);
            if (!empty($token)) {
                // send user to paypal
                return Array('response' => 'success', 'url' => Yii::app()->Paypal->paypalUrl . $token);
            } else {
                return Array('response' => 'error', 'error' => 'transaction not saved');
            }
        }
    }

    public static function luhn_check($number) {

        // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
        $number = preg_replace('/\D/', '', $number);

        // Set the string length and parity
        $number_length = strlen($number);
        $parity = $number_length % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ($i = 0; $i < $number_length; $i++) {
            $digit = $number[$i];
            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit*=2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit-=9;
                }
            }
            // Total up the digits
            $total+=$digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return ($total % 10 == 0) ? TRUE : FALSE;
    }

    public static function getPaypalPreapproval($maxAmount, $startingTime, $endingTime) {//set to upto max $20 charge.
        $key = Yii::app()->Paypal->GetPaypalPreapprovalKey($maxAmount, $startingTime, $endingTime);
        if (!empty($key)) {
            return Array('response' => 'success', 'key' => $key);
        }
        return Array('response' => 'error', 'error' => 'Fail to retrive preapproval key');
    }

    public static function capturePaypalPreapproval($key, $amount) {//capture to upto max $20 charge.
        $info['key'] = $key;
        $info['amount'] = $amount;
        if (empty($key) || empty($amount)) {
            return Array('response' => 'error', 'error' => 'Key or amount not valid');
        }
        $results = Yii::app()->Paypal->CapturePreapproval($info);
        if (!empty($results['payKey'])) {
            return Array('response' => 'success', 'payKey' => $results['payKey']);
        }
        var_dump($results);
        return Array('response' => 'error', 'error' => 'Fail to pay');
    }

    public static function stripePaymentGame($type = "game_choice", $id = 1, $token) {
        $id = (int)$id;

        if($type == "game_choice_response") {
            $model = eGameChoiceResponse::model()->findByPk($id);
        } else if($type == "game_choice") {
            $model = eGameChoice::model()->findByPk($id);
        } else {
            exit;
        }

        $stripe = StripeUtility::config();

        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));

        $customer = \Stripe\Customer::create(array(
                    'email' => $userEmail->email,
                    'card'  => $token
        ));

        $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => 100,
                    'currency' => 'usd'
        ));

        $pricing = ePricing::model()->findByAttributes(Array('product' => $model->tableName()));

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'stripe';
        $transaction->response = 'stripe';
        $transaction->item = $model->tableName();
        $transaction->item_id = $model->id;
        $transaction->description = $model->tableName();
        $transaction->price = $pricing->price;

        if(!$transaction->save()){
            var_dump($transaction->getErrors());
            exit();
        }

        //if ($transaction->item_id != 1) {
        //    $response = eGameChoiceResponse::model()->findByPk($transaction->item_id);
        //    $response->transaction_id = $transaction->id;
        //    $response->save();
        //}

        $creditTransaction = new eCreditTransaction;
        $creditTransaction->game_type = "sweepstakes";
        $creditTransaction->type = "earned";
        $creditTransaction->credits = 1;
        $creditTransaction->trans_id = $transaction->id;
        $creditTransaction->save();

        return $transaction->id;
    }

    public static function paypalDirectPayGame ($type = "game_choice", $id = 1, $token) {
        $id = (int)$id;

        if($type == "game_choice_response") {
            $model = eGameChoiceResponse::model()->findByPk($id);
        } else if($type == "game_choice") {
            $model = eGameChoice::model()->findByPk($id);
        } else {
            exit;
        }

        $pricing = ePricing::model()->findByAttributes(Array('product' => $model->tableName()));

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'paypal directpay';
        $transaction->response = $token;
        $transaction->item = $model->tableName();
        $transaction->item_id = $model->id;
        $transaction->description = $model->tableName();
        $transaction->price = $pricing->price;

        if (!$transaction->save()) {
            var_dump($transaction->getErrors());
            exit();
        }

        //if($transaction->item_id != 1) {
        //    $response = eGameChoiceResponse::model()->findByPk($transaction->item_id);
        //    $response->transaction_id = $transaction->id;
        //    $response->save();
        //}

        $creditTransaction = new eCreditTransaction;
        $creditTransaction->game_type = "sweepstakes";
        $creditTransaction->type = "earned";
        $creditTransaction->credits = 1;
        $creditTransaction->trans_id = $transaction->id;
        $creditTransaction->save();

        return $transaction->id;
    }

    public static function stripePaymentPrepay($amount = 5, $token) {

        $payCreditArray = Array("5" => "5", "10" => "13", "25" => "32", "50" => "65");

        $stripe = StripeUtility::config();

        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'type' => 'primary'));

        $customer = \Stripe\Customer::create(array(
                    'email' => $userEmail->email,
                    'card'  => $token
        ));

        $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $amount*100,
                    'currency' => 'usd'
        ));

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'stripe';
        $transaction->response = 'stripe';
        $transaction->item = 'prepay';
        $transaction->item_id = 1;
        $transaction->description = 'prepay';
        $transaction->price = $amount;

        if(!$transaction->save()){
            var_dump($transaction->getErrors());
            exit();
        }

        $creditTransaction = new eCreditTransaction;
        $creditTransaction->game_type = "sweepstakes";
        $creditTransaction->type = "earned";
        $creditTransaction->credits = $payCreditArray[$amount];
        $creditTransaction->trans_id = $transaction->id;
        $creditTransaction->save();

        return $transaction->id;
    }

    public static function paypalPaymentPrepay($amount = 5, $token) {

        $payCreditArray = Array("5" => "5", "10" => "13", "25" => "32", "50" => "65");

        $transaction = new eTransaction;
        $transaction->user_id = Yii::app()->user->getId();
        $transaction->processor = 'paypal';
        $transaction->response = $token;
        $transaction->item = 'prepay';
        $transaction->item_id = 1;
        $transaction->description = 'prepay';
        $transaction->price = $amount;

        if(!$transaction->save()){
            var_dump($transaction->getErrors());
            exit();
        }

        $creditTransaction = new eCreditTransaction;
        $creditTransaction->game_type = "sweepstakes";
        $creditTransaction->type = "earned";
        $creditTransaction->credits = $payCreditArray[$amount];
        $creditTransaction->trans_id = $transaction->id;
        $creditTransaction->save();

        return $transaction->id;
    }

    public static function paypalExpressProduct($id = NULL) {
        if(!empty($id)) {
            $prize = ePrize::model()->findByPk($id);
        }
        else {
            exit;
        }

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
                return $prize->id;
            } else {
                echo "Credit Transaction Error";
                exit;
            }

        } else {
            echo "Transaction Error";
            exit;
        }
    }
}
?>
