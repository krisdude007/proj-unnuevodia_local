<?php

class AdminBannerController extends Controller {

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
                    //BANNER ACTIONS
                    'index',
                    'upload',
                    'ajaxremove',
                ),
                'expression' => '(Yii::app()->user->isAdmin())',
            ),
            array('allow',
                'actions' => array(
                    'ajaxAddClick',
                ),
                'users' => array('*'),
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
        if (empty(Yii::app()->params['banner_dimension']))
            Yii::app()->params['banner_dimension'] = '660x300';
    }

    public function actionUpload() {
        $model = new FormBannerUpload;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banner-upload-form') {
            echo CActiveForm::validate(array());
            Yii::app()->end();
        }
        if (!isset($_POST['FormBannerUpload'])) {
            $this->redirect('/adminBanner/index');
        }
        $model->attributes = $_POST['FormBannerUpload'];
        $model->validate();


        foreach ($_POST['FormBannerUpload'] as $key => $value) {
            $no = preg_replace("/[^0-9]/", "", $key);
            $name = "banner".$no;
            if($key == "eBanner".$no){
                $banner = eBanner::model()->findByPk($name);
                if (empty($banner)) {
                    $banner = new eBanner();
                    $banner->name = $name;
                }
                //reset count to 0 when url change.
                if(!empty($banner->url) && $banner->url != $_POST['FormBannerUpload'][$key]['url'])
                    $banner->no_click = 0;
                $banner->url = $_POST['FormBannerUpload'][$key]['url'];
                $banner->save();
                continue;
            }
            if($key == "file".$no){
                $model->$key = CUploadedFile::getInstance($model, $key);
                if (empty($model->$key))//file not selected
                    continue;
                list($width, $height, $type, $attr) = getimagesize($model->$key->getTempName());
                if ($type !== 3) {//file not png
                    $model->addError($key, 'Type must be .' . Yii::app()->params['custom_params']['banner_extension']);
                    continue;
                }
                if ($width . 'x' . $height !== Yii::app()->params['banner_dimension']) {//file not correct width x height
                    $model->addError($key, 'Size must be ' . Yii::app()->params['banner_dimension']);
                    continue;
                }
                $fileName =  Yii::app()->params['custom_params']['banner_prefix'] . '_' . $key . "." . Yii::app()->params['custom_params']['banner_extension'];
                $model->$key->saveAs(Yii::app()->params['paths']['image'] . '/' .$fileName);

                $banner = eBanner::model()->findByPk($name);
                if (empty($banner)) {
                    $banner = new eBanner();
                    $banner->name = $name;
                }
                $banner->filename = $fileName;
                $banner->save();
            }
        }
        Yii::app()->user->setState('model', $model);
        $this->redirect('/adminBanner/index');
    }

    public function actionAjaxRemove() {
        if (empty($_POST['name'])) {
            echo(json_encode(array('status' => 0)));
            Yii::app()->end();
        }
        $banner = eBanner::model()->findByPk($_POST['name']);
        if(empty($banner)){
            echo(json_encode(array('status' => 0)));
            Yii::app()->end();
        }
        $filename = $banner->filename;
        if (!unlink(Yii::app()->params['paths']['image'] . '/' . $filename)) {
            echo(json_encode(array('status' => 0)));
            Yii::app()->end();
        }
        $banner->no_click = 0;
        $banner->filename = null;
        $banner->save();
        echo(json_encode(array('status' => 1)));
    }

    public function actionAjaxAddClick() {
        if (empty($_POST['name'])) {
            echo(json_encode(array('status' => 0)));
            Yii::app()->end();
        }
        $banner = eBanner::model()->findByPk($_POST['name']);
        if(empty($banner)){
            echo(json_encode(array('status' => 0)));
            Yii::app()->end();
        }
        $banner->no_click = $banner->no_click + 1;
        $banner->save();
        echo(json_encode(array('status' => 1)));
    }

    public function actionIndex() {
        //$bannerImages = BannerUtility::getBanners();
        $banners = eBanner::model()->findAll(array('order'=>'name')); //current banners on table
        $model = Yii::app()->user->getState('model'); //banner upload form
        Yii::app()->user->setState('model', null);
        if(empty($model)){
            $model = new FormBannerUpload;
        }
        if (empty($banners)) {
            $model->eBanner1 = new eBanner();
            $model->eBanner2 = new eBanner();
            $model->eBanner3 = new eBanner();
            $model->eBanner4 = new eBanner();
            $model->eBanner5 = new eBanner();
            $model->eBanner6 = new eBanner();
            $model->eBanner7 = new eBanner();
            $model->eBanner8 = new eBanner();
            $model->eBanner9 = new eBanner();
            $model->eBanner10 = new eBanner();
        }
        else{
            foreach($banners as $banner){
                $no = preg_replace("/[^0-9]/", "", $banner->name);
                $name = "eBanner".$no;
                $model->$name = $banner;
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

}

