<?php

class AdminLanguageController extends Controller {

    
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
                    'ajaxSave',
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
     * LANGUAGE ACTIONS
     * This section contains everything required for the language section of the admin
     * 
     * 
     */
    public function actionIndex() {
        $language = new eLanguageFilter();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-language-form') {
            echo CActiveForm::validate($language);
            Yii::app()->end();
        }
        if (isset($_POST['eLanguageFilter'])) {
            $language->attributes = $_POST['eLanguageFilter'];
            if ($language->validate()) {
                $language->save();
                Yii::app()->user->setFlash('success', "Filter Added!");
            } else {
                Yii::app()->user->setFlash('error', "Error");
            }
        }
        $filters = eLanguageFilter::model()->findAll(Array('order' => 'active DESC'));
        $this->render('index', array(
            'model' => $language,
            'filters' => $filters,
        ));
    }

    public function actionAjaxSave() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $filter = eLanguageFilter::model()->findByPK($id);
        $filter->$column = $value;
        $filter->save();
        echo $value;
    }
    
    
}