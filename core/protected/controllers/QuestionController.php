<?php

class QuestionController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $ticker; // used for ticker form shown on every page when user is logged in

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

    public function actionIndex($type = 'video') {
        
        if($type == 'poll') {
            $questions = ePoll::model()->current()->findAll();
        }
        else if($type == 'video' || $type == 'ticker') {
            $questions = eQuestion::model()->{$type}()->current()->findAll();
        }
        else {
            exit;
        }
        
        $this->render('index',
            array(
                'type' =>$type,
                'questions' => $questions
                 )
        );

    }
    /*
    public function filters() {
        return array(
            array(
                'COutputCache + index',
                'duration' => 60,
                'requestTypes' => array('GET'),
                'cacheID' => 'cache',
            ),
        );
    }
     */
}