<?php

class PaymentUtility {    
    public static function paypal($model=false) {        
        if(!$model){
            return Array('response'=>'error','error'=>'no model passed');
        }        
        $pricing = ePricing::model()->findByAttributes(Array('product'=>$model->tableName()));
        // set 
        $paymentInfo['Order']['theTotal'] = $pricing->price;
        $paymentInfo['Order']['description'] = $model->tableName();
        $paymentInfo['Order']['quantity'] = '1';
        Yii::app()->session['Order'] = Array('model'=>$model);

        // call paypal 
        $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo); 
        //Detect Errors 
        if(!Yii::app()->Paypal->isCallSucceeded($result)){ 
            if(Yii::app()->Paypal->apiLive === true){
                //Live mode basic error message
                $error = 'We were unable to process your request. Please try again later';
            } else {
                //Sandbox output the actual error message to dive in.
                $error = $result['L_LONGMESSAGE0'];
            }
            return Array('response'=>'error','error'=>$error);
            Yii::app()->end();
        } else { 
            $token = urldecode($result["TOKEN"]); 
            // store order info
            $transaction = new eTransaction;
            $transaction->user_id = Yii::app()->user->getId();
            $transaction->processor = 'paypal';
            $transaction->response = $token;
            $transaction->description = $paymentInfo['Order']['description'];
            $transaction->price = $paymentInfo['Order']['theTotal'];
            $transaction->save();
            // send user to paypal 
            return Array('response'=>'success','url'=>Yii::app()->Paypal->paypalUrl.$token); 
        }
    }
}
?>
