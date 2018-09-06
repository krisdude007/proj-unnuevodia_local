<?php

class AdminEntityController extends Controller {

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
                    'index', 'contest', 'contestants', 'contestantsModal', 'ajaxAddContestant', 'ajaxDeleteContestant',
                    'ajaxSetEntityAvatar',
                    'ajaxSetEntityStatus',
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

    public function actionAjaxSetEntityAvatar() {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $update = eImage::model()->updateAll(Array('is_avatar' => 0), "entity_id = {$entity}");
        $image = eImage::model()->findByPK($image);
        $image->is_avatar = 1;
        $image->save();
    }

    public function actionAjaxSetEntityStatus() {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $entity = eEntity::model()->findByPK($id);
        $entity->active = $value;
        $entity->save();
    }

    public function actionAjaxAddContestant() {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $entityAnsewer = new eEntityAnswer();
        $entityAnsewer->user_id = $id;
        $entityAnsewer->poll_id = $poll_id;
        $entityAnsewer->eliminated = 0;
        if ($entityAnsewer->validate($entityAnsewer)) {
            $entityAnsewer->save();
        }
        echo json_encode(array('error' => $entityAnsewer->getErrors()));
    }

    public function actionAjaxDeleteContestant() {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        eEntityAnswer::model()->deleteByPk($id);
    }

    //create new entity
    //update existing entity by id
    //get entities and a selected entity(id)
    public function actionIndex($id = NULL) {
        if (is_null($id)) {
            $entity = new eEntity();
            $twitter = new eEntityTwitter();
            $facebook = new eEntityFacebook();
        } else {
            $entity = eEntity::model()->with('images')->findByPK($id);
            if (is_null($entity)) {
                $entity = new eEntity();
                $twitter = new eEntityTwitter();
                $facebook = new eEntityFacebook();
            } else {
                $twitter = eEntityTwitter::model()->findByAttributes(Array('entity_id' => $entity->id));
                $facebook = eEntityFacebook::model()->findByAttributes(Array('entity_id' => $entity->id));
            }
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-entity-form') {
            echo CActiveForm::validate(array($entity, $twitter, $facebook));
            Yii::app()->end();
        }
        $image = new eImage();
        if (isset($_POST['eEntity'])) {
            $entity->attributes = $_POST['eEntity'];
            $twitter->attributes = $_POST['eEntityTwitter'];
            $facebook->attributes = $_POST['eEntityFacebook'];
            if ($entity->validate()) {
                $entity->save();
                $twitter->entity_id = $entity->id;
                $twitter->save();
                $facebook->entity_id = $entity->id;
                $facebook->save();
                Yii::app()->user->setFlash('success', "Entity Added!");
                if (isset($_POST['eImage'])) {
                    $image->attributes = $_POST['eImage'];
                    $image->image = CUploadedFile::getInstance($image, 'image');
                    $image->title = 'Photo';
                    $image->description = 'Entity Avatar';
                    $image->source = 'entity';
                    $image->to_facebook = 0;
                    $image->to_twitter = 0;
                    $image->status = 'accepted';
                    $image->arbitrator_id = Yii::app()->user->getId();
                    $image->is_avatar = 1;
                }
                if ($image->validate()) {
                    preg_match('/\..{3,4}$/', $image->image->getName(), $matches);
                    $filetype = $matches[0];
                    $image->filename = $filename = "{$entity->id}_entity_" . uniqid('', true) . $filetype;
                    $image->image->saveAs(Yii::app()->params['paths']['avatar'] . "/{$filename}");
                    $image->entity_id = $entity->id;
                    $update = eImage::model()->updateAll(Array('is_avatar' => 0), "entity_id = {$entity->id}");
                    $image->save();
                }
                $this->redirect('/admin/entity');
            }
        }
        if (is_null($id)) {
            $entity = new eEntity();
            $twitter = new eEntityTwitter();
            $facebook = new eEntityFacebook();
        } else {
            $entity = eEntity::model()->with('images')->findByPK($id);
            if (is_null($entity)) {
                $entity = new eEntity();
                $twitter = new eEntityTwitter();
                $facebook = new eEntityFacebook();
            } else {
                $twitter = eEntityTwitter::model()->findByAttributes(Array('entity_id' => $entity->id));
                $facebook = eEntityFacebook::model()->findByAttributes(Array('entity_id' => $entity->id));
            }
        }
        $entities = eEntity::model()->with('images:isAvatar', 'entityTwitters', 'entityFacebooks')->findAll();
        $this->render('index', array(
            'entity' => $entity,
            'image' => $image,
            'twitter' => $twitter,
            'facebook' => $facebook,
            'entities' => $entities,
        ));
    }

