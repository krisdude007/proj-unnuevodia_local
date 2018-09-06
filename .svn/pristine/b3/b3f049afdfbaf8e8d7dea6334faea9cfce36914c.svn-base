<?php

class clientTickerController extends TickerController {

    public $layout = '//layouts/main';

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
    }

    public function actionIndex($id = 0) {

         Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());

        if ($id == 0) {
            $id = Yii::app()->params['ticker']['defaultQuestion'];
        }
        $tickerModel = new eTicker;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ticker-form') {
            echo CActiveForm::validate($tickerModel);
            Yii::app()->end();
        }
        $question_model = $id ? eQuestion::model()->findByPK($id) : eQuestion::model()->ticker()->current()->find() ;
        if($question_model) {
            $question = $question_model->question;
            $id = $question_model->id;
        }
        if (isset($_POST['eTicker'])) {
            $tickerModel->attributes = $_POST['eTicker'];
            $tickerModel->type = 'ticker';
            if ($tickerModel->validate()) {
                $tickerModel->user_id = Yii::app()->user->getId();
                $tickerModel->question_id = $id;
                $tickerModel->to_web = 1;
                $tickerModel->arbitrator_id = Yii::app()->user->getId();
                $q = eQuestion::model()->ticker()->current()->find();
                if (!empty($q)) {
                    $tickerModel->save();
                    Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['tickerSuccess']);
                    if($this->isMobile() && isset(Yii::app()->params['useMobileTheme']) == true) {
                    $this->redirect('/ticker/thanks');
                    }
                } else {
                    Yii::app()->user->setFlash('error', Yii::app()->params['flashMessage']['tickerInactive']);
                    $this->redirect('/ticker');
                }
                if (Yii::app()->Paypal->active) {
                    $paypal = PaymentUtility::paypal($tickerModel);
                    if ($paypal['response'] == 'success') {
                        $this->redirect($paypal['url']);
                    } else {
                        var_dump($paypal);
                        //$this->redirect(Yii::app()->createURL('/thanks'));
                    }
                } else {
                    $this->redirect(Yii::app()->createURL('/ticker'));
                }
            } else {
                //Yii::app()->user->setFlash('error', ERROR_TICKER_NOT_ADDED);
            }
        }

        $criteria = new CDbCriteria();
        $criteria->limit = 100;

        $curQuestions = eQuestion::model()->ticker()->recent()->findAll();
        foreach ($curQuestions as $questions) {
            $inQuestions[] = $questions->id;
        }
        $tickers = eTicker::model()->accepted()->with('user')->recent()->findAllByAttributes(Array('question_id' => $inQuestions), $criteria);
        $this->render('index', array(
            'question' => isset($question) ? $question : false,
            'question_id' => $id,
            'tickers' => $tickers,
            'tickerModel' => $tickerModel,
        ));
    }
    function actionThanks(){
        $this->render('thanks');
    }
}

