<?php

class ContentReportController extends Controller {

    public $layout = '//layouts/main';

    function init() {
        parent::init();
    }

    public function actionAjaxFlag() {
        $this->layout =false;
        if(Yii::app()->user->isGuest){
            echo(json_encode(array('error' => 'You are not logged in')));
            Yii::app()->end();
        }
        if(empty($_POST['tbl']) || empty($_POST['contentId'])){
            echo(json_encode(array('error' => 'Missing value')));
            Yii::app()->end();
        }

        $contentReport = new eContentReport();
        $contentReport->user_id = Yii::app()->user->getId();
        $contentReport->content_tbl = $_POST['tbl'];
        $contentReport->content_id = $_POST['contentId'];

        if(!$contentReport->validate()){
            var_dump($contentReport->getErrors());
            echo(json_encode(array('error' => $contentReport->getErrors())));
            Yii::app()->end();
        }
        $contentReport->save();
        echo(json_encode(array('error' => 0)));
    }

}

?>
