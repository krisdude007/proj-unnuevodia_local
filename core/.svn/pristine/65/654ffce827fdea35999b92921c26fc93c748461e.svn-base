<?php

class GameController extends Controller {

    public $activeNavLink = 'play';
    public $layout = '//layouts/main';
    //public $layout = 'none';
    public $user;
    public $ticker;
    public $notification;

    function init() {
        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
            $this->ticker = new eTicker();
        }
    }

    public function actionIndex() {

    }

    public function actionThankYou() {

        unset(Yii::app()->session['transId']);
        $creditTransaction = Yii::app()->user->getState('creditTransaction');
        $gameChoiceAnswer = Yii::app()->user->getState('gameChoiceAnswer');
        $game = Yii::app()->user->getState('game');
        if (!(isset($gameChoiceAnswer->is_correct) && isset($creditTransaction->credits) && isset($game->price))) {
            Yii::app()->user->setFlash('error', Yii::t('youtoo', "Page has been expired"));
            $this->redirect(Yii::app()->createURL('site/index'));
        }
        Yii::app()->user->setState('creditTransaction', null);
        Yii::app()->user->setState('gameChoiceAnswer', null);
        Yii::app()->user->setState('game', null);
        $this->render('thankyou', array(
            'isCorrect' => $gameChoiceAnswer->is_correct,
            'credit' => $creditTransaction->credits,
            'date' => $creditTransaction->created_on,
            'orderNo' => ($creditTransaction->id + 10000),
            'price' => $game->price,
        ));
    }

    public function actionReveal($id) {
        $layout = false;

        $reveal = eGameReveal::model()->findByPk((int) $id);

        if ($reveal) {
            $this->render('reveal', array(
                'reveal' => $reveal,
            ));
        } else {
            echo "No game with this ID exists.";
            exit;
        }
    }

    public function actionMultiple($id = NULL) {
        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $response = new eGameChoiceResponse;
        $ivruserId = Yii::app()->session['transId'];
        if (empty($ivruserId)) {
            $this->redirect($this->createUrl('/playnow'));
        } else {
            if (Yii::app()->session['transId'] != '1234') {
                $trans = eGamingTransaction::model()->findByPk(Yii::app()->session['transId']);
                if (empty($trans->id)) {
                    $this->redirect($this->createUrl('/playnow'));
                }
            }
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'game-choice-form') {
            echo CActiveForm::validate($response);
            Yii::app()->end();
        }

        if (isset($_POST['eGameChoiceResponse'])) {
            $response->attributes = $_POST['eGameChoiceResponse'];
            $response->user_id = Yii::app()->user->getId();
            $responseUser = clientUser::model()->findByPk($response->user_id);


            if (empty($response->game_choice_answer_id)) {
                Yii::app()->user->setFlash('error', 'Please choose an answer.' );
                $this->redirect($this->createUrl('/game/multiple'));
            }

            if ($response->validate()) {
                $response->save();

                /* FOR IVR */

                $ivruser = eGameIvrOutbound::model()->findByAttributes(array('phonenumber' => $responseUser->username), 'gameplay=0');
                if(!empty($ivruser)) {
                $ivruser->gameplay = 1;
                $ivruser->save();
                }
                /* end for IVR */

                $transaction = new eCreditTransaction;
                $transaction->game_type = "game_choice";
                $transaction->game_id = $response->game_choice_id;
                $transaction->type = "earned";

                $answer = eGameChoiceAnswer::model()->findByPk($response->game_choice_answer_id);

                $transaction->credits = $answer->point_value;
                if (Yii::app()->session['transId'] == '1234') {
                    $transaction->trans_id = NULL;
                } else {
                    $transaction->trans_id = Yii::app()->session['transId'];
                }

                $transaction->save();

                Yii::app()->user->setState('creditTransaction', $transaction);
                Yii::app()->user->setState('gameChoiceAnswer', $answer);
                Yii::app()->user->setState('game', $game);

                $this->redirect($this->createUrl('/game/thankyou'));
            } else {
                Yii::app()->user->setFlash('error', "Errors found!");
            }
        }

        if ($game) {
            $this->render('multiple', array(
                'game' => $game,
                'response' => $response,
            ));
        } else {
            echo "No game with this ID exists.";
        }
    }

    public function actionMultiple2($id = NULL) {

        $user_id = Yii::app()->user->getId();

        $games = eGameChoice::model()->isActive()->asc()->findAll();

        if(empty($games)) {
            $this->redirect($this->createUrl("/game/allgamesplayed"));
        }

        $gameManager = GameUtility::gameManager($user_id);

        //var_dump($gameManager);
        //exit;

        if($gameManager['set']['on'] == 0) {
            $this->redirect($this->createUrl("/game/allgamesplayed"));
        }

        if(!$gameManager['is_paid']) {
            if($gameManager['user_response']['paid_responses'] == 0) {
                $this->redirect($this->createUrl("/payment/game_choice_response/{$gameManager['user_response']['last_response_id']}"));
            }
            else {
                $this->redirect($this->createUrl("/payment/game_choice_response"));
            }
        }
        else {
            if($gameManager['game_id'] == 0) {
                $this->redirect($this->createUrl("/game/allgamesplayed"));
            }
            else {
                $id = $gameManager['game_id'];
            }
        }

        if ($id == NULL) {
            $game = eGameChoice::model()->multiple()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->multiple()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $response = new eGameChoiceResponse;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'game-choice-form') {
            echo CActiveForm::validate($response);
            Yii::app()->end();
        }

        if (isset($_POST['eGameChoiceResponse'])) {
            $response->attributes = $_POST['eGameChoiceResponse'];

            if(empty($user_id)) {
                $response->user_id = 0;
            }
            else {
                $response->user_id = $user_id;
            }

            if($gameManager['is_paid']) {
                $response->transaction_id = $gameManager['transaction_id']; //transaction_id
            }

            $responseUser = clientUser::model()->findByPk($response->user_id);

            if (empty($response->game_choice_answer_id)) {
                Yii::app()->user->setFlash('error', 'Please choose an answer.' );
                $this->redirect($this->createUrl('/game/multiple2'));
            }

            if ($response->validate()) {
                $response->save();
                Yii::app()->session['gamechoiceresponseId'] = $response->id;

//                $transaction = new eCreditTransaction;
//                $transaction->game_type = "game_choice";
//                $transaction->game_id = $response->game_choice_id;
//                $transaction->type = "earned";
//
//                $answer = eGameChoiceAnswer::model()->findByPk($response->game_choice_answer_id);
//
//                $transaction->credits = $answer->point_value;
//
//                $transaction->save();

                //$this->redirect($this->createUrl("/payment/game_choice_response/{$response->id}"));

                if($response->user_id == 0) {
                    $this->redirect($this->createUrl("/loginpay"));
                }
                else {
                    $this->redirect($this->createUrl("/game/multiple2"));
                }

            } else {
                Yii::app()->user->setFlash('error', "Errors found!");
            }
        }

        if ($game) {
            $this->render('multiple', array(
                'game' => $game,
                'response' => $response,
                'game_manager' => $gameManager,
            ));
        } else {
            echo "No game with this ID exists.";
        }
    }

    public function actionHotornot($id = NULL) {
        if ($id == NULL) {
            $game = eGameChoice::model()->hotornot()->isActive()->with('gameChoiceAnswers')->find();
        } else {
            $game = eGameChoice::model()->hotornot()->with('gameChoiceAnswers')->findByPk((int) $id);
        }

        $response = new eGameChoiceResponse;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'game-choice-form') {
            echo CActiveForm::validate($response);
            Yii::app()->end();
        }

        if (isset($_POST['eGameChoiceResponse'])) {
            $response->attributes = $_POST['eGameChoiceResponse'];
            $response->user_id = Yii::app()->user->getId();

            if ($response->validate()) {
                $response->save();

                $transaction = new eCreditTransaction;
                $transaction->game_type = "game_choice";
                $transaction->game_id = $response->game_choice_id;
                $transaction->type = "earned";

                $answer = eGameChoiceAnswer::model()->findByPk($response->game_choice_answer_id);

                $transaction->credits = $answer->point_value;
                $transaction->save();
                Yii::app()->user->setState('creditTransaction', $transaction);
                Yii::app()->user->setState('gameChiceAnswer', $answer);
                Yii::app()->user->setState('game', $game);
                $this->redirect($this->createUrl('/game/thankyou'));
            } else {
                Yii::app()->user->setFlash('error', "Errors found!");
            }
        }

        if ($game) {
            $this->render('hotornot', array(
                'game' => $game,
                'response' => $response,
            ));
        } else {
            echo "No game with this ID exists.";
        }
    }

    public function actionAjaxRevealGridGet() {
        $layout = false;

        echo json_encode(GameUtility::revealGetGrid((int)$_POST['grid_id']));

        Yii::app()->end();
    }

    public function actionAllgamesplayed() {
        $this->render('allgamesplayed', array());
    }

}