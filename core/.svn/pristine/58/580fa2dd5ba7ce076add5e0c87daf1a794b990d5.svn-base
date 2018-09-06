<?php

class AdminEmailController extends Controller {

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
                    'template'
                ),
                'expression' => '(Yii::app()->user->isAdmin())',
            ),
        );
    }

    function init() {
        parent::init();
        Yii::app()->setComponents(array('errorHandler' => array('errorAction' => 'admin/error',)));
        $this->user = ClientUtility::getUser();
        $this->notification = eNotification::model()->orderDesc()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
    }

    public function actionIndex() {
        $emailTemplates = eEmailTemplate::model()->findAll();
        $this->render('index', array(
            'emailTemplates' => $emailTemplates,
        ));
    }

    public function actionTemplate($name) {
        $emailTemplate = eEmailTemplate::model()->findByAttributes(array('name' => $name));
        if (empty($emailTemplate)) {
            Yii::app()->user->setFlash('error', 'Template not found');
            $this->redirect('/adminEmail');
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-email-form') {
            echo CActiveForm::validate(array());
            Yii::app()->end();
        }
        if (isset($_POST['eEmailTemplate'])) {
            $emailTemplate->attributes = $_POST['eEmailTemplate'];
            $emailTemplateClient = eEmailTemplateClient::model()->findByAttributes(array('name' => $name));
            if (empty($emailTemplateClient)) {
                $emailTemplateClient = new eEmailTemplateClient();
                $emailTemplateClient->attributes = $emailTemplate->attributes;
            } else {
                $emailTemplateClient->attributes = $emailTemplate->attributes;
            }
            $emailTemplateClient->save();
            Yii::app()->user->setFlash('success', "Email Saved!");
            $this->redirect('/adminEmail');
        }
        $this->render('template', array(
            'emailTemplate' => $emailTemplate
        ));
    }

    public function actionImageUpload() {
        $file = CUploadedFile::getInstanceByName("file");
        if (empty($file)) {
            echo json_encode(array("error" => 'file not found'));
            return;
        }
        $size = getimagesize($file->getTempName());
        if (empty($size)) {
            echo json_encode(array("error" => 'file not correct'));
            return;
        }
        $valid_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
        if (!in_array($size[2], $valid_types)) {
            echo json_encode(array("error" => 'file not vailde'));
            return;
        }
        $fileName = 'ET_' . uniqid('', true) . "." . $file->getExtensionName();
        $file->saveAs(Yii::app()->params['paths']['image'] . '/' . $fileName);
        echo json_encode(array("filelink" => Yii::app()->request->getBaseUrl(true) . '/' . basename(Yii::app()->params['paths']['image']) . '/' . $fileName));
    }
}

?>
