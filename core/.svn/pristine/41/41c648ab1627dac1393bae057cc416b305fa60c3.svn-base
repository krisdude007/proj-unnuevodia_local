<?php

class AdminQuestionController extends Controller {


    public $user;
    public $notification;
    public $layout = '//layouts/admin';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(

            array('allow',
                'actions' => array(
                    'index',
                    'save',
                    'ajaxSendTicker'
                ),
                'expression' => '(Yii::app()->user->isAdmin())',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
        Yii::app()->setComponents(array('errorHandler' => array('errorAction' => 'admin/error',)));
        $this->user = ClientUtility::getUser();
        $this->notification = eNotification::model()->orderDesc()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
    }

    /**
     *
     *
     * QUESTION EDITOR ACTIONS
     * This section contains everything required for the video question editor section of the admin
     *
     *
     */
    public function actionIndex($q_type = 'video') 
    {
        if($q_type == 'ticker' || $q_type == 'video'){
        } else {
            $q_type = 'video';
        }

        $model = new eQuestion;

        if($q_type == 'ticker'){
            $maxLengthQ = 140;
            $model->hashtag = Yii::app()->params['ticker']['defaultHashtag'];
            $is_ticker = 1;
        } else{
            $maxLengthQ = 255;
            $model->hashtag = Yii::app()->params['video']['defaultHashtag'];
            $is_ticker = 0;
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-questionEditor-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['eQuestion'])) {
            $model->attributes = $_POST['eQuestion'];
            if ($model->validate()) {
                $questions = eQuestion::model()->ticker()->notdeleted()->findAll();
                if (sizeof($questions) >= Yii::app()->params['maxActiveQuestions']) {
                    $model->end_time = date('Y-m-d', time());
                    Yii::app()->user->setFlash('message', "Question was added as inactive because the maximum limit of " . Yii::app()->params['maxActiveQuestions'] . " active questions was reached.");
                }
                $model->save();
                $model = new eQuestion;
                Yii::app()->user->setFlash('success', "Question Added!");
            } else {
                Yii::app()->user->setFlash('error', "Error");
            }
        }

        if(Yii::app()->user->isSuperAdmin())
        {
            $questions = eQuestion::model()->{$q_type}()->orderByIDDesc()->findAll();
        } else {
            $questions = eQuestion::model()->{$q_type}()->notdeleted()->orderByIDDesc()->findAll();
        }

        $this->render('index', array(
            'maxActives' => Yii::app()->params['maxActiveQuestions'],
            'questions' => $questions,
            'q_type' => $q_type,
            'is_ticker' => $is_ticker,
            'maxLengthQ' => $maxLengthQ,
            'model' => $model,
        ));
    }

    public function actionAjaxSendTicker()
    {
        if(Yii::app()->params['send_ticker'] && Yii::app()->request->isAjaxRequest) {
            if($question_id = Yii::app()->request->getPost('id'))
            {
                if (Yii::app()->params['ticker']['useExtendedFilters']) {
                    $tickersModel = eTicker::model()->with('user')->acceptedtv()->findAllByAttributes(Array('question_id' => $question_id));
                } else {
                    $tickersModel = eTicker::model()->with('user')->accepted()->findAllByAttributes(Array('question_id' => $question_id));
                }
                $entityTickers = eTicker::model()->accepted()->findAllByAttributes(Array('type' => 'entity'));
        
                $combinedTickers = TickerUtility::combineTickerWithEntityTickers($tickersModel, $entityTickers);
                foreach($combinedTickers as $ticker) {
                    Yii::app()->db2->createCommand('insert into ads (txt, cat) values (  ? , 3)')->execute(array($ticker->ticker));
                }
                echo 'Ticker sent successfully';
            } else {
                echo 'Invalid question';
            }
        } else {
            echo 'Access denied.';
        }
        Yii::app()->end();
    }
    
    public function actionSave() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $question = eQuestion::model()->findByPK($id);
        $question->$column = $value;
        $question->save();
        echo $value;
    }

}