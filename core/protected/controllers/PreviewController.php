<?php

class PreviewController extends Controller {

    public $layout = false;

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
    }

    public function actionQuestionTicker($id = 0) {
        $question = eQuestion::model()->findByPK($id);
        $pageSettings = NULL;
        $settings = eAppSetting::model()->ticker()->active()->findAll();
        $tvScreenSetting = eTvScreenAppearSetting::model()->findByAttributes(array('entity_type' => 'ticker'));
        $tvScreenSetting = (is_null($tvScreenSetting) ) ? new eTvScreenAppearSetting() : $tvScreenSetting;
        foreach ($settings as $k => $v) {
            $pageSettings[$v->attribute] = $v->value;
        }

        if (Yii::app()->params['ticker']['useExtendedFilters']) {
            $tickers = eTicker::model()->with('user')->acceptedtv()->findAllByAttributes(Array('question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'acceptedtv', 'type' => 'entity'));
        } else {
            $tickers = eTicker::model()->with('user')->accepted()->findAllByAttributes(Array('status' => 'accepted', 'question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'accepted', 'type' => 'entity'));
        }

        $combinedTickers = TickerUtility::combineTickerWithEntityTickers($tickers, $entityTickers);

        $this->render('ticker', array(
            'question' => $question,
            'tickers' => $combinedTickers,
            'settings' => $pageSettings,
            'tvScreenSetting' => $tvScreenSetting
                )
        );
    }
    
    public function actionQuestionTicker2($id = 0) {
        $question = eQuestion::model()->findByPK($id);
        $pageSettings = NULL;
        $settings = eAppSetting::model()->ticker()->active()->findAll();
        $tvScreenSetting = eTvScreenAppearSetting::model()->findByAttributes(array('entity_type' => 'ticker'));
        $tvScreenSetting = (is_null($tvScreenSetting) ) ? new eTvScreenAppearSetting() : $tvScreenSetting;
        foreach ($settings as $k => $v) {
            $pageSettings[$v->attribute] = $v->value;
        }

        if (Yii::app()->params['ticker']['useExtendedFilters']) {
            $tickers = eTicker::model()->with('user')->acceptedtv()->findAllByAttributes(Array('question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'acceptedtv', 'type' => 'entity'));
        } else {
            $tickers = eTicker::model()->with('user')->accepted()->findAllByAttributes(Array('status' => 'accepted', 'question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'accepted', 'type' => 'entity'));
        }

        $combinedTickers = TickerUtility::combineTickerWithEntityTickers($tickers, $entityTickers);

        $this->render('ticker', array(
            'question' => $question,
            'tickers' => $combinedTickers,
            'settings' => $pageSettings,
            'tvScreenSetting' => $tvScreenSetting
                )
        );
    }

    public function actionQuestionTickerTest($id = 0) {
        //$question = eQuestion::model()->findByPK($id);
        $question = eQuestion::model()->current()->ticker()->find();
        $question = (is_null($question) ) ? new eQuestion() : $question;
        $id = isset($question->id) ? $question->id : 0;
        $pageSettings = NULL;
        $settings = eAppSetting::model()->ticker()->active()->findAll();
        $tvScreenSetting = eTvScreenAppearSetting::model()->findByAttributes(array('entity_type' => 'ticker'));
        $tvScreenSetting = (is_null($tvScreenSetting) ) ? new eTvScreenAppearSetting() : $tvScreenSetting;
        foreach ($settings as $k => $v) {
            $pageSettings[$v->attribute] = $v->value;
        }

        if (Yii::app()->params['ticker']['useExtendedFilters']) {
            $tickers = eTicker::model()->with('user')->acceptedtv()->findAllByAttributes(Array('question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'acceptedtv', 'type' => 'entity'));
        } else {
            $tickers = eTicker::model()->with('user')->accepted()->findAllByAttributes(Array('status' => 'accepted', 'question_id' => $id), Array('order' => 'ifnull(ordinal, "1000"), ordinal ASC'));
            $entityTickers = eTicker::model()->findAllByAttributes(Array('status' => 'accepted', 'type' => 'entity'));
        }

        $combinedTickers = TickerUtility::combineTickerWithEntityTickers($tickers, $entityTickers);

        $this->render('testTickerPage', array(
            'question' => $question->question,
            'tickers' => $combinedTickers,
            'settings' => $pageSettings,
            'tvScreenSetting' => $tvScreenSetting
                )
        );
    }

    public function actionQuestionPoll($id = 0) {
        if(empty($id)){
            $activePoll = ePoll::model()->with('pollAnswers')->current()->questionType()->find();
        }
        else{
            $activePoll = ePoll::model()->with('pollAnswers')->findByPK($id);
        }
        $tvScreenSetting = eTvScreenAppearSetting::model()->findByAttributes(array('entity_type' => 'poll'));
        $tvScreenSetting = (is_null($tvScreenSetting) ) ? new eTvScreenAppearSetting() : $tvScreenSetting;

        $this->render('poll', array(
            'activePoll' => $activePoll,
            'tvScreenSetting' => $tvScreenSetting
        ));
    }
    
    public function actionQuestionPoll2($id = 0) {
        if(empty($id)){
            $activePoll = ePoll::model()->with('pollAnswers')->current()->questionType()->find();
        }
        else{
            $activePoll = ePoll::model()->with('pollAnswers')->findByPK($id);
        }
        $tvScreenSetting = eTvScreenAppearSetting::model()->findByAttributes(array('entity_type' => 'poll'));
        $tvScreenSetting = (is_null($tvScreenSetting) ) ? new eTvScreenAppearSetting() : $tvScreenSetting;

        $this->render('poll', array(
            'activePoll' => $activePoll,
            'tvScreenSetting' => $tvScreenSetting
        ));
    }

    public function actionQuestionPollTV($id = 0, $state = false) {

        $polls = ePoll::model()->current()->questionType()->findAll();
        $activePoll = null;
        if (!empty($polls)) {
            $activePoll = ($id != 0) ? ePoll::model()->with('pollAnswers')->findByPK($id) : $polls[0];
        }

        $sweepstake = null;
        $sweepstakeuser = null;
        if (Yii::app()->params['enableSweepstakes']) {
            $sweepstake = eSweepStake::model()->current()->find(); //->active()
            if (!is_null($sweepstake)) {
                $sweepstakeuser = eSweepStakeUser::model()->findByAttributes(Array('sweepstake_id' => $sweepstake->id, 'user_id' => Yii::app()->user->getId()));
            }
        }

        $this->render('pollTV', array(
            'activePoll' => $activePoll,
            'polls' => $polls,
            'state' => $state,
            'sweepstake' => $sweepstake,
            'sweepstakeuser' => $sweepstakeuser,
                )
        );
    }

}