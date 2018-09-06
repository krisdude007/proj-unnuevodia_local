<?php

class AdminAuditController extends Controller {

    
    public $user;
    public $notification;
    public $layout = '//layouts/admin';
    public $defaultAction = 'audit';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            
           array('allow',
                'actions'=>array(
                    'index',
                    'audit',
                    ),
                'expression'=>'(Yii::app()->user->isSuperAdmin())',
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
     * AUDIT ACTIONS
     * This section contains everything required for the audit section of the admin
     * 
     * 
     */
    public function actionAudit(){
        
        /*
        if(empty($perPage)){
            $perPage = Yii::app()->params['auditAdmin']['perPage'];
        }
        $user = new eUser('searchAudit');
        $auditStart = new eAudit('search');
        $auditEnd = new eAudit('search');
        if(isset($_POST['eUser']) || isset($_GET['page'])){
            $user->attributes=$_POST['eUser'];
            $auditStart->created_on = $_POST['eAudit']['created_on'];
            $auditEnd->created_on = $_POST['eAudit']['end_time'];
            $valid = $user->validate();
            $valid = $auditStart->validate();
            $valid = $auditEnd->validate();
            if($valid){
                $criteria = new CDbCriteria;
                $criteria->condition = 'username like "%'.$user->username.'%"';
                if($auditStart->created_on != ''){
                    $criteria->condition .= ' and t.created_on >= "'.$auditStart->created_on.'"';
                }
                if($auditEnd->created_on != ''){
                    $criteria->condition .= ' and t.created_on <= "'.$auditEnd->created_on.'"';
                }
                $criteria ->order = 't.created_on desc';
                $pages = new CPagination(eAudit::model()->with('user')->count($criteria));
                $pages->pageSize = $perPage;
                $pages->applyLimit($criteria);
                $audits = eAudit::model()->with('user')->findAll($criteria);
                foreach ($audits as $audit) {
                    $auditsTranslated[] = AuditUtility::translate($audit);
                }
            }
        }
        $this->render('index', array(
            'audits' => $auditsTranslated,
            'user' => $user,
            'auditStart' => $auditStart,
            'auditEnd' => $auditEnd,
            'pages' => $pages,
        ));
         * 
         */
        
        $audits = new eAudit('search'); 
        $audits->unsetAttributes();
        
        if (isset($_GET['eAudit'])) {
            $audits->attributes = $_GET['eAudit'];
        }
        
        $this->render('index', array(
            'audits' => $audits,
        ));
    }
}