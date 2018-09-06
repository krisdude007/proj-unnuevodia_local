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
                    'gameChoice',
                    'saveChoice',
                    'ajaxRevelGridSave',
                    'createNewGameReveal'
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
    public function actionIndex() 
    {
        $this->render('index', array(
        ));
    }
    
    public function actionGameReveal($id = NULL)
    {
        if(is_null($id)) {
            $game = new eGameReveal;
        }
        else
        {
            $game = eGameReveal::model()->findByPk($id);
        }
        
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'admin-gameEditor-form') {
            echo CActiveForm::validate($game);
            Yii::app()->end();
        }
        
        if(isset($_POST['eGameReveal'])) {
            $game->attributes = $_POST['eGameReveal'];
            if ($game->validate()) {
                $game->save();
                $game = new eGameReveal;
                Yii::app()->user->setFlash('success', "Game Added!");
            } else {
                Yii::app()->user->setFlash('error', "Error");
            }
        }
        
        if(Yii::app()->user->isSuperAdmin())
        {
            $games = eGameReveal::model()->orderByIDDesc()->findAll();
        } else {
            $games = eGameReveal::model()->notdeleted()->orderByIDDesc()->findAll();
        }
        
        $this->render('reveal', array(
            'games' => $games,
            'game' => $game,
        ));
    }
    
    public function actionGameChoice($type, $id = NULL)
    {
        if($type == 'multiple' || $type == 'hotornot') { 
            
        }
        else {
            exit;
        }
        
        if (is_null($id)) {
            $game = new eGameChoice;
            
            if($type == 'multiple') {
                $gameChoiceAnswers = Array(new eGameChoiceAnswer,
                                           new eGameChoiceAnswer,
                                           new eGameChoiceAnswer,
                                           new eGameChoiceAnswer);
            }
            else {
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
            $game->user_id = Yii::app()->user->getId();
            $valid = ($game->validate()) ? 'true' : false;
            
            $isCorrect = 0;
            
            foreach ($gameChoiceAnswers as $i => $answer) {
                if (isset($_POST['eGameChoiceAnswer'][$i])) {
                    $answer->attributes = $_POST['eGameChoiceAnswer'][$i];
                    $answer->user_id = Yii::app()->user->getId();
                    $isCorrect = $isCorrect + $answer->is_correct;
                    $valid = $answer->validate() && $valid;
                }
            }
            
            if($isCorrect == 0) {
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
                
                $games = eGameChoice::model()->{$type}()->recent()->with('gameChoiceAnswers')->findAll();
            } else {
                if($isCorrect == 0) {
                    Yii::app()->user->setFlash('error', "Please mark at least one correct answer.");
                }
                else {
                    Yii::app()->user->setFlash('error', "Errors found!");
                }
            }
        }

        $games = eGameChoice::model()->{$type}()->recent()->with('gameChoiceAnswers')->findAll();
        
        $this->render('choice', array(
            'games' => $games,
            'type' => $type,
            'models' => Array(
                        'game' => $game,
                        'gameChoiceAnswers' => $gameChoiceAnswers,
            ),
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
        
        if($old_is_active == 0 && $new_is_active == 1)
        {
            if($game->num_plays == 0)
            {
                
            }
            else
            {
                exit;
            }
        }
        
        GameUtility::pickWinnerRand($old_is_active, $new_is_active, $game->id);
        $game->save();
        
        echo $value;
    }
    
    public function actionAjaxRevelGridSave() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        
        $grid_id = (integer)$grid_id;
        $grid_section = (integer)$grid_section;
        $is_shown = (integer)$is_shown;
        
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
        
        for($i=1; $i<=$reveal->grid_w_squares*$reveal->grid_h_squares; $i++)
        {
            $grid = new eGameRevealGrid();
            $grid->user_id = Yii::app()->user->getId();
            $grid->reveal_id = 2;
            $grid->grid_section = $i;
            $grid->save();
        }
                
        echo 'Game Created';
    }
}