    public function actionContest($id = null) {
        $poll = is_null($id) ? new ePoll() : (ePoll::model()->entityType()->findByPk($id));
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-entity-form') {
            echo CActiveForm::validate(array($poll));
            Yii::app()->end();
        }
        if (!empty($_POST['ePoll'])) {
            $poll->attributes = $_POST['ePoll'];
            $poll->user_id = Yii::app()->user->getId();
            $poll->type = "entity";
            if ($poll->validate()) {
                $poll->save();
                $this->redirect('/admin/entity/contest');
            }
        }
        $polls = ePoll::model()->entityType()->with('entityAnswers', 'entityTally')->findAll();
        $this->render('contest', array(
            'polls' => $polls,
            'poll' => $poll,
        ));
    }

    public function actionContestants($id, $e = 0) {
        if (!empty($_POST['eEntityAnswer'])) {
            foreach ($_POST['eEntityAnswer'] as $eEntityAnswerId => $entityAnswer) {
                $model = eEntityAnswer::model()->findByPk($eEntityAnswerId);
                $model->attributes = $entityAnswer;
                $model->biography = $entityAnswer['biography'];
                if ($model->validate()) {
                    $model->save();
                }
            }
        }
        
        if($e == 1) {
            $eliminated = ":orderNotEliminatedASC";
        }
        else { 
            $eliminated = "";
        }
        
        $poll = ePoll::model()->entityType()->with("entityAnswers{$eliminated}", 'entityAnswers.eUser:orderLastNameAsc.avatarImages')->findByPk($id);
        if (empty($poll)) {
            $this->redirect('/adminEntity/contest');
            return;
        }
        $this->render('contestants', array(
            'id' => $id,
            'poll' => $poll,
        ));
    }

    public function actionContestantsModal() {
        $this->layout = false;
        $users = new eUser('search');
        $users->unsetAttributes();
        if (isset($_GET['eUser'])) {
            $users->attributes = $_GET['eUser'];
        }
        /*
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-user-form') {
            echo json_encode(
                    CMap::mergeArray(
                            json_decode(CActiveForm::validate($user), true), json_decode(CActiveForm::validate($userEmail), true), json_decode(CActiveForm::validate($userLocation), true), json_decode(CActiveForm::validate($userPhoto), true)
                    )
            );
            Yii::app()->end();
        }
        $user = new eUser;
        $userEmail = new eUserEmail;
        $userLocation = new eUserLocation;
        $userPhoto = new eUserPhoto;
        $user->setScenario('register');
        $userEmail->setScenario('register');
        $userLocation->setScenario('register');
        if (isset($_POST['eUser'])) {
            $user->attributes = $_POST['eUser'];
            $userEmail->attributes = $_POST['eUserEmail'];
            $userLocation->attributes = $_POST['eUserLocation'];
            $userPhoto->attributes = $_POST['eUser'];
            //$user->username = $userEmail->email;
            $userPhoto->image = CUploadedFile::getInstance($userPhoto, 'image');
            $flash = ($user->isNewRecord) ? 'Add' : 'Updat';
            $user->birthday = $user->birthYear . '-' . $user->birthMonth . '-' . $user->birthDay;
            if ($user->validate()) {
                $user->save();
                // TODO: more extensive validation; these extra permissions can only exist for less than super admin and greater than user.
                $permissions = eUserPermission::model()->deleteAllByAttributes(Array('user_id' => $user->id));
                if (!empty(Yii::app()->request->getPost('permissions'))) {
                    foreach (Yii::app()->request->getPost('permissions') as $k => $v) {
                        $permission = new eUserPermission;
                        $permission->user_id = $user->id;
                        $permission->controller = $v;
                        $permission->save();
                    }
                }
                $userEmail->user_id = $user->id;
                $userEmail->type = 'primary';
                $userLocation->user_id = $user->id;
                $userLocation->type = 'primary';
                $userPhoto->user_id = $user->id;
                $userPhoto->type = 'primary';
                if ($userEmail->validate() && $userLocation->validate() && $userPhoto->validate()) {
                    $userEmail->save();
                    $userLocation->save();
                    if (!empty($userPhoto->image)) {
                        if ($userPhoto->validate()) {
                            preg_match('/\..{3,4}$/', $userPhoto->image->getName(), $matches);
                            $filetype = $matches[0];
                            $userPhoto->filename = $filename = "{$user->id}_" . uniqid('', true) . $filetype;
                            $userPhoto->image->saveAs(Yii::app()->params['paths']['avatar'] . "/{$filename}");
                            $userPhoto->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('success', "User {$flash}ed!");
            } else {
                Yii::app()->user->setFlash('error', "Error {$flash}ing User!");
            }
        }
         */
        $this->render('contestantsModal', array(
            'users' => $users,
            //'user' => $user,
            //'userEmail' => $userEmail,
            //'userPhoto' => $userPhoto,
            //'userLocation' => $userLocation,
        ));
    }

}