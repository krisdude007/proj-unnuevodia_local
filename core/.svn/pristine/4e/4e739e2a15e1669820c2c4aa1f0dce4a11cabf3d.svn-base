<?php

class AdminPrizeController extends Controller {

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
                    'update',
                    'enable',
                    'disable',
                    'export'
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
    public function actionExport() {
        /*
         * From Phillip -
         * in the admin prize manager can you create a link that will export a csv report showing
         * all prizes purchase by users, so it will give user phone/username, prize, credit cost, date
         */

        Yii::import('ext.ECSVExport');
        $filename = 'PrizeExport_' . time() . '.csv';
        $filepath = sys_get_temp_dir() . '/' . $filename;

        $credit_transactions = eCreditTransaction::getSpentCreditTransactions();

        if (!is_null($credit_transactions)) {
            $data = array();
            foreach ($credit_transactions as $credit_transaction) {
                $data[] = array('user' => $credit_transaction->user->username,
                    'game_type' => (!is_null($credit_transaction->game_type)) ? $credit_transaction->game_type : 'null',
                    'prize' => (!is_null($credit_transaction->prize)) ? $credit_transaction->prize->name : 'null',
                    'credit_cost' => $credit_transaction->credits,
                    'date' => $credit_transaction->created_on);
            }
        } else {
            $data = array(array('key1' => 'value1', 'key2' => 'value2'));
        }

        $csv = new ECSVExport($data);
        $csv->toCSV($filepath); // returns string by default

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Pragma: no-cache');
        readfile($filepath);
        Yii::app()->end();
    }

    public function actionIndex() {

        $prizeModel = new ePrize;
        $prizes = new ePrize('search');
        $prizes->unsetAttributes();

        if (isset($_GET['ePrize'])) {
            $prizes->attributes = $_GET['ePrize'];
        }

        if (isset($_POST['ePrize'])) {
            $prizeModel->attributes = $_POST['ePrize'];
            $prizeModel->image = CUploadedFile::getInstance($prizeModel, 'image');
            $prizeModel->user_id = Yii::app()->user->id;
            $prizeModel->enabled = 1;
            $prizeModel->created_on = new CDbExpression('NOW()');
            $prizeModel->updated_on = new CDbExpression('NOW()');

            if ($prizeModel->validate()) {
                preg_match('/\..{3,4}$/', $prizeModel->image->getName(), $matches);
                $filetype = $matches[0];
                $filename = "prize_" . uniqid('', true) . $filetype;
                $prizeModel->image->saveAs(Yii::app()->params['paths']['image'] . "/{$filename}");
                $prizeModel->image = $filename;
                $prizeModel->save();
                Yii::app()->user->setFlash('success', "New prize created.");
                $this->redirect(array('admin/prize'));
            } else {
                Yii::app()->user->setFlash('error', "Unable to create prize.");
            }
        }
        $tickerQuestions = array();
        $videoQuestions = array();
        $questions = eQuestion::model()->ticker()->current()->findAll();
        foreach ($questions as $question) {
            $tickerQuestions[$question->id] = $question->question;
        }
        $questions = eQuestion::model()->video()->current()->findAll();
        foreach ($questions as $question) {
            $videoQuestions[$question->id] = $question->question;
        }

        $this->render('index', array(
            'prizeModel' => $prizeModel,
            'tickerQuestions' => $tickerQuestions,
            'videoQuestions' => $videoQuestions,
            'prizes' => $prizes,
        ));
    }

    public function actionUpdate($id = NULL) {

        if (!is_null($id) && is_numeric($id)) {
            $prizeModel = ePrize::model()->findByPk($id);
        } else {
            throw new CHttpException(404, 'Invalid prize id was provided.');
        }

        if (isset($_POST['ePrize'])) {
            $prizeModel->attributes = $_POST['ePrize'];
            $prizeModel->user_id = Yii::app()->user->id;
            $prizeModel->updated_on = new CDbExpression('NOW()');

            if ($prizeModel->validate()) {
                $instance = CUploadedFile::getInstance($prizeModel, 'image');
                if (!is_null($instance)) {
                    $prizeModel->image = $instance;
                    preg_match('/\..{3,4}$/', $prizeModel->image->getName(), $matches);
                    $filetype = $matches[0];
                    $filename = "prize_" . uniqid('', true) . $filetype;
                    $prizeModel->image->saveAs(Yii::app()->params['paths']['image'] . "/{$filename}");
                    $prizeModel->image = $filename;
                }
                $prizeModel->save();
                Yii::app()->user->setFlash('success', "Prize updated.");
                $this->redirect(array('admin/prize'));
            } else {
                Yii::app()->user->setFlash('error', "Unable to update prize.");
            }
        }

        $tickerQuestions = array();
        $videoQuestions = array();
        $questions = eQuestion::model()->ticker()->current()->findAll();
        foreach ($questions as $question) {
            $tickerQuestions[$question->id] = $question->question;
        }
        $questions = eQuestion::model()->video()->current()->findAll();
        foreach ($questions as $question) {
            $videoQuestions[$question->id] = $question->question;
        }

        $this->render('update', array(
            'prizeModel' => $prizeModel,
            'tickerQuestions' => $tickerQuestions,
            'videoQuestions' => $videoQuestions,
        ));
    }

    public function actionEnable($id = NULL) {
        if (is_null($id) || !is_numeric($id)) {
            throw new CHttpException(404, 'No id was provided.');
        }

        $prizeModel = ePrize::model()->findByPk($id);
        if (!is_null($prizeModel)) {
            $prizeModel->enabled = 1;
            $prizeModel->updated_on = new CDbExpression('NOW()');
            $prizeModel->save();
            Yii::app()->user->setFlash('success', "Prize has been enabled.");
        } else {
            throw new CHttpException(404, 'Prize does not exist.');
        }

        $this->redirect(array('admin/prize'));
        Yii::app()->end();
    }

    public function actionDisable($id = NULL) {
        if (is_null($id) || !is_numeric($id)) {
            throw new CHttpException(404, 'No id was provided.');
        }

        $prizeModel = ePrize::model()->findByPk($id);
        if (!is_null($prizeModel)) {
            $prizeModel->enabled = 0;
            $prizeModel->updated_on = new CDbExpression('NOW()');
            $prizeModel->save();
            Yii::app()->user->setFlash('success', "Prize has been disabled.");
        } else {
            throw new CHttpException(404, 'Prize does not exist.');
        }

        $this->redirect(array('admin/prize'));
        Yii::app()->end();
    }

}
