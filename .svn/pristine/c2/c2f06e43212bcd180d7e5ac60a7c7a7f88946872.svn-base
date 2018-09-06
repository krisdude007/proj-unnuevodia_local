<?php

class clientVideoController extends VideoController {

     public function actionRecord($id = 0) {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect(Yii::app()->createUrl('user/login'));
        } else {
            $user = eUser::model()->findByPK(Yii::app()->user->getId());

            if ($id == 0) {
                $questions = eQuestion::model()->video()->current()->findAll();
                foreach ($questions as $q) {
                    $question = $q->question;
                    $id = $q->id;
                }
            } else {
                $questions = eQuestion::model()->findByPK($id);
                $question = $questions->question;
            }
            if (!is_null($question)) {
                $this->render('recorder', array(
                    'question' => $question,
                    'question_id' => $id,
                    'duration' => Yii::app()->params['video']['duration'],
                    'user_id' => Yii::app()->user->getId(),
                    'wowzaip' => Yii::app()->params['wowza']['clientip'],
                        )
                );
            } else {
                $this->redirect('/');
            }
        }
    }

    public function actionVideoUpload($id = 0) {

        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect('/login');
        }

        $uploadvideo = new clientVideoUploadForm;
        if ($id == 0) {
            $question = eQuestion::model()->video()->current()->find();
            $id = $question->id;
        }
        $uploadvideo->question_id = $id;

        $uploadvideo->is_ad = 0;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'video-uploader-form') {
            echo CActiveForm::validate(array($uploadvideo));
            Yii::app()->end();
        }

        if (isset($_POST['clientVideoUploadForm'])) {
            $uploadvideo->attributes = $_POST['clientVideoUploadForm'];
            $uploadvideo->video = CUploadedFile::getInstance($uploadvideo, 'video');
            if ($uploadvideo->validate()) {

                $encoderResult = VideoUtility::encode(Yii::app()->params['upload_title_prefix'], $uploadvideo->video->extensionName, $uploadvideo->video);

                // add record
                $record = array();
                $record['question_id'] = $uploadvideo->question_id;
                $record['filename'] = $encoderResult['filename'];
                $record['thumbnail'] = $encoderResult['filename'];
                if ($uploadvideo->question_id != '0') {
                    $record['question_id'] = $uploadvideo->question_id;
                }

                $record['arbitrator_id'] = Yii::app()->user->getId();
                $record['user_id'] = Yii::app()->user->getId();
                $record['processed'] = 0;
                $record['source'] = 'upload';
                $record['title'] = $uploadvideo->title;
                $record['description'] = $uploadvideo->description;

                $record['view_key'] = eVideo::generateViewKey();
                $record['duration'] = $encoderResult['duration'];
                $record['watermarked'] = $encoderResult['watermarked'];

                $record['frame_rate'] = $encoderResult['fileInfo']['video']['frame_rate'];
                $inserted = eVideo::insertRecord($record);

                $autoApprove = eAppSetting::model()->findByAttributes(Array('attribute' => 'auto_approve_submitted_videos'));
                if ($autoApprove->value) {
                    $inserted->status = 'accepted';
                } else {
                    $inserted->status = 'new';
                }

                // see if user selected share to twitter or facebook
                if ($uploadvideo->to_twitter == '1')
                    if (eUserTwitter::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0)//no connection to twitter
                        $inserted->to_twitter = 0;
                    else {
                        $inserted->to_twitter = 1;
                    }
                if ($uploadvideo->to_facebook == '1')
                    if (eUserFacebook::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0)//no connection to facebook
                        $inserted->to_facebook = 0;
                    else {
                        $inserted->to_facebook = 1;
                    }

                if ($inserted) {
                    $inserted->save(false);
                    $this->redirect(array('/video/finishUpload', 'id' => $inserted->id));
                } else {
                    Yii::app()->user->setFlash('error', Yii::app()->params['video_insertrecord_error']);
                }
            } else {
                Yii::app()->user->setFlash('error', Yii::app()->params['video_encode_error']);
            }
        }
        $this->render('videoupload', array(
            'uploadvideo' => $uploadvideo,
        ));
    }

    public function actionFinishUpload() {
        $video = eVideo::model()->findByPk(Yii::app()->request->getParam('id'));
        if (isset($_POST['eVideo'])) {
            $video->attributes = $_POST['eVideo'];
            if ($video->validate()) {
                // see if user selected share to twitter or facebook
                if ($video->to_twitter == '1') {
                    // check to see if user has connected a twitter account
                    if (eUserTwitter::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0) {
                        // set to_twitter back to false
                        $video->to_twitter = 0;
                    }
                }
                // see if user selected share to twitter or facebook
                if ($video->to_facebook == '1') {
                    // check to see if user has connected a twitter account
                    if (eUserFacebook::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0) {
                        // set to_facebook back to false
                        $video->to_facebook = 0;
                    }
                }
                $autoApprove = eAppSetting::model()->findByAttributes(Array('attribute' => 'auto_approve_submitted_videos'));
                if ($autoApprove->value) {
                    $video->status = 'accepted';
                }
                $video->processed = 1;
                // save the video
                $video->save();

                if ($video->status == 'accepted') {
                    AuditUtility::save($this, false, Array('action' => 'autoApprove', 'type' => 'video', 'id' => $video->id));
                }

                //$this->encode($video->id);

                if (Yii::app()->params['Paypal']['active']) {
                    $paypal = PaymentUtility::paypal($video);
                    if ($paypal['response'] == 'success') {
                        $this->redirect($paypal['url']);
                    }
                } else {
                    $this->redirect(Yii::app()->createURL('/video/thanks', array('upload' => true)));
                }
                return true;
            }
        }
        $this->render('process', array(
            'model' => $video,
            'question_id' => $video->question_id,
            'videoInfo' => Array(
                'videofile' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->filename}" . VIDEO_POST_FILE_EXT,
                'image' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->thumbnail}" . VIDEO_IMAGE_FILE_EXT,
                'width' => 426,
                'height' => 240,
            ),
            'upload' => true,
        ));
    }

}

?>
