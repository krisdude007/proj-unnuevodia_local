<?php

class clientQuestionController extends QuestionController {

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
        if ($this->isMobile() && Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect('/login');
        }
        $this->render('index',
                      array(
                          'type' =>$type,
                          'questions' => eQuestion::model()->{$type}()->current()->findAll()
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