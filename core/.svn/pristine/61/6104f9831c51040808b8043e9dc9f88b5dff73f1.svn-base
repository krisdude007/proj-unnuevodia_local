<?php

class VideoController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $ticker;

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
            $this->ticker = new eTicker();
        }
    }

    public function actionVideoUpload($id = 0) {

        if (Yii::app()->user->isGuest) {
            $this->redirect('/login');
        }

        $uploadvideo = new FormVideoUpload;
        if ($id == 0) {
            $questionModel = eQuestion::model()->video()->current()->find();
            $question = $questionModel->question;
            $uploadvideo->question_id = $id = $questionModel->id;
        } else {
            $uploadvideo->question_id = $id;
        }
        $uploadvideo->is_ad = 0;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'video-uploader-form') {
            echo CActiveForm::validate(array($uploadvideo));
            Yii::app()->end();
        }

        if (isset($_POST['FormVideoUpload'])) {
            $uploadvideo->attributes = $_POST['FormVideoUpload'];
            $uploadvideo->video = CUploadedFile::getInstance($uploadvideo, 'video');
            if ($uploadvideo->validate()) {

                $encoderResult = VideoUtility::encode(Yii::app()->params['video']['filePrefix'], $uploadvideo->video->extensionName, $uploadvideo->video);

                // add record
                $record = array();
                $record['filename'] = $encoderResult['filename'];
                $record['thumbnail'] = $encoderResult['filename'];
                if ($uploadvideo->question_id != '0') {
                    $record['question_id'] = $uploadvideo->question_id;
                }

                $record['arbitrator_id'] = Yii::app()->user->getId();
                $record['user_id'] = Yii::app()->user->getId();
                $record['processed'] = 1;
                $record['source'] = 'upload';
                $record['title'] = html_entity_decode($uploadvideo->title); // to remove html entities in title
                $record['description'] = $uploadvideo->description;

                $record['view_key'] = eVideo::generateViewKey();
                $record['duration'] = $encoderResult['duration'];
                $record['watermarked'] = $encoderResult['watermarked'];

                $record['frame_rate'] = $encoderResult['fileInfo']['video']['frame_rate'];
                $inserted = eVideo::insertRecord($record);

                $autoApprove = eAppSetting::model()->findByAttributes(Array('attribute' => 'auto_approve_submitted_videos'));
                if ($autoApprove->value) {
                    $inserted->status = 'accepted';
                    if (Yii::app()->params['video']['useExtendedFilters']) {
                        $inserted->extendedStatus['accepted'] = true;
                        $inserted->extendedStatus['new_tv'] = true;
                    }
                } else {
                    $inserted->status = 'new';
                    if (Yii::app()->params['video']['useExtendedFilters']) {
                        $inserted->extendedStatus['new'] = true;
                        $inserted->extendedStatus['new_tv'] = true;
                    }
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
                    $inserted->save();
                    $this->redirect('/video/thanks');
                } else {
                    Yii::app()->user->setFlash('error', Yii::app()->params['custom_params']['video_insertrecord_error']);
                }
            } else {
                Yii::app()->user->setFlash('error', Yii::app()->params['custom_params']['video_encode_error']);
            }
        }
        $this->render('videoupload', array(
            'uploadvideo' => $uploadvideo,
        ));
    }

    protected function encode($id) {
        $video = eVideo::model()->findByPK($id);
        $videofile = Yii::app()->params['paths']['video'] . "/{$video->filename}" . Yii::app()->params['video']['preExt'];
        if (file_exists($videofile)) {

            $videooutfile = preg_replace('/' . Yii::app()->params['video']['preExt'] . '$/', Yii::app()->params['video']['postExt'], $videofile);
            $videooggfile = preg_replace('/' . Yii::app()->params['video']['preExt'] . '$/', '.ogg', $videofile);
            //$duration = DateTimeUtility::secsToTimecode(VIDEO_DURATION) . ".00";
            $durationArray = VideoUtility::getVideoDuration($videofile);
            $durations = explode('.', $durationArray[2]);
            $duration = 60 * 60 * $durationArray[0] + 60 * $durationArray[1] + round($durations[0]);
            $watermarkVideo = eAppSetting::model()->findByAttributes(Array('attribute' => 'water_mark_on_video'));
            $watermark = "";
            if ($watermarkVideo->value == 1) {
                $watermark = $_SERVER['DOCUMENT_ROOT'] . Yii::app()->params['video']['watermark'];
            }
            $videoEncoded = VideoUtility::ffmpegFlvToMp4($videofile, $videooutfile, $duration, $watermark);
            //$videoEncodedOgg = VideoUtility::ffmpegFlvToOgg($videofile, $videooutfile, $duration, $watermark);

            if ($videoEncoded) {

                // create gif for preview
                $gifName = Yii::app()->params['paths']['video'] . "/{$video->filename}.gif";
                VideoUtility::ffmpegFlvToGif($videofile, $gifName);

                $video->duration = $duration;
                $video->processed = 1;
                $video->watermarked = (file_exists($watermark)) ? 1 : 0;
                $video->save();
            }
        }
    }

    protected function queue_encode($id) {
        QueueUtility::queue('video_encode', [
            'client_name' => Yii::app()->params['client'],
            'video_id' => $id
        ]);
    }

    protected function download($id) {
        $video = eVideo::model()->findByPK($id);
        $videofile = Yii::app()->params['paths']['video'] . "/{$video->filename}" . Yii::app()->params['video']['preExt'];
        if (!file_exists($videofile)) {
            $videofile = Yii::app()->params['paths']['video'] . "/{$video->user_id}_" . time() . Yii::app()->params['video']['preExt'];
            $conn_id = ftp_connect(Yii::app()->params['wowza']['ip']);
            $login_result = ftp_login($conn_id, Yii::app()->params['wowza']['user'], Yii::app()->params['wowza']['password']);
            $chdir = ftp_chdir($conn_id, Yii::app()->params['wowza']['path'] . "/uid_{$video->user_id}");
            ftp_pasv($conn_id, true);
            $get = ftp_get($conn_id, $videofile, "{$video->filename}" . Yii::app()->params['video']['preExt'], FTP_BINARY);
            ftp_close($conn_id);
            $start = DateTimeUtility::secsToTimecode(1);
            $imagefile = str_replace(Yii::app()->params['video']['preExt'], Yii::app()->params['video']['imageExt'], $videofile);

            // generatae thumbnail from video
            VideoUtility::ffmpegGenerateThumbFromVideo($videofile, $imagefile, $start);

            $video->thumbnail = $video->filename = basename(str_replace(Yii::app()->params['video']['preExt'], '', $videofile));
            $video->setScenario('download');
            $video->save();
        }
    }

    public function actionIndex($order = 'recent') {

        $criteria = new CDbCriteria();
        if (Yii::app()->params['pagination']['enablePagination'] == true) {
            $limit = 6;
            $total = eVideo::model()->with('user')->accepted()->count();

            $pages = new CPagination($total);
            $pages->setPageSize(Yii::app()->params['pagination']['listPerPage']);
            $pages->applyLimit($criteria);
        } else {
            $limit = 48;
        }

        switch ($order) {
            case 'recent':
                $videos = eVideo::model()->with('user')->accepted()->recent()->findAll($criteria);
                break;
            default:
                $videos = eVideo::model()->getVideosOrderBy($order, $limit);
                break;
        }
        $sweepstake = null;
        $sweepstakeuser = null;
        if (Yii::app()->params['enableSweepstakes']) {
            $sweepstake = eSweepStake::model()->current()->find(); //->active()
            if (!is_null($sweepstake)) {
                $sweepstakeuser = eSweepStakeUser::model()->findByAttributes(Array('sweepstake_id' => $sweepstake->id, 'user_id' => Yii::app()->user->getId()));
            }
        }

            $arr = array(
                'videos' => $videos,
                'sweepstake' => $sweepstake,
                'sweepstakeuser' => $sweepstakeuser,
            );

            if (Yii::app()->params['pagination']['enablePagination'] == true) {
                $arr['pages'] = $pages;
                $arr['page_size'] = Yii::app()->params['pagination']['listPerPage'];
                $arr['items_count'] = $total;
            }

        $this->render('index', $arr);
    }

    public function actionPlay($view_key) {
        if ($video = eVideo::model()->with('user', 'brightcoves')->accepted()->findByAttributes(array('view_key' => $view_key))) {
            $user = eUser::model()->findByPK($video->user_id);
            $brightcove = eBrightcove::model()->findByAttributes(Array('video_id' => $video->id));
            $countAndState = '';
            if (!empty($brightcove) && !empty($video)) {
                $countAndState = BrightcoveUtility::getPlayCountAndItemState($video);
                $brightcove->tot_views = empty($countAndState->playsTotal) ? 0 : $countAndState->playsTotal;
                $brightcove->save();
            }
            if (!Yii::app()->user->isGuest) {
                $videoView = new eVideoView;
                $videoView->user_id = Yii::app()->user->getId();
                $videoView->video_id = $video->id;
                $videoView->save();
            } else {
                $videoView = new eVideoView;
                $videoView->user_id = 0;
                $videoView->video_id = $video->id;
                $videoView->save();
            }


            if (isset($_GET['fb_action_ids'])) {
                unset($_GET['fb_action_ids']);
            }
            if (isset($_GET['fb_action_types'])) {
                unset($_GET['fb_action_types']);
            }
            if (isset($_GET['fb_source'])) {
                unset($_GET['fb_source']);
            }
            if (isset($_GET['fb_aggregation_id'])) {
                unset($_GET['fb_aggregation_id']);
            }

            $this->render('play', array(
                'video' => $video,
                'user' => $user,
                'countAndState' => $countAndState,
                    )
            );
        } else {
            throw new CHttpException(404, 'No video found!');
        }
    }

    public function actionCapture() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createURL('site/index'));
        }
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $video = eVideo::model()->findByAttributes(Array('user_id' => Yii::app()->user->getId(), 'filename' => $file));
        if (is_null($video)) {

            $record = array();
            $record['filename'] = $file;
            $record['thumbnail'] = $file;
            $record['question_id'] = $qID;
            $record['source'] = $source;
            $record['arbitrator_id'] = Yii::app()->user->getId();
            $record['user_id'] = Yii::app()->user->getId();
            $inserted = eVideo::insertRecord($record);
            $video = $inserted;
            echo $video->id;
        } else {
            echo $video->id;
        }
    }

    public function actionProcess($id = 0) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createURL('site/index'));
        }
        if ($id == 0) {
            $this->redirect(Yii::app()->createUrl('/record'));
        }
        $video = eVideo::model()->findByPK($id);
        if ($video->user_id != Yii::app()->user->getId()) {
            $this->redirect(Yii::app()->createUrl('/record'));
        }
        if (is_null($video) || $video->processed == 1) {
            $this->redirect(Yii::app()->createUrl('/record'));
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'video-process-form') {
            echo CActiveForm::validate(array($video));
            Yii::app()->end();
        }
        $this->download($id);
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

                    if (Yii::app()->params['video']['useExtendedFilters']) {
                        $this->extendedStatus['accepted'] = true;
                        $this->extendedStatus['new_tv'] = true;
                    }
                }

                // save the video
                $video->save();

                if ($video->status == 'accepted') {
                    AuditUtility::save($this, false, Array('action' => 'autoApprove', 'type' => 'video', 'id' => $video->id));
                }

                $this->encode($video->id);

                if (Yii::app()->Paypal->active) {
                    $paypal = PaymentUtility::paypal($video);
                    if ($paypal['response'] == 'success') {
                        $this->redirect($paypal['url']);
                    } else {
                        var_dump($paypal);
                        //$this->redirect(Yii::app()->createURL('/thanks'));
                    }
                } else {
                    $this->redirect(Yii::app()->createURL('/thanks'));
                }
                return true;
            }
        }
        $this->render('process', array(
            'model' => $video,
            'question_id' => $video->question_id,
            'videoInfo' => Array(
                'videofile' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->filename}" . Yii::app()->params['video']['preExt'],
                'image' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->thumbnail}" . Yii::app()->params['video']['imageExt'],
                'width' => 426,
                'height' => 240,
            ),
                )
        );
    }

    public function actionThanks() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createURL('site/index'));
        }
        $videos = eVideo::model()->findAllByAttributes(Array('user_id' => Yii::app()->user->getId()));
        $questions = eQuestion::model()->video()->current()->findAll();
        foreach ($videos as $video) {
            $user_answered[] = $video->question_id;
        }
        foreach ($questions as $question) {
            if (in_array($question->id, $user_answered)) {
                continue;
            } else {
                break;
            }
        }
        $question = (is_null($question)) ? eQuestion::model()->video()->current()->find() : $question;
        $sweepstake = null;
        $sweepstakeuser = null;
        if (Yii::app()->params['enableSweepstakes']) {
            $sweepstake = eSweepStake::model()->current()->find();
            if (!is_null($sweepstake)) {
                $sweepstakeuser = eSweepStakeUser::model()->findByAttributes(Array('sweepstake_id' => $sweepstake->id, 'user_id' => Yii::app()->user->getId()));
            }
        }
        $this->render('thanks', array(
            'question' => $question,
            'sweepstake' => $sweepstake,
            'sweepstakeuser' => $sweepstakeuser,
        ));
    }

    public function actionAjaxPreviewVideo() {
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        $video = eVideo::model()->findByPK($vID);
        $videoInfo = Array(
            'videofile' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->filename}" . Yii::app()->params['video']['preExt'],
            'image' => '/' . basename(Yii::app()->params['paths']['video']) . "/{$video->thumbnail}" . Yii::app()->params['video']['imageExt'],
            'width' => 426,
            'height' => 240,
        );
        if (file_exists(Yii::app()->params['paths']['video'] . "/{$video->filename}" . '.png')) {
            $ret['html'] = $this->renderPartial('_videoPlayer', array(
                'videoInfo' => $videoInfo,
                    ), true
            );
            $ret['status'] = 'COMPLETED';
        } else {
            $ret['html'] = 'Rendering Video...';
            $ret['status'] = 'WAIT';
        }
        echo json_encode($ret);
    }

    public function actionAjaxRate() {
        $this->layout = false;

        foreach ($_POST as $k => $v) {
            $$k = $v;
        }
        if (!Yii::app()->user->isGuest) {
            $videoRate = eVideoRating::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'video_id' => $object_id));
            $videoRate = (is_null($videoRate)) ? new eVideoRating() : $videoRate;
            $videoRate->user_id = Yii::app()->user->getId();
            $videoRate->video_id = $object_id;
            $videoRate->rating = $rating;
            $videoRate->save();
            $video = eVideo::model()->findByPK($object_id);
            echo json_encode(array('avg' => $video->rating, 'votes' => sizeof($video->videoRatings)));
        }
    }

    public function actionRecord($id = 0) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('user/login'));
        } else {
            $user = eUser::model()->findByPK(Yii::app()->user->getId());
            if (!$user->terms_accepted) {
                $this->redirect(Yii::app()->createURL('/you/terms'));
            }
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
                $this->redirect(Yii::app()->createURL('site/index'));
            }
        }
    }

    public function actionTwittercard($key = false) {
        if (!$key) {
            $this->redirect(Yii::app()->createURL('/'));
        } else {
            $video = eVideo::model()->findByAttributes(Array('view_key' => $key));
            $player = (isset($video->brightcoves[0]->brightcove_id)) ? '_brightcovePlayer' : '_fallbackPlayer';
            $player = '_fallbackPlayer'; //Brightcove is puking for some reason
            $this->renderPartial($player, array(
                'video' => $video,
                'width' => 360,
                'height' => 200
                    )
            );
            $path = Yii::app()->params['paths']['video'];
        }
    }

}

