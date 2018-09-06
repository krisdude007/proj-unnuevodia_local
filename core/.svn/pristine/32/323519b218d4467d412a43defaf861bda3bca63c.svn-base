<?php

class TickerController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $ticker;

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
            $this->ticker = new eTicker();
        }
    }

    public function actionAjaxStream() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        if(isset($destination)) {
            if($stream = eTickerStream::model()->current()->findByAttributes(Array('destination' => $destination))) {
                $impression = new eTickerImpression;
                if (!Yii::app()->user->isGuest) {
                    $impression->user_id = Yii::app()->user->getId();
                }
                $impression->stream_id = $stream->id;
                $impression->save();
                $ticker = eTicker::model()->with('user', 'entity', 'entity.images:isAvatar')->findByPK($stream->ticker_id);
                $user = eUser::model()->findByPK($ticker->user_id);
                $ret['ticker'] = $ticker['ticker'];
                $ret['image'] = TickerUtility::getAvatar($ticker);
                $ret['username'] = $user->username;
                echo json_encode($ret);
            }
        }
        Yii::app()->end();
    }

    public function actionIndex($id = 0) {

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
                )
        );
    }

    public function actionSave() {

        $this->layout = false;

        if (isset($_POST['eTicker'])) {
            $this->ticker->attributes = $_POST['eTicker'];
            $this->ticker->type = 'ticker';
            $this->ticker->source = 'web';
            $this->ticker->to_web = '1';
            $this->ticker->user_id = Yii::app()->user->getId();
            $this->ticker->arbitrator_id = Yii::app()->user->getId();

            if ($this->ticker->validate()) {
                Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['tickerSuccess']);
                $this->ticker->save();
            }
        } else {
            Yii::app()->user->setFlash('error', Yii::app()->params['flashMessage']['tickerError']);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAjaxSave() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $question_id = Yii::app()->params['ticker']['defaultQuestion'];
        $questions = eQuestion::model()->ticker()->current()->findAll();
        if (count($questions) > 0)
            $question_id = $questions[0]->id;
        $ticker = new eTicker;
        $ticker->ticker = $text;
        $ticker->type = 'ticker';
        $ticker->source = 'web';
        $ticker->to_web = '1';
        $ticker->question_id = $question_id;
        $ticker->user_id = Yii::app()->user->id;
        $ticker->arbitrator_id = Yii::app()->user->id;
        if ($ticker->validate()) {
            $ticker->save();
            echo Yii::app()->params['flashMessage']['tickerSuccess'];
        } else {
            echo Yii::app()->params['flashMessage']['tickerError'] . '' . $ticker->errors;
        }
    }

}

