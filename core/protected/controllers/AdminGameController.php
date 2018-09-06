<?php

class AdminGameController extends Controller {

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
                    'gameReveal',
                    'gameWordScramble',
                    'gameChoice',
                    'saveChoice',
                    'setPeriodWinner',
                    'periodWinner',
                    'ajaxRevelGridSave',
                    'createNewGameReveal',
                    'printInvoice',
                    'gameReport',
                    'processTwitterVotes',
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
        if (empty(Yii::app()->params['game_reveal_dimension'])) {
            Yii::app()->params['game_reveal_dimension'] = '800x600';
            Yii::app()->params['game_reveal_directory'] = Yii::app()->params['paths']['image'];
        }
    }

    public function actionProcessTwitterVotes() {
        $gamingAccountMentions = TwitterUtility::getGamingAccountMentions();
        if (empty($gamingAccountMentions)) {
            Yii::app()->user->setFlash('success', 'All results have been processed.');
        } elseif ($gamingAccountMentions == 'Rate limit exceeded') {
            Yii::app()->user->setFlash('error', 'Twitter process rate limit has exceeded. Please wait for a while.');
        }
        $this->render('index', array(
            'gamingAccountMentions' => $gamingAccountMentions,
        ));
    }

    public function actionPrintInvoice($type = NULL, $id = NULL) {
        $this->layout = NULL;
        $game = NULL;
        $user = NULL;
        $prize = NULL;
        if (!is_null($id)) {
            if ($type == 'game') {
                $game = eGameChoice::model()->with('gameChoiceAnswers:isCorrect')->findByPk($id);
                $user = eUser::model()->with('userLocations:primary')->findByPk($game->winner_id);
            } else if ($type == 'product') {
                $transaction = eCreditTransaction::model()->findByPk($id);
                $user = eUser::model()->with('userLocations:primary')->findByPk($transaction->user_id);

                $prize = ePrize::model()->findByPk($transaction->prize_id);
            } else {
                exit;
            }
        } else {
            exit;
        }

        if ($type == 'game') {
            $this->render('printInvoiceGame', array(
                'game' => $game,
                'user' => $user,
                'prize' => $prize,
            ));
        } else {
            $this->render('printInvoiceProduct', array(
                'transaction' => $transaction,
                'user' => $user,
                'prize' => $prize,
            ));
        }
    }

    /**
     *
     *
     * QUESTION EDITOR ACTIONS
     * This section contains everything required for the video question editor section of the admin
     *
     *
     */
    public function actionIndex() {
        $this->render('index', array(
        ));
    }

    public function actionGameReveal($id = NULL) {
        if (is_null($id)) {
            $game = new eGameReveal;
        } else {
            $game = eGameReveal::model()->findByPk($id);
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-gameEditor-form') {
            echo CActiveForm::validate($game);
            Yii::app()->end();
        }

        if (isset($_POST['eGameReveal'])) {
            $file = CUploadedFile::getInstance($game, 'grid_background');
            if(empty($file))//fix set to '' when grid backgound is not set.
                unset($_POST['eGameReveal']['grid_background']);
            $game->attributes = $_POST['eGameReveal'];
            if ($game->validate()) {
                $game->save();
                
                if (!empty($file)) {
                    $size = getimagesize($file->getTempName());
                    if (!empty($size)) {
                        $valid_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
                        if (in_array($size[2], $valid_types)) {
                            //remove dimention required.
                            //if ($size[0] . 'x' . $size[1] === Yii::app()->params['game_reveal_dimension']) {
                                $fileName = 'GR_'.uniqid('', true) . "." . $file->getExtensionName();
                                $file->saveAs(Yii::app()->params['game_reveal_directory'] . '/' .$fileName);
                                $game->grid_background = '/userimages/'.$fileName;
                                $game->save();
                                
                                Yii::app()->user->setFlash('success', "Game Saved!");
                                $this->redirect('/admin/gamereveal');
                            //} else {
                            //    $game->addError('grid_background', 'Size must be ' . Yii::app()->params['game_reveal_dimension']);
                            //}
                        }
                        else{
                            $game->addError('grid_background', 'Invalid image.');
                        }
                    }
                    else {
                        $game->addError('grid_background', 'Invalid image.');
                    }
                }else{
                    Yii::app()->user->setFlash('success', "Game Saved!");
                    $this->redirect('/admin/gamereveal');
                }
            }
        }

        if (Yii::app()->user->isSuperAdmin()) {
            $games = eGameReveal::model()->orderByIDDesc()->findAll();
        } else {
            $games = eGameReveal::model()->notdeleted()->orderByIDDesc()->findAll();
        }

        $this->render('reveal', array(
            'games' => $games,
            'game' => $game,
        ));
    }

    public function actionGameWordScramble($id = NULL) {
        if (is_null($id)) {
            $game = new eGameWordScramble();
        } else {
            $game = eGameWordScramble::model()->findByPk($id);
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-gameEditor-form') {
            echo CActiveForm::validate($game);
            Yii::app()->end();
        }

        if (isset($_POST['eGameWordScramble'])) {
            $game->attributes = $_POST['eGameWordScramble'];
            if ($game->validate()) {
                $game->save();
                
                Yii::app()->user->setFlash('success', "Game Saved!");
                $this->redirect('/admin/gamewordscramble');
            }
        }

        if (Yii::app()->user->isSuperAdmin()) {
            $games = eGameWordScramble::model()->orderByIDDesc()->findAll();
        } else {
            $games = eGameWordScramble::model()->notdeleted()->orderByIDDesc()->findAll();
        }

        $this->render('wordscramble', array(
            'games' => $games,
            'game' => $game,
        ));
    }
    
    public function actionGameChoice($type, $anum = 4, $id = NULL) {
        if ($type == 'multiple' || $type == 'hotornot' || $type == 'sub') {

        } else {
            exit;
        }

        if ($anum == 2 || $anum == 3 || $anum == 4) {

        } else {
            exit;
        }
        
        if(!empty($_GET['g'])) {
            $g = $_GET['g'];
        } else {
            $g = null;
        }
        
        if($g == 'open' || $g == 'ended' || $g == 'all' || $g == null) {
            
        } else {
            exit;
        }

        if (is_null($id)) {
            $game = new eGameChoice;
            $game->open_date = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s")));
            $game->close_date = date('Y-m-d H:i:s', strtotime('+7 days', strtotime(date("Y-m-d H:i:s"))));

            if ($type == 'multiple' || $type == 'sub') {
                if ($anum == 2) {
                    $gameChoiceAnswers = Array(new eGameChoiceAnswer,
                        new eGameChoiceAnswer);
                } else if ($anum == 3) {
                    $gameChoiceAnswers = Array(new eGameChoiceAnswer,
                        new eGameChoiceAnswer,
                        new eGameChoiceAnswer);
                } else {
                    $gameChoiceAnswers = Array(new eGameChoiceAnswer,
                        new eGameChoiceAnswer,
                        new eGameChoiceAnswer,
                        new eGameChoiceAnswer);
                }
            } else {
                $gameChoiceAnswers = Array(new eGameChoiceAnswer,
                    new eGameChoiceAnswer);
            }
        } else {
            $game = eGameChoice::model()->{$type}()->with('gameChoiceAnswers')->findByPK($id);
            foreach ($game->gameChoiceAnswers as $answer) {
                $gameChoiceAnswers[] = eGameChoiceAnswer::model()->findByPK($answer->id);
            }
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-game-choice-form') {
            $gameValidate = CActiveForm::validate(array($game));
            $gameAnswersValidate = CActiveForm::validateTabular($gameChoiceAnswers);
            echo json_encode(CMap::mergeArray(json_decode($gameValidate, true), json_decode($gameAnswersValidate, true)));
            Yii::app()->end();
        }

        if (isset($_POST['eGameChoice'], $_POST['eGameChoiceAnswer'])) {
            
            $game->attributes = $_POST['eGameChoice'];
            $game->close_date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['eGameChoice']['close_date'])));
            $game->open_date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['eGameChoice']['open_date'])));
            $game->user_id = Yii::app()->user->getId();
            $valid = ($game->validate()) ? 'true' : false;
            
            //if($type == 'sub') {
            //    $game->g_parant_id = $_POST['eGameChoice']['g_parant_id'];
            //}

            $isCorrect = 0;

            foreach ($gameChoiceAnswers as $i => $answer) {
                if (isset($_POST['eGameChoiceAnswer'][$i])) {
                    $answer->attributes = $_POST['eGameChoiceAnswer'][$i];
                    $answer->user_id = Yii::app()->user->getId();
                    $isCorrect = $isCorrect + $answer->is_correct;
                    $valid = $answer->validate() && $valid;
                }
            }

            if ($isCorrect == 0 || $isCorrect > 1) {
                $valid = false;
            }

            if ($valid) {
                Yii::app()->user->setFlash('success', "Game Added!");
                $game->save();
                foreach ($gameChoiceAnswers as $answer) {
                    if (isset($answer->user_id)) {
                        $answer->game_choice_id = $game->id;
                        $answer->save();
                    }
                }

                $answerNum = eGameChoiceAnswer::model()->countByAttributes(Array('game_choice_id' => $game->id));

                if ($answerNum < $anum + 1) {
                    $unintelligibleAnswer = new eGameChoiceAnswer;
                    $unintelligibleAnswer->label = 'E';
                    $unintelligibleAnswer->answer = 'Auto';
                    $unintelligibleAnswer->point_value = 10;
                    $unintelligibleAnswer->user_id = Yii::app()->user->getId();
                    $unintelligibleAnswer->game_choice_id = $game->id;
                    $unintelligibleAnswer->save();

                    $unintelligibleAnswer = new eGameChoiceAnswer;
                    $unintelligibleAnswer->label = '#';
                    $unintelligibleAnswer->answer = 'Unintelligible';
                    $unintelligibleAnswer->point_value = 10;
                    $unintelligibleAnswer->user_id = Yii::app()->user->getId();
                    $unintelligibleAnswer->game_choice_id = $game->id;
                    $unintelligibleAnswer->save();
                }

                //$games = eGameChoice::model()->{$type}()->recent()->with('gameChoiceAnswers')->findAll(); not sure why its here same line runs below
            } else {
                if ($isCorrect == 0 || $isCorrect > 1) {
                    Yii::app()->user->setFlash('error', "Please mark one correct answer.");
                } else {
                    Yii::app()->user->setFlash('error', "Errors found!");
                }
            }
        }

        if (Yii::app()->user->isSuperAdmin()) {
            if($g == 'open') {
                $games = eGameChoice::model()->{$type}()->isActive()->orderByCloseAsc()->with('gameChoiceAnswers')->findAll();
            } else if($g == 'ended') {
                $games = eGameChoice::model()->{$type}()->isNotActive()->orderByCloseDesc()->with('gameChoiceAnswers')->findAll();
            } else if($g == 'all') {
                $games = eGameChoice::model()->{$type}()->orderByCloseDesc()->with('gameChoiceAnswers')->findAll();
            }
            else {
                $games = null;
            }
        } else {
            $games = eGameChoice::model()->{$type}()->recent()->notdeleted()->with('gameChoiceAnswers')->findAll();
        }
        
        
        $mainGamesArray = Array();
        $mainGames = NULL;
        
        if($type == 'sub') {
            $mainGames = eGameChoice::model()->main()->recent()->findAll();
            
            foreach($mainGames as $mg) {
                $mainGamesArray[$mg->id] = $mg->question.' ('.$mg->id.')';
            }
        }

        $this->render('choice', array(
            'games' => $games,
            'mainGames' => $mainGamesArray,
            'type' => $type,
            'anum' => $anum,
            'g' => $g,
            'models' => Array(
                'game' => $game,
                'gameChoiceAnswers' => $gameChoiceAnswers,
            ),
        ));
    }

    public function actionGameReport($game_id) {

        //GameUtility::sendEmailEndGame($game_id); //test

        $this->layout = NULL;
        $game_id = (int) $game_id;

        $game = eGameChoice::model()->{'multiple'}()->with('gameChoiceAnswers')->findByPK($game_id);

        $responces = eGameChoiceResponse::model()->recentASC()->with('gameChoiceAnswer')->with('gameChoiceSmsOutbound')->with('user')->FindAllByAttributes(Array('game_choice_id' => $game_id));

        if ($game->start_date != NULL) {
            $startDate = $game->start_date;
        } else {
            $startDate = $game->created_on;
        }

        if ($game->is_active) {
            $endDate = gmdate("D, d M Y H:i:s");
        } else {
            $endDate = $game->end_date;
        }

        $registered = eUser::model()->filterByDates($startDate, $endDate)->count();

        if (!is_null($responces)) {
            $this->render('GameReport', array(
                'game' => $game,
                'responces' => $responces,
                'registered' => $registered,
            ));
        } else {
            echo 'no data';
            exit;
        }
    }

    public function actionPeriodWinner() {

        for ($i = 0; $i <= DateTimeUtility::getIsoWeeksInYear(date('Y')); $i++) {
            GameUtility::setPeriodWinner('week', 0, $i, 0, date('Y'));
        }

        for ($i = 1; $i <= 12; $i++) {
            GameUtility::setPeriodWinner('month', 1, 0, $i, date('Y'));
        }

        $weekWinners = eGameWinner::model()->week()->notdeleted()->with('user')->findAll();
        $monthWinners = eGameWinner::model()->month()->notdeleted()->with('user')->findAll();

        $this->render('winners', array(
            'weekWinners' => $weekWinners,
            'monthWinners' => $monthWinners
        ));
    }

    public function actionSaveChoice() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $game = eGameChoice::model()->findByPK($id);

        $old_is_active = $game->is_active;
        $game->$column = $value;
        $new_is_active = $game->is_active;

        if ($old_is_active == 0 && $new_is_active == 1) {
            if ($game->num_plays_paid == 0) {

            } else {
                exit;
            }
        }

        if ($old_is_active == 0 && $new_is_active == 1) { //set start date
            $game->start_date = date("Y-m-d H:i:s");
        }

        if ($old_is_active == 1 && $new_is_active == 0) { //set end date
            $game->end_date = date("Y-m-d H:i:s");
        }

        $game->save();

        GameUtility::pickWinnerRand($old_is_active, $new_is_active, $game->id);

        echo $value;
    }

    public function actionAjaxRevelGridSave() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }

        $grid_id = (integer) $grid_id;
        $grid_section = (integer) $grid_section;
        $is_shown = (integer) $is_shown;

        $revealGrid = eGameRevealGrid::model()->findByAttributes(array('reveal_id' => $grid_id, 'grid_section' => $grid_section));

        $revealGrid->saveAttributes(array('is_shown' => $is_shown));

        echo json_encode(Array('status' => 'success', 'grid_section' => $revealGrid->grid_section, 'is_shown' => $revealGrid->is_shown));
    }

    public function actionCreateRevealNewGame() {
        $this->layout = false;
        $reveal = new eGameReveal();
        $reveal->user_id = Yii::app()->user->getId();
        $reveal->title = 'Test';
        $reveal->grid_w = 800;
        $reveal->grid_h = 600;
        $reveal->grid_w_squares = 5;
        $reveal->grid_h_squares = 5;
        $reveal->grid_background = '/core/webassets/images/test/women-face.jpg';
        $reveal->square_color = 'CCCCCC';
        $reveal->control_scale = 2;
        $reveal->is_active = 1;
        $reveal->save();

        for ($i = 1; $i <= $reveal->grid_w_squares * $reveal->grid_h_squares; $i++) {
            $grid = new eGameRevealGrid();
            $grid->user_id = Yii::app()->user->getId();
            $grid->reveal_id = 2;
            $grid->grid_section = $i;
            $grid->save();
        }

        echo 'Game Created';
    }

}
