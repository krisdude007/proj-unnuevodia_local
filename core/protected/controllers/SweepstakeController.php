<?php

class SweepstakeController extends Controller {

    public $layout = '//layouts/main';

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();
    }

    public function actionAjaxGetData() {
        $data = array();
        $sweepstake = eSweepStake::model()->current()->find();//->active()
        if (is_null($sweepstake)) {
            echo json_encode(array('success' => 'false'));
            return;
        }
        else{
            $sweepstakeuser = eSweepStakeUser::model()->findByAttributes(array('sweepstake_id'=>$sweepstake->id,'user_id'=>Yii::app()->user->getId()));
            if(is_null($sweepstakeuser)){
                $data['id'] = $sweepstake->id;
                $data['title'] = $sweepstake->title;
                $data['content'] = preg_replace("/\{id\}/", $sweepstake->id, $sweepstake->content);
                $data['rules'] = $sweepstake->rules;
                echo json_encode($data);
                return;
            }
            echo json_encode(array('success' => 'false'));
        }
    }
    
    public function actionAjaxSetData() {// logined user should be
        if (Yii::app()->user->isGuest) {
            echo json_encode(array('success' => 'false'));
            return;
        }
        if (empty($_POST['sweepstake_id'])) {
            echo json_encode(array('success' => 'false'));
            return;
        }
        $sweepstakeuser = eSweepStakeUser::model()->findByAttributes(array('sweepstake_id'=>$_POST['sweepstake_id'],'user_id'=>Yii::app()->user->getId()));
        if(is_null($sweepstakeuser)){
            $sweepstakeuser = new eSweepStakeUser();
            $sweepstakeuser->sweepstake_id = $_POST['sweepstake_id'];
            $sweepstakeuser->user_id = Yii::app()->user->getId();                        
        }
        $sweepstakeuser->accepted = $_POST['accepted'];
        $sweepstakeuser->save();
        echo json_encode(array('success' => 'true'));
        return;
    }

}

?>
